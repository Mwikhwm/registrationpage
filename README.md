### registrationpage
# Login Website Project
An user friendly secure login and profile management website built using HTML, CSS, JavaScript, PHP and MySQL. This project allows users to register, login, and update their profile information securely.

## Features
- User registration with hashed password storage
- Secure login and session management
- Profile update functionality

## Setup
### Prerequisites
- PHP (Xampp)
- MySQL Server (Xampp)
- Web server (Xampp)

### Database Setup

1. Create the Database

2. Create the users table
<pre>sql CREATE DATABASE registration_db;
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  country VARCHAR(50) NOT NULL,
  profile_image VARCHAR(100) DEFAULT 'default.jpg'
); </pre>

## Usage
Access the project by navigating to the site in your browser (e.g., localhost/project-directory).
Register a new account, login, and update the profile as needed.

## Contributors
Sourjyadyuti Narzary - Frontend Development, UI 
Mwikhwm Basumatary - Backend Development, Database Setup
