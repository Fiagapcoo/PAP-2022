import geocoder

import math
import mysql.connector

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


if __name__ == '__main__':
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
    print ("ESTADIA")
    for estadia in dados:
        lat2 = estadia[5]
        lon2 = estadia[6]
        nome = estadia[0]
        dir_im = estadia[7]
        a = distanceInKmBetweenEarthCoordinates(lat1, lon1, lat2, lon2)


        if a > dist_a_ir:
            estadia_array.append(nome)
            src_estadia.append(dir_im)
            print(estadia_array)
            print(src_estadia)


            query = "SELECT * FROM local;"
            cursor.execute(query)
            dados = cursor.fetchall()

            for local in dados:
                lat2 = local[5]
                lon2 = local[6]
                dir_im = local[7]
                a = distanceInKmBetweenEarthCoordinates(lat1, lon1, lat2, lon2)

                if a < dist_a_ir:
                    query = "SELECT * FROM percursos;"
                    cursor.execute(query)
                    dados = cursor.fetchall()

            for percursos in dados:
                lat2 = percursos[4]
                lon2 = percursos[5]
                dir_im = percursos[6]
                a = distanceInKmBetweenEarthCoordinates(lat1, lon1, lat2, lon2)

                if a < dist_a_ir:
                    print("a")

            query = "SELECT * FROM restaurante;"
            cursor.execute(query)
            dados = cursor.fetchall()

            for restaurante in dados:
                lat2 = restaurante[5]
                lon2 = restaurante[6]
                dir_im = restaurante[7]
                a = distanceInKmBetweenEarthCoordinates(lat1, lon1, lat2, lon2)
                if a < dist_a_ir:
                    print("A")

