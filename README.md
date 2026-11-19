# Super Gus - Login y administración CRUD

Este paquete es una base de proyecto PHP + MySQL para publicar en un hosting que soporte PHP 8+ y MySQL/MariaDB.

## Importante
- No está publicado en internet: para obtener un enlace real hay que crear/usar una cuenta de hosting y desplegar estos archivos.
- No se incluyen los teléfonos/direcciones ni movimientos de clientes del respaldo original, para evitar exponer datos personales.
- La base SQL crea las cuatro tablas y agrega registros de demostración inocuos en `productos`.
- Cambia las credenciales de `config.php` por las que te dé el hosting.
- Cambia la contraseña inicial desde `setup.php` y después elimina `setup.php`.

## Instalación local (XAMPP)
1. Copia la carpeta `super_gus_login` a `C:/xampp/htdocs/`.
2. Inicia Apache y MySQL desde XAMPP.
3. Abre `http://localhost/phpmyadmin` y crea una base llamada `super_gus`.
4. Importa `database/schema.sql`.
5. Edita `config.php` con tu usuario y contraseña MySQL local.
6. Abre `http://localhost/super_gus_login/setup.php` una sola vez para crear el usuario administrador.
7. Elimina `setup.php`.
8. Abre `http://localhost/super_gus_login/`.

Usuario inicial: `admin`
Contraseña inicial: `Cambiar123!` (cámbiala inmediatamente).

## Publicación en hosting
Contrata/usa un hosting que incluya PHP 8+, MySQL/MariaDB y phpMyAdmin. Sube los archivos por el administrador de archivos o FTP, crea una base de datos y usuario MySQL, importa `database/schema.sql`, configura `config.php` y ejecuta setup una vez. El enlace final será el dominio/carpeta que te asigne el hosting.

## CRUD disponible
El panel permite crear, consultar, editar y eliminar registros de:
- productos
- clientes_credito
- ventas
- movimientos_credito

La eliminación de registros relacionados puede ser bloqueada por las llaves foráneas; elimina primero los registros dependientes.
