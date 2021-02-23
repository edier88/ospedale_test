# Prueba aptitudes técnicas Grupo Ospedale

## Descripción:
El presente proyecto es una prueba técnica presentada a la empresa Grupo Ospedale.
Este proyecto se hizo con UI AUTH.
UI AUTH es un módulo para Laravel que tiene Jquery, Bootstrap, Axios y otras cosas para hacer una página de autorización. También incluye un "Scaffolding" que contiene todos los archivos y configuraciones, controladores, etc. Para crear una página de Login sin tener que hacerla desde cero, los pasos para su instalación se dictan a continuación:

### Pre-requisitos 📋

Asegúrese de tener composer y laravel instalado en su sistema. 

_Las instrucciones de instalación se escribieron teniendo en cuenta un sistema tipo Unix en la maquina donde se va a instalar el aplicativo web._

_Si usa Windows, puede que los comandos de instalación no le sirvan al pie de la letra._


### Instalación 🔧

Se describe la instalación, desde cero, de un sistema con AUTH UI. Si en el futuro se requiere. _Si se va a trabajar sobre este proyecto no hay necesidad de seguir estos pasos de instalación, puesto que este proyecto ya tiene AUTH UI_

_Se infiere que ya se ha creado un proyecto Laravel al cual instalarle AUTH UI_

```
$ cd <project_name>
$ composer require laravel/ui
$ php artisan ui bootstrap --auth
$ npm install && npm run dev
```
_El último comando es para compilar el scaffolding de Bootstrap. Si no aparecen los directorios_ ***public/css*** _y_ ***public/js***_, correr este comando dos veces_


## Configuración 🛠️

Lo siguiente lista toda la configuración que se hizo para tener el proyecto correcto, se dicen los archivos configurados y las configuraciones que se llevaron a cabo:
	
1. Se cambió el valor de la variable de entorno `APP_NAME` de _"laravel"_ a _"Ospedale test"_ en el archivo ***.env***.

2. Se puso el nombre de la base de datos con la que se trabajará en el proyecto, `ospedale_test`, en el archivo ***.env***. El SQL query con el que se creó la base de datos se guarda en el presente directorio bajo el nombre de ***DB_queries.sql***.

3. Se modificó las páginas de registro y de login que viene por defecto para poner los campos que uno necesite, en vez de los que vienen por defecto: ***resources/views/auth/login.blade.php*** y ***resources/views/auth/register.blade.php*** (se guardan backups de los archivos originales, estos se encuentran en el mismo directorio con extensión ***.bk***).

4. Se modificó el archivo de las rutas ***routes/web.php***.

5. Para que el registro guarde los campos que modifiquemos por defecto, se editó el archivo controlador del registro de usuarios: ***app/Http/Controllers/Auth/RegisterController.php***.

6. Para que al dar login no pida el sistema el e-mail sino el nombre de usuario se sobreescribió la función `username()` que se hereda desde el Trait `AuthenticatesUsers` en el controlador de login: ***app/Http/Controllers/Auth/LoginController.php***.

7. Se crearon los modelos `Eps`, `Rol` y se editó `User` para que no apunte a la tabla `users` sino a `tb_usuarios`, lo mismo para los modelos `Eps` y `Rol`.

8. Se modificó el archivo ***resources/views/home.blade.php*** para incluir una tabla en donde se pongan los usuarios.

9. Se creó el archivo ***public/js/home.js*** que interactúa con ***resources/views/home.blade.php*** para crear, modificar y eliminar usuarios. Este Javascript se comunica con los controladores para cumplir con las acciones a la base de datos.


*NOTA: :warning: :warning: :warning: Estos pasos no se hicieron en el orden que se enumeran, pudieron haber sido con un orden completamente diferente en el desarrollo del aplicativo de prueba.* :warning: :warning: :warning:
