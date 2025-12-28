# PROJECT REPORT: ONLINE POULTRY FARM BOOKING SYSTEM

**Institution**: Bayero University Kano (BUK)
**Department**: Computer Science
**Level**: Final Year Project

---

## 1.0 INTRODUCTION

The **Online Poultry Farm Booking System** is a web-based application designed to bridge the gap between poultry farmers and day-old chick distributors. Traditionally, booking chicks involves physical visits to farm offices, manual receipt generation, and paper-based record keeping. This manual process is prone to errors, data loss, and inefficiency.

This project automates the entire process, allowing customers to book chicks such as **Broilers**, **Layers**, and **Cockerels** remotely, while providing administrators with a powerful dashboard to manage stock and customer records.

---

## 2.0 SYSTEM ARCHITECTURE & TECHNOLOGIES

The system is built using standard web technologies suitable for a robust academic project.

### 2.1 Technology Stack

- **Frontend (Client-Side)**:
  - **HTML5**: Structure of the web pages.
  - **CSS3**: Styling and responsive design (ensuring it works on mobile/desktop).
  - **JavaScript**: Basic client-side interactions.
- **Backend (Server-Side)**:
  - **PHP (Hypertext Preprocessor)**: The core logic handling form submissions, session management, and database communication.
- **Database**:
  - **MySQL**: Relational database management system (RDBMS) used to store user and booking records.
- **Server Environment**:
  - **Apache**: Web server (via **XAMPP**).

### 2.2 Software Design Pattern

The project roughly follows the **Model-View-Controller (MVC)** logic, although implemented in procedural PHP for simplicity in this academic context:

- **Database (Model)**: Defined in `config/db.php` and `schema.sql`.
- **Frontend (View)**: The `.php` files in the root and `admin/` folders acting as user interfaces.
- **Logic (Controller)**: The PHP scripts at the top of files like `book.php` handling data processing.

---

## 3.0 DATABASE DESIGN

The backend relies on three primary relational tables.

### 3.1 ER Diagram Concept

- **Users Table**: Stores customer information.
  - Primary Key: `id`
  - Unique Key: `phone` (Mobile-first approach).
- **Admins Table**: Stores secure login credentials for management.
- **Bookings Table**: The core transaction table linking Users to the Service (Chicks).
  - Foreign Key: `user_id` (Links to `Users` table).

### 3.2 Schema Snapshot

- `users`: `(id, full_name, phone, password_hash, created_at)`
- `bookings`: `(id, user_id, chick_type, quantity, pickup_date, status)`
- `admins`: `(id, username, password_hash)`

---

## 4.0 KEY SYSTEM MODULES

### 4.1 User Module

- **Registration/Login**: Secure access using hashed passwords (`password_hash()` in PHP).
- **Booking Engine**: Users select chick type and quantity. The system automatically calculates pickup dates based on availability logic.
- **Dashboard**: Users can view their booking history and current status (Pending/Confirmed).

### 4.2 Admin Module

- **Secure Authentication**: Role-based access control prevents unauthorized users from accessing `/admin`.
- **Booking Management**: Admins can Approve or Cancel bookings.
- **User Management**: View and search the entire customer database.
- **Reports & Analytics**: Visual summary of business performance (e.g., Total Sales, Popular Products).

---

## 5.0 IMPLEMENTATION HIGHLIGHTS (FOR DEFENSE)

If asked during your defense or presentation, highlight these technical features:

1.  **Security**:
    - **Password Hashing**: We do NOT store plain text passwords. We use `Bcrypt` (via PHP's `password_hash` function) which is an industry standard.
    - **Prepared Statements**: All database queries use PDO Prepared Statements to prevent **SQL Injection** attacks.
2.  **Session Management**:
    - The system uses PHP Sessions (`$_SESSION`) to track logged-in users and protect pages.
    - Special logic ensures Admins cannot accidentally access User pages and vice-versa.
3.  **Data Integrity**:
    - The database uses `FOREIGN KEY` constraints with `ON DELETE CASCADE`. This means if a user is deleted, their bookings are automatically removed to prevent "orphan records".

---

## 6.0 CONCLUSION

This project successfully demonstrates the application of Computer Science principles to solve a local agricultural problem. It improves efficiency, data accuracy, and user convenience compared to the manual system.

---

_Generated for Class of 2025 Final Year Project Documentation._
