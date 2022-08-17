## Challenge Técnico Backend Extendeal

### Instalacion Automatica (Ubuntu, Devian, Centos) 
Stack necesario: Docker y Make.

      1 - mkdir extendeal_chall && cd extendeal_chall
      2 - git clone https://github.com/lvlal2iano/extendeal_chall.git .
	  3 - make init

**Con esto ya estara disponible la api en localhost:8000**

### Instalacion Manual (con Docker)

      1 - mkdir extendeal_chall && cd extendeal_chall
      2 - git clone https://github.com/lvlal2iano/extendeal_chall.git .
	  3 - docker-compose up --build --force-recreate -d --remove-orphans
	  4 - docker exec -it ${DOCKER_WEP} bash
    #Despues ejecuta dentro del contenedor lo siguiente 
	  5 - composer install
	  6 - cp -f .env.example .env
	  7 - php artisan key:generate
	  8 - php artisan octane:install --server="swoole"
	  9 - php artisan migrate:fresh --seed
	  10 - php artisan optimize:clear
	  11 - composer dump-autoload --optimize
	  12 - php artisan test
	  13 - php artisan octane:start --server="swoole" --host="0.0.0.0"
**Con esto ya estara disponible la api en localhost:8000**

### Instalacion Manual (sin Docker)

**Stack necesario**: *php8.0, mysql.5.7, Composer2.0*

**Extensiones PHP necesarias**: *mbstring xml iconv pcntl gd zip sockets pdo  pdo_mysql bcmath soap*

    1 - mkdir extendeal_chall && cd extendeal_chall
    2 - git clone https://github.com/lvlal2iano/extendeal_chall.git .
	3 - composer install
	4 - cp -f .env.example .env
	5 - php artisan key:generate
	6 - php artisan octane:install --server="swoole"
	7 - php artisan migrate:fresh --seed
	8 - php artisan optimize:clear
	9 - composer dump-autoload --optimize
	10 - php artisan test
	11 - php artisan octane:start --server="swoole" --host="0.0.0.0"
  
**Con esto ya estara disponible la api en localhost:8000**

### Datos
Al instalar el proyecto se seedearan 181 registros con informacion real de cuadros reales, lo unico falso es el pais de procedencia que se asignan aleatoriamente a los siguientes paises:
['GB','VN','VE','UY','UA','TR','TW','SE','ES','SG','SA','PT','PA','MC','MX','FR','BR','IT','AR','US'] (Esta distribucion se realizo a modo de enfocar la informacion ya que al momento de crear se puede utilizar el codigo de cualquier pais).

### Cuadro

Campo | Tipo | Obligatorio
------| -----| -------
autor  | string | si
nombre | string | si
anio_creacion | string con formato Y-m-d | si
precio | string numerico | no
alto | string numerico (centimetros) | si
ancho | string numerico (centimetros) | si
img_url | string url (centimetros) | no
sala_id | int Referencia a entidad Sala | si
pais_procedencia_id | int Referencia a entidad Pais | si

Ejemplo de cuerpo para crear un Cuadro:

      {
                "autor":"Un Autor de prueba",
                "nombre":"Una Obra de prueba",
                "anio_creacion":"1901-01-01",
            	"precio":"100000",
                "alto":"155",
                "ancho":"155",
                "img_url":"http://UnaUrlDePrueba",
                "sala":5,
                "procedencia":"AR" 
      }
    
	Notas: 
	1 - La procedencia se vincula mediante el codigo internacional de paises http://utils.mucattu.com/iso_3166-1.html, si no es un codigo valido da error)
	2 - Las Salas pueden ser 5: 1 - Sala blanca | 2 - Sala azul | 3 - Sala amarilla | 4 - Sala roja | 5 - Sala purpura.

### Querys
Tipo | Query | Descripcion
-----| ------ | ------
autor |filters[autor]={text} |Busca coincidencias LIKE %% en el campo autor
precio maximo |  filters[maxPrecio]={num}  | Filtra por precio maximo
precio minimo |  filters[minPrecio]={num}  | Filtra por precio minimo
alto maximo |  filters[maxAlto]={num}  | Filtra por alto maximo
alto minimo |  filters[minAlto]={num}  | Filtra por alto minimo
ancho maximo  |  filters[maxAlto]={num}  | Filtra por alto maximo
ancho minimo  |  filters[minAncho]={num}  | Filtra por ancho minimo
creacion desde  |  filters[minCreacion]={Y-m-d}  | Filtra por creacion desde
creacion hasta  |  filters[maxCreacion]={Y-m-d}   | Filtra por creacion hasta
por sala  | filters[sala]={1-5} |  Filtra por sala
por procedencia | filters[procedencia]={Code} |  Filtra por procedencia
fields  |field=campo1,campo2,... | Trae solo los atributos señalados, si se omite se traen todos
per_page  |per_page={num}|  Establece la cantidad traida por pagina (Por defecto 10)
page  |page={num}| trae la pagina seleccionada (Por defecto la 1)

### Endpoints
Method | Ruta
------------- | -------------
GET  | api/v1/cuadros
POST | api/v1/cuadros
GET | api/v1/cuadros/{cuadro} 
PUT | api/v1/cuadros/{cuadro}
GET | api/v1/status

###Ejemplo de response
api/v1/cuadros?filters[autor]=Rembrandt&filters[maxPrecio]=280000000

     {
        "data": [
            {
                "tipo": "Cuadro",
                "atributos": {
                    "id": "33",
                    "nombre": " Anciana leyendo",
                    "author": "Rembrandt van Rijn",
                    "precio": "160000000.00",
                    "anio_creacion": "1655-01-01",
                    "alto": 144,
                    "ancho": 168
                },
                "relaciones": {
                    "sala": {
                        "id": 5,
                        "nombre": "Sala purpura"
                    },
                    "pais_procedencia": {
                        "codigo": "UA",
                        "nombre": "Ukraine"
                    }
                },
				"links": {
                    "self": "http://localhost:8000/api/v1/cuadros/33",
                    "img": "https://theartwolf.com/wp-content/uploads/2022/01/Rembrandt_-_Old_Woman_Reading_-_1655-328x400.jpg"
                }
            
			}...

### Fuente de los datos (No es una API)
https://theartwolf.com/


MP
