
# 🛒 Supermarket Management System (PHP + MySQL)

A professional backend project built with **core PHP** and **MySQL**, implementing clean CRUD operations for managing **Categories** and **Products**.  

This project demonstrates how to structure a PHP application using **Models**, **Controllers**, a custom **Logger Trait**, and automated testing with **Pest**.

---

## ✨ Features

- ✅ CRUD operations for **Categories** and **Products**
- ✅ Organized architecture with **Models** and **Controllers**
- ✅ Custom **Logger Trait** for event tracking
- ✅ Unit and integration tests with [Pest](https://pestphp.com/)
- ✅ Uses **MySQL** with prepared statements (PDO) for security
- ✅ Clear separation of concerns and extendable design

---

## 📂 Project Structure

```

SuperMarket/
│── index.php          # Front controller
│
│── src/                   # Application source code (instead of app/)
│   ├── Config/            # Config loader (reads from .env, structured settings)
│   │   └── Config.php
│   │
│   ├── Database/          # DB connection logic (uses Config)
│   │   └── Database.php
│   │
│   ├── Models/            # Data models (User, Post, etc.)
│   │   └── Category.php
│   │   └── Product.php
│   │
│   ├── Controllers/       # Business logic / request handling
│   │   └── CategoryController.php
│   │   └── ProductController.php
│   │
│   └── Helpers/           # Utility functions (validation, auth, etc.)
│   │   └── Logger.php
│   │	  └── Validator.php 
│   
│── routes/                # Route definitions
│   └── web.php
│
│── storage/               # Non-public storage (uploads, logs, cache)
│   └── logs/
│        └── app.log
│   └── Uploads/
│        └── Categories
│        └── Products
│
│── tests/                 # Pest tests
│   └── Unit/
│         └── CategoryTest.php
│         └── ProductTest.php
│
│── vendor/                # Composer dependencies (auto-created)
│
│── .env                   # Environment variables (DB credentials, secrets)
│── .gitignore             # Ignore vendor, storage/logs, .env
│── composer.json          # Composer configuration & autoloading
```

---

## 🗄️ Database Schema

### Categories
| Column     | Type        | Description               |
|------------|-------------|---------------------------|
| id         | INT (PK)    | Unique identifier         |
| name       | VARCHAR     | Category name             |
| created_at | TIMESTAMP   | Record creation date      |

### Products
| Column       | Type        | Description                   |
|--------------|-------------|-------------------------------|
| id           | INT (PK)    | Unique identifier             |
| category_id  | INT (FK)    | Linked to `categories.id`     |
| name         | VARCHAR     | Product name                  |
| price        | DECIMAL     | Product price                 |
| created_at   | TIMESTAMP   | Record creation date          |

---

## 🚀 Getting Started

### Prerequisites
- PHP >= 8.1
- MySQL
- Composer
- Pest (for testing)

### Installation
```bash
# Clone the repository
git clone https://github.com/OmarAyman85/supermarket.git

# Install dependencies (for Pest)
composer install

# Configure database
cp config/database.example.php config/database.php
# create a .3nv file and update DB credentials

# Import database schema
mysql -u root -p supermarket < database/schema.sql

# Start local server
php -S localhost:8000 -t public
````

---

## 🔥 API Endpoints

### Categories

| Method | Endpoint           | Description           |
| ------ | ------------------ | --------------------- |
| GET    | `/categories`      | List all categories   |
| GET    | `/categories/{id}` | Get a single category |
| POST   | `/categories`      | Create a new category |
| PUT    | `/categories/{id}` | Update a category     |
| DELETE | `/categories/{id}` | Delete a category     |

### Products

| Method | Endpoint         | Description          |
| ------ | ---------------- | -------------------- |
| GET    | `/products`      | List all products    |
| GET    | `/products/{id}` | Get a single product |
| POST   | `/products`      | Create a new product |
| PUT    | `/products/{id}` | Update a product     |
| DELETE | `/products/{id}` | Delete a product     |

---

## 🛠️ Example cURL Requests

```bash
# Create Category
curl -X POST http://localhost:8000/categories \
     -H "Content-Type: application/json" \
     -d '{"name": "Beverages"}'

# Create Product
curl -X POST http://localhost:8000/products \
     -H "Content-Type: application/json" \
     -d '{"name": "Pepsi", "price": 12.5, "stock": 50, "category_id": 1}'
```

---

## 🧪 Testing

Run the full test suite with Pest with the testing environment:

```bash
APP_ENV=testing ./vendor/bin/pest
```

Example Test:

```php
it('can create a category in the database and find it by the ID', function(){
    $categoryModel = new Category();

    $category_id = $categoryModel->create([
        'name' => 'TEST'
    ]);

    $category = $categoryModel->find($category_id);
    
    expect($category)->toBeArray();

    expect($category['id'])->toBeInt()->toBe($category_id);
    
    expect($category['name'])->toBeString()->toBe("TEST");
});
```

---

## 📜 Logging

A reusable **Logger Trait** writes application events (e.g., CRUD operations) to `Storage/Logs/app.log`.
Each log entry includes a timestamp and event description:

```
[2025-09-19 22:45:10] Category with ID: 1 created.
```

---

## 👨‍💻 Author

**Omar Ayman**

Junior Full Stack Developer 

<a href="https://www.linkedin.com/in/ommarayman/" target="_blank" rel="noopener noreferrer">
<img src="https://img.shields.io/badge/LinkedIn--blue" />
</a>
<a href="mailto:ommarayman085@gmail.com" target="_blank" rel="noopener noreferrer">
<img src="https://img.shields.io/badge/Gmail--red" ;></img></a>
</a>
<a href="https://omar-ayman-pro-folio.vercel.app/" target="_blank" rel="noopener noreferrer">
<img src="https://img.shields.io/badge/Portfolio--lightgreen" ;></img></a>
</a>

---

## 📄 License

This project is licensed under the MIT License.
