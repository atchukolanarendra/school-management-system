# "School Management System"
A PHP-based CRUD (Create, Read, Update, Delete) application for managing students and their associated classes. This project allows users to create, view, edit, and delete student records while managing class information.

---

## Features

- **Students Management**:
  - Add new students with details such as name, email, address, class, and image upload.
  - View detailed information about each student.
  - Edit student details, including changing their class and updating their profile image.
  - Delete student records, including associated images.

- **Class Management**:
  - Add, edit, and delete class information.
  - Associate students with classes.

- **Image Upload Handling**:
  - Upload and display student profile images.
  - Validate image types (only JPG and PNG allowed).
  - Automatically handle file paths and ensure unique filenames.

- **Database Integration**:
  - Relational database schema with two tables: `students` and `classes`.
  - SQL queries using PDO for secure database operations.

- **Responsive Design**:
-  Uses Bootstrap for a clean and responsive interface.
-  
## Prerequisites
1. **Software Requirements**:
   - PHP >= 7.4
   - MySQL or MariaDB
   - Apache Web Server
   - [XAMPP](https://www.apachefriends.org/) recommended for local development.

### Step 2: Set Up the Database

Open your MySQL server (e.g., through phpMyAdmin or MySQL CLI).
Create a new database:
###### CREATE DATABASE school_db;
Import the provided SQL file (school_db.sql) into the database:
In phpMyAdmin: Go to the Import tab and upload school_db.sql.
###### mysql -u root -p school_db < path_to_sql_file/school_db.sql

### Step 3: Configure the Application

Place the project folder (school_demo) in your XAMPP htdocs directory.
Ensure the uploads folder exists in the project root and is writable:
mkdir uploads
chmod 777 uploads
##### Update db.php with your database credentials:
$host = '127.0.0.1';
$dbname = 'school_db';
$username = 'root';
$password = '';

### Step 4: Start the Application
Start XAMPP and ensure Apache and MySQL are running.
Open your browser and navigate to
   #### http://localhost/school_demo/

#### Project Structure
school_demo/
│
├── db.php               # Database connection script

├── index.php            # Home page listing all students

├── create.php           # Add a new student

├── view.php             # View student details

├── edit.php             # Edit student details

├── delete.php           # Delete a student

├── classes.php          # Manage classes

├── uploads/             # Uploaded student images

├── school_db.sql        # Database schema and initial data

├── README.md            # Project documentation

└── style.css            # Optional custom styles

##### Usage
Adding Classes
Navigate to classes.php.
Add new classes using the form.
Edit or delete classes as needed.

##### Managing Students
Navigate to index.php.
Add a new student using the "Add Student" button.
View, edit, or delete student records using the action buttons.

##### Image Upload
Only JPG and PNG files are allowed.
Images are stored in the uploads/ directory.

#### Troubleshooting
Database Errors:

Ensure the database is properly set up with the school_db.sql file.
Verify the credentials in db.php.
Image Not Displaying:

Confirm the uploads/ directory exists and has proper write permissions.
Check if the image path stored in the database is correct.
404 Errors:

Ensure the project folder is in the correct location (htdocs).
Access the project using http://localhost/school_demo/.

##### Future Enhancements
Add user authentication for secure access.
Implement search and filter functionality for students and classes.
Enhance error handling and validation.
Add an option to paginate the student list.

### Output:
The final outcome of the project you can see here.

![WhatsApp Image 2024-11-24 at 10 20 31 PM](https://github.com/user-attachments/assets/2077f15d-4e19-4011-84ed-7ff641662d84)
 The image shows you listed students of school and modifies data, view data, & delete the data
![WhatsApp Image 2024-11-24 at 10 26 39 PM](https://github.com/user-attachments/assets/7d04f3db-3f9e-485f-bab8-ba4553c28099)
![WhatsApp Image 2024-11-24 at 10 27 37 PM](https://github.com/user-attachments/assets/a3939748-ceee-492b-87eb-f8a8760dd4c1)


