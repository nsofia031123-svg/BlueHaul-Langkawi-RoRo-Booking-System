# 🚢 BlueHaul RoRo Booking System

A web-based ferry and RoRo (Roll-on/Roll-off) booking system developed using PHP and MySQL. The system allows customers to search ferry schedules, book tickets, manage their bookings, and provides administrators with a dashboard to manage schedules, fares, promotions, users, and booking records.

---

## 📖 Overview

BlueHaul was developed to modernize the ferry booking process by replacing manual reservations with an online platform. It offers a simple and user-friendly interface for customers while providing administrators with tools to efficiently manage the booking system.

---

## 🎯 Objectives

- Develop an online ferry booking platform.
- Simplify the ticket reservation process.
- Allow customers to manage their bookings online.
- Provide administrators with an easy-to-use management system.
- Improve booking efficiency and user experience.

---

## ✨ Features

### Customer
- User Registration & Login
- Search Ferry Schedules
- Book One-Way & Return Trips
- Fare Calculation
- Apply Promotion Codes
- View Booking History
- Manage User Profile
- Contact Support

### Administrator
- Dashboard Overview
- Manage Ferry Schedules
- Manage Fare Prices
- Manage Promotions
- Manage Users
- View Bookings
- Generate Reports
- Monitor Sales Statistics

---

## 👥 User Roles

### Customer
- Register and login
- Search available ferry schedules
- Book ferry tickets
- View booking history
- Update profile information

### Administrator
- Manage schedules
- Manage fares
- Manage promotions
- Manage users
- View bookings
- Generate reports

---

## 📸 Screenshots

> Create a folder named `screenshots` inside your repository and add your images.

| Page | Preview |
|------|---------|
| Home Page | ![](screenshots/home.png) |
| Login | ![](screenshots/login.png) |
| Register | ![](screenshots/register.png) |
| Booking Page | ![](screenshots/booking.png) |
| Booking History | ![](screenshots/history.png) |
| User Profile | ![](screenshots/profile.png) |
| Admin Dashboard | ![](screenshots/admin-dashboard.png) |
| Schedule Management | ![](screenshots/admin-schedule.png) |
| Reports | ![](screenshots/admin-report.png) |

---

## 💻 Technologies

### Frontend
- HTML5
- CSS3
- Bootstrap 5
- JavaScript
- Font Awesome

### Backend
- PHP

### Database
- MySQL

### Development Tools
- Visual Studio Code
- XAMPP
- phpMyAdmin

---

## 🗄️ Database

The project uses a MySQL database named:

```sql
bluehaul
```

Main tables include:

- admins
- user
- booking
- booking_passenger
- schedule
- fare
- promotion
- messages

---

## 🚀 Installation

### 1. Clone the repository

```bash
git clone https://github.com/yourusername/BlueHaul.git
```

### 2. Move the project

Copy the project folder into your XAMPP `htdocs` directory.

```
C:\xampp\htdocs\BlueHaul
```

### 3. Import the database

- Open **phpMyAdmin**
- Create a database named **bluehaul**
- Import the provided SQL file

### 4. Configure the database

Update your database connection settings in:

```
database.php
```

```php
$dbHost = "localhost";
$dbName = "bluehaul";
$dbUser = "root";
$dbPass = "";
```

### 5. Start XAMPP

Start:

- Apache
- MySQL

### 6. Run the project

```
http://localhost/BlueHaul
```

---

## 🔮 Future Improvements

- Online payment gateway
- QR Code ticket generation
- Email booking confirmation
- SMS notifications
- Seat selection
- Mobile responsive improvements
- Real-time ferry availability
- Booking cancellation & refund
- Enhanced security

---

## 👨‍💻 My Contribution

As the developer of this project, I contributed to:

- Designing the booking workflow
- Developing the customer authentication system
- Implementing ferry schedule search and booking
- Building user profile and booking history modules
- Developing the administrator dashboard
- Implementing fare and promotion management
- Designing the MySQL database
- Connecting frontend and backend components
- Testing and debugging the system

---

## 📄 License

This project was developed for educational purposes as part of a Software Engineering course.
