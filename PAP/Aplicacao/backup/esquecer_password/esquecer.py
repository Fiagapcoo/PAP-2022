from kivymd.app import MDApp
from kivy.lang import Builder
from kivy.core.window import Window
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart
import smtplib
import hashlib
from random import randint
import mysql.connector

def random_with_N_digits():
    cod = randint(1000000000, 9999999999)
    print(cod)
    return cod

Window.size = (310,580)
class Esquecer_Password(MDApp):
    def build(self):
        return Builder.load_file("esquecer.kv")


    def envia_email(self):
        print("envia email")

    def email(self):

        user = self.root.ids.user.text
        password = self.root.ids.password.text
        password2 = self.root.ids.password2.text

        if password2 == password and len(password)>8:
            mydb = mysql.connector.connect(
                host="localhost",
                user="root",
                passwd="",
                database="pap")
            cursor = mydb.cursor()
            query = "SELECT * FROM users where username = '" + user + "';"
            cursor.execute(query)
            dados = cursor.fetchall()

            if cursor.rowcount > 0:
                for linha in dados:
                    global send_to_email
                    send_to_email = linha[2]
                    print("enviar email: "+send_to_email)
                    print(type(send_to_email))

                s = random_with_N_digits()

                global verificationcode
                verificationcode = str(s)
                # Email projetojava01@gmail.com
                # Pass javaproject123
                email = "projetojava01@gmail.com"
                password = "javaproject123"
                subject = "Codigo de Verificação"
                message = "Código de verificação: " +verificationcode

                msg = MIMEMultipart()
                msg['From'] = email
                msg['To'] = send_to_email
                msg['Subject'] = subject

                msg.attach(MIMEText(message, 'plain'))

                server = smtplib.SMTP('smtp.gmail.com', 587)
                server.starttls()
                server.login(email, password)
                text = msg.as_string()
                server.sendmail(email, send_to_email, text)
                server.quit()
                self.root.ids.but_verifica.disabled = False
                self.root.ids.cod.disabled = False
                print("Email enviado")
                print("Cód "+verificationcode)
    def muda_senha(self):

        user = self.root.ids.user.text
        cod = self.root.ids.cod.text
        password = self.root.ids.password.text
        password = hashlib.md5(password.encode()).hexdigest()
        if cod == verificationcode:
            mydb = mysql.connector.connect(
                host="localhost",
                user="root",
                passwd="",
                database="pap")
            cursor = mydb.cursor()
            query = "UPDATE users SET password = '"+password+"' WHERE username = '"+user+"';"
            cursor.execute(query)
            print("Password atualizada")

if __name__ == '__main__':

    Esquecer_Password().run()

