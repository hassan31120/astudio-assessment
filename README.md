# 📌 Project Name: Astudio Assessment

## Setup Instructions

### Clone the repository
```bash
git clone https://github.com/hassan31120/astudio-assessment
cd laravel-eav-api
```

### Install dependencies
```bash
composer install
```

### Create and configure .env file
```bash
cp .env.example .env
```

### Generate the application key
```bash
php artisan key:generate
```

### Configure the database
Update `.env` with your database details:
```makefile
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_eav
DB_USERNAME=root
DB_PASSWORD=
```

### Run Migrations & Seeders
```bash
php artisan migrate --seed
```

### Install Laravel Passport
```bash
php artisan passport:install
```

### Start the development server
```bash
php artisan serve
```

# 📌 API Documentation

### Authentication Endpoints

| Method | Endpoint       | Description          |
|--------|----------------|----------------------|
| POST   | /api/register  | Register a new user  |
| POST   | /api/login     | Authenticate a user  |
| POST   | /api/logout    | Logout user          |

**Example Login Request:**
```http
POST /api/login
Content-Type: application/json

{
    "email": "test@example.com",
    "password": "password"
}
```

**Response:**
```json
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1..."
}
```

### Project Endpoints

| Method | Endpoint            | Description        |
|--------|---------------------|--------------------|
| GET    | /api/projects       | Get all projects   |
| POST   | /api/projects       | Create a project   |
| PUT    | /api/projects/{id}  | Update a project   |
| DELETE | /api/projects/{id}  | Delete a project   |

**Example Create Project Request:**
```http
POST /api/projects
Content-Type: application/json

{
    "name": "Project A",
    "status": "active"
}
```

### Dynamic Attributes (EAV)

| Method | Endpoint                | Description                  |
|--------|-------------------------|------------------------------|
| GET    | /api/attributes         | List all attributes          |
| POST   | /api/attributes         | Create a new attribute       |
| POST   | /api/attribute-values   | Assign a value to a project  |

**Example Assign Attribute Request:**
```http
POST /api/attribute-values
Content-Type: application/json

{
    "attribute_id": 1,
    "project_id": 1,
    "value": "IT"
}
```

### Filtering Example
```http
GET /api/projects?filters[name]=ProjectA&filters[department]=IT
```
