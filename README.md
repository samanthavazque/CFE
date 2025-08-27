# Proyecto Comisión CFE

Este proyecto es una aplicación web desarrollada en PHP para la gestión de comisiones, usuarios y reportes. Permite el registro, inicio de sesión, edición, consulta y exportación de datos a Excel y PDF.

## Características principales
- Registro y autenticación de usuarios
- Gestión de comisiones
- Edición y eliminación de registros
- Consulta de portadas y posters
- Exportación de datos a Excel y PDF
- Interfaz sencilla y moderna

## Requisitos
- PHP >= 7.0
- MySQL
- Servidor web (XAMPP recomendado)
- Composer (para dependencias)

## Instalación
1. Clona el repositorio:
   ```bash
   git clone https://github.com/samanthavazque/CFE.git
   ```
2. Coloca la carpeta en tu servidor local (por ejemplo, `c:/xampp/htdocs/comision`).
3. Importa la base de datos desde el archivo `comision.sql` usando phpMyAdmin o la línea de comandos.
4. Instala las dependencias con Composer:
   ```bash
   composer install
   ```
5. Configura la conexión a la base de datos en `Config/Conexion.php`.

## Uso
- Accede a la aplicación desde tu navegador en `http://localhost/comision`.
- Regístrate o inicia sesión para comenzar a gestionar las comisiones.

## Estructura del proyecto
- `index.php`: Página principal
- `registro.php`, `procesar_registro.php`: Registro de usuarios
- `inicio.php`, `procesar_login.php`: Inicio de sesión
- `usuarios.php`: Gestión de usuarios
- `guardar.php`, `editar.php`, `elimina.php`: CRUD de comisiones
- `excel.php`: Exportación a Excel
- `fpdf/`: Exportación a PDF
- `assets/`: Archivos estáticos (CSS, JS, imágenes)
- `Config/`: Configuración y conexión a la base de datos
- `posters/`: Imágenes y videos de portadas

## Autor
- samanthavazque

## Licencia
Este proyecto está bajo la licencia MIT.
