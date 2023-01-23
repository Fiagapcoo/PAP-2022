from kivy.uix.boxlayout import BoxLayout
from kivy.properties import ObjectProperty
from kivy.lang import Builder
import geocoder
import webbrowser
import math
from kivymd.app import MDApp
from kivy.config import Config
from kivy.core.window import Window
import mysql.connector
from datetime import date
from geopy.geocoders import Nominatim

from stem.manual import query

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
    b = 2 * math.atan2(math.sqrt(a), math.sqrt(1 - a))


    return earthRadiusKm * b

def listToString(s):
    str1 = ""
    for ele in s:
        str1 += ele
    return str1

class ContentNavigationDrawer(BoxLayout):
    screen_manager = ObjectProperty()
    nav_drawer = ObjectProperty()


class Conhece_Portugal(MDApp):
    def build(self):
        Config.set('kivy', 'window_icon', 'conhece_portugal_principal.png')
        return Builder.load_file("APP.kv")


    def locais(self):

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

        with open("../auxiliares/users.txt", "r") as myfile:
            data = myfile.readlines()
        username = listToString(data)

        query = "SELECT * FROM users where username = '"+username+"';"
        cursor.execute(query)
        dados = cursor.fetchall()

        for user in dados:
            dist = user[7]
        # 1 coordenada geografica é exatamente 111.19492664455873km
        query = "SELECT * FROM local"
        cursor.execute(query)
        dados = cursor.fetchall()
        array_locais_list = []
        for local in dados:
            lat2 = local[5]
            lon2 = local[6]
            nome_loc = local[2]
            aux = distanceInKmBetweenEarthCoordinates(lat1, lon1, lat2, lon2)
            if ( aux  <= dist):
                print("menor")
                array_locais_list.append(nome_loc)

        print(array_locais_list)






    def bike(self):
        local = self.root.ids.local_a_ir.text
        if(local != ""):
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
            query = "SELECT autonomia from users where username = '"+user+"';"
            cursor.execute(query)
            dados = cursor.fetchall()
            for aut in dados:
                aut_user = aut[0]
            print(aut_user)

            if(aut_user == 0.0):
                local.replace(" ", "+")
                query = "https://www.google.com/maps/dir/?api=1&destination="+local+"+WA&travelmode=bicycling"
                webbrowser.open(query)

            elif (aut_user >0.0):
                # 1 coordenada geografica são aproximadamente 111km
                g = geocoder.api.ip("me")

                # coordenadas atuais
                atual = {
                    "latitude": g.lat,
                    "longitude": g.lng
                }


                # converter autonomia de km pa coordenadas
                aut_coord = aut_user/111

                # coordenadas do destino
                geolocator = Nominatim(user_agent="MyApp")
                destino = geolocator.geocode(f"{local}")
                destino = {
                    "longitude": destino.longitude,
                    "latitude": destino.latitude
                }

                distB = distanceInKmBetweenEarthCoordinates(atual["latitude"], atual["longitude"], destino["latitude"], destino["longitude"])
                distB_coord = distB/111
                array_passagens = []
                while distB_coord > aut_coord:
                    i = 0
                    # calcurar área que a bike pode andar
                    soma_catetos = 2 * aut_coord ** 2
                    hipotenusa = math.sqrt(soma_catetos)
                    meio_lado = hipotenusa / 2
                    v1 = [atual["latitude"] - meio_lado, atual["longitude"] + meio_lado]
                    v4 = [atual["latitude"] + meio_lado, atual["longitude"] - meio_lado]

                    # obter bombas da área
                    query_bombas = f"select * from bombas where lat_bomba > {v1[0]} and lat_bomba < {v4[0]} and long_bomba > {v4[1]} and long_bomba < {v1[1]}"
                    cursor.execute(query_bombas)
                    bombas = cursor.fetchall()

                    bombaMaisPerto = distB
                    for bomba in bombas:
                        a = []
                        bomba = {
                            "nome": bomba[0],
                            "latitude": bomba[1],
                            "longitude": bomba[2]
                        }
                        a = distanceInKmBetweenEarthCoordinates(float(atual["latitude"]),float(atual["longitude"]),float(bomba["latitude"]),float(bomba["longitude"]))
                        if a < distB:
                            bombaMaisPerto = bomba["nome"]
                    array_passagens.append(bombaMaisPerto)
                    query = f"SELECT * from bomba where nome_bomba = '{str(bombaMaisPerto[i])}'"



                    i= i+1






    def restaurantes(self):
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

        with open("../auxiliares/users.txt", "r") as myfile:
            data = myfile.readlines()
        username = listToString(data)

        query = "SELECT * FROM users where username = '" + username + "';"
        cursor.execute(query)
        dados = cursor.fetchall()

        for user in dados:
            dist = user[7]
        # 1 coordenada geografica é exatamente 111.19492664455873km
        query = "SELECT * FROM restaurante"
        cursor.execute(query)
        dados = cursor.fetchall()
        array_rest_list = []
        for rest in dados:
            lat2 = rest[5]
            lon2 = rest[6]
            nome_loc = rest[0]
            aux = distanceInKmBetweenEarthCoordinates(lat1, lon1, lat2, lon2)
            if (aux <= dist):
                print("menor")
                array_rest_list.append(nome_loc)

        print(array_rest_list)

    def estadia(self):
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

        with open("../auxiliares/users.txt", "r") as myfile:
            data = myfile.readlines()
        username = listToString(data)

        query = "SELECT * FROM users where username = '" + username + "';"
        cursor.execute(query)
        dados = cursor.fetchall()

        for user in dados:
            dist = user[7]
        # 1 coordenada geografica é exatamente 111.19492664455873km
        query = "SELECT * FROM estadia"
        cursor.execute(query)
        dados = cursor.fetchall()
        array_est_list = []
        for est in dados:
            lat2 = est[5]
            lon2 = est[6]
            nome_est = est[0]
            aux = distanceInKmBetweenEarthCoordinates(lat1, lon1, lat2, lon2)
            if (aux <= dist):
                print("menor")
                array_est_list.append(nome_est)
        print(array_est_list)

    def percursos(self):
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

        with open("../auxiliares/users.txt", "r") as myfile:
            data = myfile.readlines()
        username = listToString(data)

        query = "SELECT * FROM users where username = '" + username + "';"
        cursor.execute(query)
        dados = cursor.fetchall()

        for user in dados:
            dist = user[7]
        # 1 coordenada geografica é exatamente 111.19492664455873km
        query = "SELECT * FROM percursos"
        cursor.execute(query)
        dados = cursor.fetchall()
        array_perc_list = []
        for perc in dados:
            lat2 = perc[4]
            lon2 = perc[5]
            nome_perc = perc[1]
            aux = distanceInKmBetweenEarthCoordinates(lat1, lon1, lat2, lon2)
            if (aux <= dist):
                print("menor")
                array_perc_list.append(nome_perc)

        print(array_perc_list)



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