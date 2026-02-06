# WMX PlayStation Web

A **Laravel 12–based web application** designed to manage PlayStation services, including user authentication, customer dashboards, package purchases, quota management, coupon systems, and an admin panel for payment verification and data management.

---

## 🚀 Tech Stack

* **Backend**: Laravel 12, PHP ^8.2
* **Frontend**: Blade + Vite
* **Database**: MySQL / SQLite (development)
* **Authentication**: Session-based authentication
* **Tooling**: Composer, NPM, Vite, PHPUnit

---

## ✨ Key Features

### User Features

* User registration & login
* User dashboard
* Profile update & password change
* View and purchase packages
* Package purchase history
* Quota management & usage history
* Coupon system

### Admin Features

* Admin dashboard
* User management
* Payment verification (approve / reject)
* Coupon management
* Lottery / draw winner system

---

## 🗺️ Routing Overview (Simplified)

* `/` — Home
* `/login`, `/register` — Authentication
* `/dashboard` — User dashboard
* `/dashboard/packages` — Packages & payments
* `/dashboard/quota` — Quota management
* `/admin` — Admin panel (protected by `admin` middleware)

---

## ⚙️ Installation & Setup (Local Development)

### 1. Clone the Repository

```bash
git clone <repository-url>
cd wmx-playstation-laravel
```

### 2. Install Backend Dependencies

```bash
composer install
```

### 3. Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

Update your database configuration in the `.env` file:

```env
DB_DATABASE=your_database
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Run Database Migration

```bash
php artisan migrate
```

### 5. Install Frontend Dependencies

```bash
npm install
npm run dev
```

### 6. Run the Application

```bash
php artisan serve
```

Access the app at: `http://localhost:8000`

---

## 🧪 Testing

Run unit and feature tests:

```bash
php artisan test
```

---

## 📦 Composer Scripts

Available helper scripts:

```bash
composer run setup   # install dependencies + migrate + build assets
composer run dev     # development mode (server + queue + Vite)
composer run test    # run tests
```

---

## 🔐 Security Notes

* **Never commit the `.env` file**
* Store all sensitive credentials in environment variables

---

## 📄 License

This project is licensed under the **MIT License**.

---

## 👨‍💻 Author

Developed for **WMX PlayStation** service management.

Feel free to open an issue or submit a pull request if you’d like to contribute 🙌
