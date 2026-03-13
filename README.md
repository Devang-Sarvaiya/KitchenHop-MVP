# KitchenHop-MVP
KitchenHop is a full-stack MVP connecting chefs with commercial kitchen owners. It features secure role-based authentication, a dynamic booking engine with price calculation, and an admin oversight panel. Built with PHP and MySQL using PDO for security, it showcases a scalable architecture and a responsive Bootstrap 5 interface.


# KitchenHop - Cooking Space Platform

A full-stack MVP built with PHP and MySQL that connects chefs with commercial kitchen owners.

## 🚀 Live Demo
https://devang.byethost7.com/

## 🔐 Test Credentials (Demo Accounts)

| Role | Email | Password | Description |
| :--- | :--- | :--- | :--- |
| **Admin** | admin@kitchenhop.hopn.eu | admin123 | Full oversight and verification. |
| **Owner 1** | owner@example.com | password | Manages first 15 kitchens. |
| **Owner 2** | sarah@example.com | password | Manages 5 kitchens (Sarah Miller). |
| **Chef** | chef@example.com | password | Browses and books kitchens. |

## 📂 Recent Updates
* **Dynamic Landing Page:** Redesigned with a Bootstrap 5 Hero section.
* **Expanded Marketplace:** Added 20 verified kitchen listings for demo.
* **Data Isolation:** Owners only see and manage their own listings.
* **Image Support:** Integrated external Image URL support and previews.

## 🛠 Features
- **Role-Based Access:** Chef, Kitchen Owner, and Admin dashboards.
- **Booking System:** Dynamic price calculation and status management (Pending/Approved/Rejected).
- **Kitchen Management:** Owners can list, edit, and delete their kitchen spaces.
- **Admin Panel:** Oversight of users, verification of kitchens, and support inbox.
- **Security:** Password hashing (Bcrypt) and PDO prepared statements to prevent SQL injection.

## 💻 Tech Stack
- **Backend:** PHP 8.x, MySQL
- **Frontend:** HTML5, CSS3, Bootstrap 5
- **Tooling:** Gemini AI (for refactoring and architecture)


## 🛠 Setup Instructions
1. Download or clone this repository.
2. Upload the files to your PHP server (XAMPP, WAMP, or Hosting).
3. Open your Database Manager (PHPMyAdmin).
4. Create a new database named `kitchenhop_db`.
5. Import the `database.sql` file included in this repository.

## 🔑 Database Configuration
- Update the `config/database.php` file with your server details:
- Host: `localhost` (or your hosting provider's host)
- DB Name: `kitchenhop_db`
- User: `your_username`
- Password: `your_password`

## 🔧 Installation & Setup
1. Clone the repository.
2. Import `database.sql` into your MySQL server.
3. Update `config/database.php` with your local credentials.
4. Run on a PHP-enabled server (XAMPP/WAMP/ByetHost).
