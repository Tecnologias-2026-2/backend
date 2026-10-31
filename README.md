🔧 Backend – Nombre del Proyecto

Este repositorio contiene el backend del sistema desarrollado con Node.js sin frameworks y desplegado en Render.

👥 Integrantes

Nombre completo – Código

Nombre completo – Código

🎯 Objetivo del Backend

Implementar un servidor HTTP capaz de:

Gestionar solicitudes REST.

Procesar datos enviados desde el frontend.

Conectarse a base de datos.

Implementar operaciones CRUD.

Retornar respuestas en formato JSON.

🏗️ Arquitectura

El backend sigue una estructura modular:

Routes: Definición de endpoints.

Controllers: Lógica del sistema.

Models: Acceso a base de datos.

Database: Conexión y scripts SQL.

📡 Endpoints
Usuarios
Método	Ruta	Descripción
GET	/api/users	Obtener usuarios
POST	/api/users	Crear usuario
PUT	/api/users/:id	Actualizar usuario
DELETE	/api/users/:id	Eliminar usuario
🌍 URL del Backend en Producción

Colocar aquí la URL generada por Render:

https://nombre-del-servicio.onrender.com

🚀 Despliegue en Render
1️⃣ Subir proyecto a GitHub
git init
git add .
git commit -m "Backend inicial"
git push origin main

2️⃣ Crear servicio en Render

Ir a https://render.com

New → Web Service

Conectar repositorio GitHub

Configurar:

Build Command: npm install

Start Command: npm start

Environment: Node

3️⃣ Variable de Puerto

Render asigna automáticamente el puerto mediante:

process.env.PORT

🗄️ Base de Datos

La conexión a Supabase PostgreSQL se configura mediante variables de entorno:

`DATABASE_URL` (opcional) o `DB_HOST`, `DB_USER`, `DB_PASSWORD`, `DB_NAME` y `DB_PORT`.
La conexión requiere SSL. No guardes contraseñas ni claves de Supabase en el repositorio.

Para enviar `database/metas.json` a `public.products`, configura esas variables y ejecuta:

```sh
php database/sync_metas.php
```

El sincronizador usa las columnas existentes (`nombre`, `ahorrado`, `objetivo` y `color`),
omite `id` e `icono`, y evita volver a insertar metas con los mismos valores.

🔐 Validaciones

Validación de datos obligatorios.

Manejo de errores HTTP (200, 400, 404, 500).

Respuestas en formato JSON.

📚 Aprendizajes

Despliegue en la nube.

Configuración de variables de entorno.

Separación de responsabilidades.

Arquitectura básica de backend.

⚠️ Errores Comunes en Render

❌ Puerto fijo (3000 sin process.env.PORT)
❌ Falta de script "start"
❌ No subir package.json
❌ No hacer commit antes de conectar