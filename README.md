# Pasos para levantar Backend Skytel

## Instalación

### Clonar el repositorio

git clone https://github.com/ramagoz/backend-skytel.git


### Instalar las dependencias de Laravel
Ingresar a la carpeta del proyecto y realizar lo siguiente

* composer install

### Generar el archivo .env

copy .env.example .env

### Generar el entorno del proyecto

php artisan key:generate

### Levantar el Proyecto

php artisan serve

### Testing de servicios con Postman
* [Postman](https://www.postman.com/downloads/) - Test Services
* [Project Postman](https://github.com/ramagoz/backend-skytel/blob/main/doc/Skytel.postman_collection.json) - Test Services

