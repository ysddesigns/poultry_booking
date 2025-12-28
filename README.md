# Online Chicks Booking System 🐣

> A Final Year Computer Science Project for Bayero University Kano.

## 📖 Project Overview
This is a web-based **Poultry Farm Management System** designed to automate the manual process of booking chicks. It allows customers to book day-old chicks (Broilers, Layers, Noilers) online and enables farm administrators to manage orders efficiently.

The system is built using **Native PHP** and **MySQL** following **Agile Methodology** and **MVC-like Architecture**.

## 🚀 Features

### 👤 User Module (Customer)
- **Secure Registration & Login:** Users can create personal accounts.
- **Dashboard:** View personal booking history and status updates.
- **Booking Engine:** Book chicks by selecting type, quantity, and pickup date.
- **Real-time Status:** Track orders (Pending, Approved, Cancelled).

### 🛡️ Admin Module (Staff)
- **Secure Authentication:** Restricted access for staff only.
- **Master Dashboard:** View all bookings from all customers.
- **Order Management:** Approve or Cancel bookings based on stock availability.
- **Customer Insights:** View customer contact details for follow-up.

---

## 🛠️ Technology Stack
- **Frontend:** HTML5, CSS3 (Custom responsive design).
- **Backend:** PHP 8.x (Native).
- **Database:** MySQL (Relational).
- **Security:** PDO (Prepared Statements), BCrypt (Password Hashing).
- **Server:** Apache (via XAMPP).

---

## 📂 Project Structure
```text
/poultry_booking
│
├── /admin
│   ├── index.php        # Admin Login
│   ├── dashboard.php    # Admin Control Panel
│   └── update_status.php # Logic to Approve/Reject
│
├── /assets
│   └── /css/style.css   # Main Stylesheet
│
├── /config
│   └── db.php           # Database Connection (PDO)
│
├── /includes
│   ├── header.php       # Nav & Session Logic
│   └── footer.php       # Copyright & Scripts
│
├── index.php            # Landing Page
├── dashboard.php        # User Dashboard
└── schema.sql           # Database Import File