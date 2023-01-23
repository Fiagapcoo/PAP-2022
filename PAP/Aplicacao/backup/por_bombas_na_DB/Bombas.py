import json
import mysql.connector
if __name__ == '__main__':
    file = open("listaPostos.json")
    a=json.load(file)

    mydb = mysql.connector.connect(
        host="localhost",
        user="root",
        passwd="",
        database="pap"
    )
    buffered_cursor = mydb.cursor()
    mydb.autocommit = True



    for posto in a['resultado']:

        nome = posto['nome'].replace('"', '\\"')
        lat = posto['latitude']
        long = posto['longitude']

        sql=f'INSERT INTO bombas (nome_bomba, lat_bomba, long_bomba) VALUES ("{nome}", "{lat}", "{long}");';
        print(sql)
        buffered_cursor.execute(sql)




