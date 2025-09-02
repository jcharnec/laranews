# 📰 LaraNews

![Laravel](https://img.shields.io/badge/Laravel-8.83.27-red?style=flat&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-^8.2-blue?style=flat&logo=php)
![License](https://img.shields.io/badge/license-MIT-lightgrey?style=flat)
![Status](https://img.shields.io/badge/status-en%20desarrollo-orange)

**LaraNews** es un portal de noticias desarrollado en Laravel, con sistema de roles, subida de imágenes, autenticación de usuarios y funcionalidades completas para la publicación y moderación de contenido.

---

## 🚀 Características

-   Registro, login y verificación por correo electrónico.
-   Panel de administración para gestionar usuarios y roles.
-   CRUD de noticias con imagen y temática.
-   Subida de imagen de perfil (avatar) y validaciones.
-   Comentarios en noticias con posibilidad de eliminar.
-   Papelera para restaurar noticias y usuarios eliminados (SoftDeletes).
-   Sistema de roles (`admin`, `user`, `editor`, etc.).
-   Interfaz responsive con Bootstrap 5.
-   Notificaciones visuales (componente `<x-alert>`).

---

## 🖥️ Capturas de pantalla

> _Puedes subir tus imágenes a la carpeta `/public/img` o usarlas desde GitHub para mostrar capturas reales de la app._

| Registro de usuario           | Vista de noticia         |
| ----------------------------- | ------------------------ |
| ![Registro](img/register.png) | ![Noticia](img/news.png) |

---

## 📂 Estructura del proyecto

```bash
.
├── app/
├── config/
├── database/
├── public/
│   ├── storage → enlace simbólico a storage/app/public
├── resources/
│   ├── views/        # Vistas Blade
│   └── lang/         # Traducciones
├── routes/
│   └── web.php       # Rutas web
├── storage/
│   └── app/
│       └── public/
│           └── images/
│               ├── noticias/
│               └── users/
└── ...
```

---

## ⚙️ Instalación

```bash
git clone https://github.com/tuusuario/laranews.git
cd laranews
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

> ⚠️ Asegúrate de configurar correctamente `.env` con tu base de datos y servidor de correo.

---

## 🔐 Usuarios por defecto (Seeder)

| Email              | Rol   | Contraseña |
| ------------------ | ----- | ---------- |
| admin@laranews.com | admin | password   |
| user@laranews.com  | user  | password   |

---

## 🧪 Testing rápido (opcional)

```bash
php artisan migrate:fresh --seed
php artisan serve
```

---

## 🛠️ Tecnologías utilizadas

-   Laravel 8.83.27
-   PHP 8.2+
-   Bootstrap 5
-   MySQL o PostgreSQL
-   Blade (motor de plantillas)
-   Laravel Breeze (si se usa)
-   Laravel Storage (para manejo de imágenes)

---

## 👤 Autor

-   💻 Desarrollador: [Tu nombre o nickname]
-   🌐 Portfolio: [https://hotadev.com.es](https://hotadev.com.es)

---

## 📄 Licencia

Este proyecto está bajo la licencia MIT. Consulta el archivo [LICENSE](LICENSE) para más detalles.

---

## 🌟 Contribuir

¿Ideas, errores o mejoras? ¡Puedes abrir un issue o hacer un fork del repositorio!
