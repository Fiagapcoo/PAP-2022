from kivymd.app import MDApp
from kivy.lang import Builder
from kivy.core.window import Window

from random import randint


from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart
import smtplib

import mysql.connector
Window.size = (310,580)


def random_with_N_digits():
    cod = randint(1000000000, 9999999999)
    print(cod)
    return cod

class Verifica(MDApp):
    def build(self):
        return Builder.load_file("verificacao.kv")
    def email(self):
        global send_to_email
        send_to_email = self.root.ids.email.text
        mydb = mysql.connector.connect(
                  host="localhost",
                  user="root",
                  passwd="",
                  database="pap")
        cursor = mydb.cursor()
        query = "SELECT * FROM users where email = '"+send_to_email+"';"
        cursor.execute(query)
        dados = cursor.fetchall()

        if cursor.rowcount > 0:

            s = random_with_N_digits()

            cod = str(s)
            global verificationcode
            verificationcode= cod
            #Email projetojava01@gmail.com
            #Pass javaproject123
            email = "projetojava01@gmail.com"
            password = "chqqfecphptlicdx"
            subject = "Codigo de Verificação"
            message = "Código de verificação: " + cod

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













    def verificar(self):
        print("Código = a: "+verificationcode)
        mydb = mysql.connector.connect(
                     host="localhost",
                     user="root",
                     passwd="",
                     database="pap")
        cursor = mydb.cursor()
        query = "SELECT * FROM users where email = '"+send_to_email+"';"
        print(send_to_email)
        cursor.execute(query)
        dados = cursor.fetchall()
        cod = self.root.ids.cod.text

        if str(cod) != verificationcode:
           print("Código Invalido")
        else:

                   update = "UPDATE users SET admin = '0' WHERE email = '" + send_to_email + "';"
                   cursor.execute(update)
                   mydb.commit()
                   cursor.close()
                   mydb.close()
                   print("A sua conta foi verificada com sucesso")

if __name__ == '__main__':

    Verifica().run()