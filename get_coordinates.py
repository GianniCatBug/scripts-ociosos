'''
    *************************************************************
    ***SCRIPT PARA OBTENER COORDENADAS A PARTIR DE DIRECCIONES***
    *************************************************************

    Se puede ejecutar desde https://notebooks.esri.com
    1. Ir a "new" arriba a la derecha, y escoger "Python 3"
    2. En el bloque de código, copiar y pegar todo este código
    3. Reemplazar contenido de lista de direcciones "addresses" por las deseadas
    4. Ejecutar con botón "play" o la combinación de teclas shift + enter
'''


# Módulos
from arcgis.gis import *
from arcgis.geocoding import geocode

# Inicializar API
dev_gis = GIS()

# Lista con strings de direcciones. 
# El string de cada dirección debe incluir la región o ciudad 
addresses = [
    "Av. 18 de Septiembre N° 311 Región Metropolitana",
    "Av. Las Delicias Sur N°302 Región Metropolitana",
    "Pedro de Valdivia N° 2195 Región Metropolitana",
    "Padre Damian Heredia N° 915 Ovalle Región Metropolitana"
]

def get_coordinates(addresses_list, print_address=False):
    '''
        Muestra en pantalla las coordenadas "x,y" de cada dirección

        Parámetros:
        * addresses_list: Lista unidimensional de strings con las direcciones para buscar coordenadas.
        * print_address: Boolean, por defecto False. En caso de ser True, imprime además dirección original.

        Salida:
        * Print output de coordenadas "x,y" para cada dirección
    '''
    for address in addresses_list:
        geocode_result = geocode(address=address, as_featureset=True)
        geometry = geocode_result.features[0].geometry

        if print_address:
            print("{},{},{}".format(geometry.x,geometry.y,address))
        else:
            print("{},{}".format(geometry.x,geometry.y))

# Llamada a la función
get_coordinates(addresses)
