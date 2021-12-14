# SERVICIO PRINCIPAL - USUARIOS

En éste servicio se administrará las peticiones de los demás servicios del sistema, además, el servicio cuenta con sus propios endpoint's para recibir peticiones. El servicio principal también se encarga de administrar la información del modulo de administración del sistema.

Por lo tanto, el servicio también dispone de un frontend para éste módulo. Tanto el servicio como el frontend, fueron desarrollados con lenguaje de programación 'php 7.3' usando su framework 'Laravel 8'. La base de datos está implementada en un RDBMS 'MySQL'. En esta DB se encuentran las entidades relacionadas con: usuarios, roles, permisos, sesiones, géneros, servicios.

## API Endpoint's

NOTA: Los controladores se encuentran en el path: 'App\Http\Controllers\services\main'. Los endpoit's que se encuentren entre llaves '{ }', son parámetros que recibe el endpoit.

El parámetro 'user' hace referencia al nombre de usuario, usuario que realiza la petición al servicio, el usuario debe estar registrado en el sistema. Esto se hace con el fin de prevenir una petición maliciosa.

### USUARIOS: 

#### - OBTENER
Cuando se requiera obtener todos los usuarios que se encuentran registrados en el sistema, realice la peticion en el siguiente endpoint: 

```
GET: 'api/role/users/v1/{user}'
```

Si lo que requiere es obtener todos los usuarios de un role específico, añada  el siguiente parámetro al endpoint: 

```
GET: 'api/role/users/v1/{user}/{id_role}'
```

Cuando se requiera obtener la información de un usuario específico, realice la petición en el siguiente endpoint: 

```
GET: 'api/users/v1/{user}/{identification}'
```

#### - REGISTRAR

Cuando se rquiera registrar un usuario en el sistema, realice la petición en el siguiente endpoint: 

```
POST: 'api/users/v1/{user}'
```

La petición debe llevar los datos del usuario a registrar, como contenido en formato 'JSON': 
 
```
{
    "identification": number,       // No de documento de ciudadanía
    "userName": character,          // Nombre de usuario que se le asignará
    "name": character,              // Nombre del usuario
    "lastName": character           // Apellido del usuario
    "email": character              // Correo electrónico del usuario
    "password": character           // Contraseña de la cuenta del usuario
    "confirmPassword": character    // Confirmación de la contraseña
    "role": number,                 // ID del role que se le asignará
    "gender": number                // ID del género sexual que se le asignará
}
```

#### - ACTUALIZAR

Cuando se rquiera actualizar un usuario en el sistema, realice la petición añadiendo el parámetro 'identification', el cuál representa la identficación del usuario registrado al que se le actualizará la información en la DB, en el siguiente endpoint: 

```
PUT: 'api/users/v1/{user}/{identification}'
```

La petición debe llevar los datos del usuario a actualizar, como contenido en formato 'JSON'; Con los mismos atributos que el contenido de registro, exceptuando los atributos 'identification' y los que no contendrán ninguna información. 


#### - ELIMINAR

Cuando se requiera eliminar un usuario en el sistema, realice la petición junto con el parámetro 'identification', el cuál representa la identificación del usuario a eliminar, en el siguiente endpoint: 

```
DELETE: 'api/users/v1/{user}/{identification}'
```
