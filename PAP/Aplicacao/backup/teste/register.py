from kivy.uix.boxlayout import BoxLayout
from kivy.properties import ObjectProperty
from kivy.lang import Builder
import geocoder

import math
from kivymd.app import MDApp

from kivy.core.window import Window
import mysql.connector
from datetime import date

Window.size = (310,580)

def degreesToRadians(degrees):
    return degrees * math.pi / 180

#calculo de geodésico - geodésico - conexão entre 2 pontos numa esfera


#A Terra movimenta-se segundo um movimento geodésico que, no espaço curvo, conforme descrito na Teoria da Relatividade Geral de Einstein, consiste numa aparente trajetória retilínea, mas que na realidade se curva conforme as “dobras” do espaço-tempo.

def distanceInKmBetweenEarthCoordinates(lat1, lon1, lat2, lon2):
    earthRadiusKm = 6371

    dLat = degreesToRadians(lat2 - lat1)
    dLon = degreesToRadians(lon2 - lon1)

    lat1 = degreesToRadians(lat1)
    lat2 = degreesToRadians(lat2)

    a = math.sin(dLat / 2) * math.sin(dLat / 2) + math.sin(dLon / 2) * math.sin(dLon / 2) * math.cos(lat1) * math.cos(lat2)
    c = 2 * math.atan2(math.sqrt(a), math.sqrt(1 - a))

    return earthRadiusKm * c

def listToString(s):
    # initialize an empty string
    str1 = ""

    # traverse in the string
    for ele in s:
        str1 += ele

        # return string
    return str1









class ContentNavigationDrawer(BoxLayout):
    screen_manager = ObjectProperty()
    nav_drawer = ObjectProperty()


