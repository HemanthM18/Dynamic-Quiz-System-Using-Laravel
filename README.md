# Dynamic Quiz System (Laravel)

## 📌 Overview

This project is a **Dynamic Quiz System** built using Laravel.
It allows users to create quizzes, add different types of questions, attempt quizzes, and view results with automatic scoring.

---

## 🚀 Features

* Create and manage quizzes
* Support for multiple question types:

  * Binary (Yes/No)
  * Single Choice
  * Multiple Choice
  * Number Input
  * Text Input
* Add questions with:

  * Rich text (HTML supported)
  * Image upload
  * Video URL (e.g., YouTube)
* Options support:

  * Text
  * Image
  * Text + Image
* Attempt quiz with dynamic UI
* Automatic scoring system
* Result page with total score
* Delete questions functionality

---

## 🛠️ Tech Stack

* Backend: Laravel (PHP)
* Database: MySQL
* Frontend: Blade + Bootstrap
* Storage: Laravel File Storage (public disk)

---

## ⚙️ Setup Instructions

### 1. Clone the Repository

```bash
git clone <your-repo-link>
cd <project-folder>
```

---

### 2. Install Dependencies

```bash
composer install
```

---

### 3. Setup Environment File

```bash
cp .env.example .env
```

---

### 4. Configure Database

Open `.env` file and update:

```env
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

---

### 5. Generate App Key

```bash
php artisan key:generate
```

---

### 6. Run Migrations

```bash
php artisan migrate
```

---

### 7. Create Storage Link (IMPORTANT for images)

```bash
php artisan storage:link
```

---

### 8. Configure PHP Upload Temp (Windows only)

Open `php.ini` and ensure:

```ini
upload_tmp_dir = "C:\temp"
sys_temp_dir = "C:\temp"
```

Create folder:

```text
C:\temp
```

Give **Full Control permissions**.

---

### 9. Run the Server

```bash
php artisan serve
```

---

### 10. Open in Browser

```text
http://127.0.0.1:8000/quizzes
```

---

## 📂 Project Structure (Important Files)

* `QuizController.php` → Main logic
* `models/` → Quiz, Question, Option, Attempt, Answer
* `views/` → Blade UI (create, attempt, result)

---

## 🧠 Design Notes

* Questions are stored with a `type` field for flexibility
* Options are stored separately → supports images & multiple answers
* File uploads handled using Laravel storage system
* System is easily extensible for adding new question types

---

## 📌 Notes

* Ensure `php artisan storage:link` is executed before using image upload
* Images are stored in `storage/app/public`
* Public access via `/storage` path

---

## 👨‍💻 Author

Hemanth M
