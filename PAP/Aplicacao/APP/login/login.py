from kivymd.app import MDApp
from kivy.lang import Builder
from kivy.core.window import Window
import hashlib

import mysql.connector
Window.size = (310,580)



class Login(MDApp):
    def build(self):
        return Builder.load_file("login.kv")

    def login(self):

        username = self.root.ids.user.text
        password = self.root.ids.password.text
        mydb = mysql.connector.connect(
            host="localhost",
            user="root",
            passwd="",
            database="pap"
        )
        cursor = mydb.cursor()



        passe_enc = hashlib.md5(password.encode()).hexdigest()

        query2 = f"SELECT * FROM users where username = '{username}' and password = '{passe_enc}';"
        cursor.execute(query2)

        dados = cursor.fetchall()

        if cursor.rowcount > 0:
            admin = ""
            for linha in dados:
                admin = linha[5]
            if admin == 0 or admin == 1:
                print("logado")
                query_apagar = "DELETE FROM users WHERE fakereport >= 3"
                cursor.execute(query_apagar)
                mydb.commit()


                with open('../auxiliares/users.txt', 'w') as f:
                    f.write(username)

            elif admin == 77 or admin == 918:
                print("Verificação")

        else:
            print("Username or Password invalidos")



Login().run()

