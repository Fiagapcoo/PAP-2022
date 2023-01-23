import math

def degreesToRadians(degrees):
    return degrees * math.pi / 180

def distanceInKmBetweenEarthCoordinates(lat1, lon1, lat2, lon2):
    earthRadiusKm = 6371

    dLat = degreesToRadians(lat2 - lat1)
    dLon = degreesToRadians(lon2 - lon1)

    lat1 = degreesToRadians(lat1)
    lat2 = degreesToRadians(lat2)

    a = math.sin(dLat / 2) * math.sin(dLat / 2) + math.sin(dLon / 2) * math.sin(dLon / 2) * math.cos(lat1) * math.cos(lat2)
    b = 2 * math.atan2(math.sqrt(a), math.sqrt(1 - a))


    return earthRadiusKm * b


def eurico(lat1, lon1, lat2, lon2):
    dLat = lat2-lat1
    dLon = lon2-lon1

    norm_vet = math.sqrt(dLat**2 + dLon**2)

    return norm_vet*111





if __name__ == '__main__':
    lat1 = 40.90388195991842
    lon1 = -8.49933117290173

    lat2 = 38.72514244141054
    lon2 = -9.150105859375

    print(distanceInKmBetweenEarthCoordinates(lat1, lon1, lat2, lon2))
    print(eurico(lat1, lon1, lat2, lon2))