class Conhece_Portugal(MDApp):
    def build(self):

        return Builder.load_file("register.kv")

    def locais(self):
        dist_a_ir = 50
        g = geocoder.api.ip("me")

        lat1 = g.lat
        lon1 = g.lng

        mydb = mysql.connector.connect(
            host="localhost",
            user="root",
            passwd="",
            database="pap"
        )
        cursor = mydb.cursor()

        query = "SELECT * FROM local;"
        cursor.execute(query)
        dados = cursor.fetchall()
        local_array = []
        src_local = []
        for local in dados:
            lat2 = local[5]
            lon2 = local[6]
            nome = local[2]
            dir_im = local[7]
            a = distanceInKmBetweenEarthCoordinates(lat1, lon1, lat2, lon2)


            if a < dist_a_ir:
                local_array.append(nome)
                src_local.append(dir_im)
                print(local_array)
                print(src_local)



    def restaurantes(self):
        dist_a_ir = 5
        g = geocoder.api.ip("me")

        lat1 = g.lat
        lon1 = g.lng

        mydb = mysql.connector.connect(
            host="localhost",
            user="root",
            passwd="",
            database="pap"
        )
        cursor = mydb.cursor()

        query = "SELECT * FROM restaurante;"
        cursor.execute(query)
        dados = cursor.fetchall()
        local_array = []
        src_local = []
        for local in dados:
            lat2 = local[5]
            lon2 = local[6]
            nome = local[0]
            dir_im = local[7]
            a = distanceInKmBetweenEarthCoordinates(lat1, lon1, lat2, lon2)

        if a < dist_a_ir:
            local_array.append(nome)
            src_local.append(dir_im)
            print(local_array)
            print(src_local)
        else:
            print("Nada a mostrar")

    def estadia(self):
        dist_a_ir = 5
        g = geocoder.api.ip("me")

        lat1 = g.lat
        lon1 = g.lng

        mydb = mysql.connector.connect(
            host="localhost",
            user="root",
            passwd="",
            database="pap"
        )
        cursor = mydb.cursor()

        query = "SELECT * FROM estadia;"
        cursor.execute(query)
        dados = cursor.fetchall()
        estadia_array = []
        src_estadia = []
        for estadia in dados:
            lat2 = estadia[5]
            lon2 = estadia[6]
            nome = estadia[0]
            dir_im = estadia[7]
            a = distanceInKmBetweenEarthCoordinates(lat1, lon1, lat2, lon2)

        if a < dist_a_ir:
            estadia_array.append(nome)
            src_estadia.append(dir_im)
            print(estadia_array)
            print(src_estadia)
        else:
            print("Nada a mostrar")

    def percursos(self):
        print("d")



    def bike(self):
        local_bike = self.root.ids.local_bike.text

        mydb = mysql.connector.connect(
            host="localhost",
            user="root",
            passwd="",
            database="pap"
        )
        cursor = mydb.cursor()
        mydb.autocommit = True

        with open("../auxiliares/users.txt", "r") as myfile:
            data = myfile.readlines()
        user = listToString(data)
        query = "SELECT autonomia from users where username = '" + user + "';"
        cursor.execute(query)
        dados = cursor.fetchall()
        for linha in dados:
            autonomia = linha[0]
        if autonomia == 0:
            print("ir sem parar")
        else:
            print("parar nas bombas")






















    def conf(self):
        dist = self.root.ids.dist.text
        autonomia = self.root.ids.autonomia.text
        try:
            dist = float(dist)
            autonomia = float(autonomia)

            mydb = mysql.connector.connect(
                host="localhost",
                user="root",
                passwd="",
                database="pap"
            )
            cursor = mydb.cursor()
            mydb.autocommit = True

            with open("../auxiliares/users.txt", "r") as myfile:
                data = myfile.readlines()
            user = listToString(data)


            query_insert = "UPDATE users SET dist = '"+str(dist)+"' WHERE username = '"+user+"';"
            cursor.execute(query_insert)
            query_insert2 = "UPDATE users SET autonomia = '"+str(autonomia)+"' WHERE username = '"+user+"';"
            cursor.execute(query_insert2)

        except Exception as e:
            print("POPUP NUMEROS")
            pass

    def bug(self):
        bug = self.root.ids.bug.text
        data_hj = date.today()

        if len(bug) <= 255:
            mydb = mysql.connector.connect(
                host="localhost",
                user="root",
                passwd="",
                database="pap"
            )
            cursor = mydb.cursor()
            mydb.autocommit = True
            with open("../auxiliares/users.txt", "r") as myfile:
                data = myfile.readlines()
            user = listToString(data)
            query = "SELECT id from users where username = '"+user+"';"
            cursor.execute(query)
            dados = cursor.fetchall()
            for linha in dados:
                id = linha[0]
                print(id)


            data_hj = str(data_hj)
            query_insert = "INSERT INTO bug (id, ID_B, desc_bug, data) VALUES ('"+str(id)+"', NULL, '"+bug+"', '"+data_hj+"');"
            cursor.execute(query_insert)
        else:
            print("POPUP")


    def sugestao(self):
        tipo = self.root.ids.tipo.text
        nome = self.root.ids.nome.text
        localizacao = self.root.ids.localizacao.text

        mydb = mysql.connector.connect(
            host="localhost",
            user="root",
            passwd="",
            database="pap"
        )
        cursor = mydb.cursor()
        mydb.autocommit = True

        with open("../auxiliares/users.txt", "r") as myfile:
            data = myfile.readlines()
        user = listToString(data)
        query = "SELECT id from users where username = '" + user + "';"
        cursor.execute(query)
        dados = cursor.fetchall()
        for linha in dados:
            id = linha[0]




        query_insert = "INSERT INTO sugestao (id, tipo, nome_local, localização) VALUES ('"+str(id)+"', '"+tipo+"', '"+nome+"', '"+localizacao+"');"
        cursor.execute(query_insert)





    def avaliacao(self):
        tipo = self.root.ids.tipo.text
        estrelas = self.root.ids.estrelas.text
        comentario = self.root.ids.comentario.text
        nome = self.root.ids.nome.text
        estrelas = int(estrelas)
        if estrelas != 1 and estrelas !=2 and estrelas != 3 and estrelas != 4 and estrelas != 5:
            print("POPUP")
        else:
            with open("../auxiliares/users.txt", "r") as myfile:
                data = myfile.readlines()
            user = listToString(data)

            mydb = mysql.connector.connect(
                host="localhost",
                user="root",
                passwd="",
                database="pap"
            )
            cursor = mydb.cursor()
            mydb.autocommit = True
            query = "SELECT id from users where username = '" + user + "';"
            cursor.execute(query)
            dados = cursor.fetchall()
            for linha in dados:
                id = linha[0]
            query_insert = "INSERT INTO avaliação (id, tipo, estrelas, comentário, nome) VALUES ('"+str(id)+"', '"+tipo+"', '"+str(estrelas)+"', '"+comentario+"', '"+nome+"');"
            cursor.execute(query_insert)

Conhece_Portugal().run()