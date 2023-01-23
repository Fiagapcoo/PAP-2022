import hashlib
from kivymd.app import MDApp
from kivy.lang import Builder
from kivy.core.window import Window
import re
import mysql.connector
Window.size = (310,580)

class Register(MDApp):
    def build(self):
        return Builder.load_file("register.kv")

    def register(self):

        username = self.root.ids.Username.text
        email = self.root.ids.email.text
        idade = self.root.ids.idade.text
        password = self.root.ids.password.text
        password2 = self.root.ids.password2.text
        try:

            if password2==password:
                mydb = mysql.connector.connect(
                    host="localhost",
                    user="root",
                    passwd="",
                    database="pap"
                )
                cursor = mydb.cursor()
                mydb.autocommit = True


                query = "SELECT * FROM users where username = '" + username + "';"
                cursor.execute(query)
                dados = cursor.fetchall()
                if cursor.rowcount == 0:

                    pattern_email = r'\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b'

                    if re.match(pattern_email, email) and cursor.rowcount == 0:
                        if len(password) > 8:
                           int_idade = int(idade)
                           if int_idade >= 11 and int_idade <= 210:

                                pass_md5  = hashlib.md5(password.encode()).hexdigest()
                                print("Username"+username)
                                print("email"+email)
                                print("Pass"+pass_md5)
                                print("idade"+idade)
                                query_insert = "INSERT INTO users (id, username, email, password, idade, admin, fakereport, dist, autonomia) VALUES (NULL, '" + username + "', '" + email + "', '" + pass_md5 + "', '" + idade + "', '77', '0', '0', '0');"
                                cursor.execute(query_insert)
                                mydb.commit()
                                cursor.close()
                                mydb.close()
                           else:
                               print("A idade invalida")

                        else:
                            print("Password muito curta")
                else:
                    print("Utilizador ja em uso")
        except Exception as e:
            print("Erro:"+e)
            pass

if __name__ == '__main__':

    Register().run()