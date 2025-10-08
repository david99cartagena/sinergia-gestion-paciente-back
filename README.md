# 📦 Proyecto Laravel 10 con JWT

API RESTful construida con **Laravel 10**, con autenticación **JWT** y **MySQL** como base de datos. Permite gestionar **Pacientes** mediante un CRUD completo, incluyendo la opción de subir fotos.

## ⚙️ Stack Tecnológico

**Backend:**

-   Laravel Framework - 10.49.1
-   PHP - 8.1.25
-   tymon/jwt-auth - 2.2.1
-   MySQL Workbench - 8.0.40

## 🗂️ Tablas principales

-   **departamentos** `(id, nombre)`
-   **municipios** `(id, departamento_id, nombre)`
-   **tipos_documento** `(id, nombre)`
-   **genero** `(id, nombre)`
-   **paciente** `(id, tipo_documento_id, numero_documento, nombre1, nombre2, apellido1, apellido2, genero_id, departamento_id, municipio_id, correo)`

## 🖥️ Cómo empezar en Windows (modo local)

### ✅ Requisitos Previos

Asegúrate de tener instalado lo siguiente en tu entorno Windows:

-   [XAMPP](https://www.apachefriends.org/index.html) – Para ejecutar Apache y MySQL localmente.
-   [Composer](https://getcomposer.org/) – Para gestionar dependencias PHP.
-   [Git](https://git-scm.com/) – Para clonar el repositorio.
-   [Visual Studio Code](https://code.visualstudio.com/) (opcional) – Editor de código recomendado.

### ⚙️ Bases de Datos Compatibles

Este proyecto es compatible con múltiples motores de bases de datos, aunque se recomienda:

#### 🔹 MySQL (versión recomendada: 8.0.40)

Puedes usar una instalación estándar de MySQL o la versión incluida en XAMPP:

-   [MySQL (instalación oficial)](https://dev.mysql.com/downloads/installer/)
-   [XAMPP (incluye MySQL)](https://www.apachefriends.org/es/index.html)

### 🛠️ Pasos para instalar y correr el proyecto

1. **Clonar el repositorio:**

    ```bash
    git clone https://github.com/david99cartagena/sinergia-gestion-paciente-back.git
    ```

    ```bash
    cd sinergia-gestion-paciente-back
    ```

2. **Copiar el archivo de entorno `.env.example` a `.env`:**

    ```bash
    cp .env.example .env
    ```

    _Ejemplo de .env_

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=prueba
    DB_USERNAME=root
    DB_PASSWORD=password
    ```

3. **Instalar las dependencias de Laravel:**

    ```bash
    composer install
    ```

4. **Generar la clave de aplicación:**

    ```bash
    php artisan key:generate
    ```

5. **Configurar la base de datos en el archivo `.env`:**

    - Completa los valores de: `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
    - Agrega tu `JWT_SECRET`.

6. **Ejecutar las migraciones de base de datos:**

    ```bash
    php artisan migrate
    ```

7. **Ejecutar los seeders para poblar la base de datos:**

    ```bash
    php artisan db:seed
    ```

    _Incluye datos de prueba:_

    - 5 departamentos
    - 2 municipios por departamento
    - 2 tipos de documento
    - Usuario administrador (contraseña: `1234567890`)
    - 5 pacientes de prueba

8. **Levantar el servidor local:**

    ```bash
    php artisan serve
    ```

    - La API estará disponible en:  
      `http://127.0.0.1:8000` o `http://localhost:8000/`

## 🧪 Tests de la API

Se incluyen pruebas automatizadas para verificar el correcto funcionamiento de los endpoints de pacientes utilizando **Laravel Feature Tests** y **JWT**.

### Pruebas disponibles

1. **Crear un paciente**

    - Envía datos completos de un paciente al endpoint `/api/pacientes`.
    - Verifica que el paciente se haya creado correctamente y que exista en la base de datos.
    - Comprueba la estructura JSON de la respuesta.

2. **Listar pacientes**

    - Obtiene todos los pacientes mediante `/api/pacientes`.
    - Verifica el status HTTP 200 y la estructura del JSON con la lista de pacientes.

3. **Actualizar un paciente** _(comentado en el test por el momento)_

    - Permite modificar los datos de un paciente existente.
    - Verifica que los cambios se reflejen correctamente en la base de datos y en la respuesta JSON.

4. **Eliminar un paciente**
    - Borra un paciente mediante `/api/pacientes/{id}`.
    - Verifica que la respuesta sea exitosa y que el paciente ya no exista en la base de datos.
