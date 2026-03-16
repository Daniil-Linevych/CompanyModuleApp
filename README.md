# Company API

A RESTful API built with **Symfony 7** for managing Companies, Employees, and Projects.

---

## Tech Stack

- PHP 8.2
- Symfony 7
- PostgreSQL 16
- Doctrine ORM
- JWT Authentication (LexikJWTAuthenticationBundle)
- Docker + Docker Compose

---

## Getting Started

### 1. Clone the repository
```bash
git clone https://github.com/Daniil-Linevych/CompanyModuleApp.git
cd company-api
```

### 2. Start Docker
```bash
docker compose up --build -d
```

App runs at **http://localhost:8080**

### 3. Load fixtures (optional)
```bash
docker compose exec app php bin/console doctrine:fixtures:load
```

---

## Authentication

All `POST`, `PUT`, `DELETE` endpoints require a JWT token.

### Register
```bash
POST /api/register
Content-Type: application/json

{
    "email": "user@example.com",
    "password": "Password1!"
}
```

### Login
```bash
POST /api/login
Content-Type: application/json

{
    "email": "user@example.com",
    "password": "Password1!"
}
```

---

## API Endpoints

### Companies

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/api/companies` | No | List all companies |
| GET | `/api/companies/{id}` | No | Get company details |
| POST | `/api/companies` | Yes | Create a company |
| PUT | `/api/companies/{id}` | Yes | Update a company |
| DELETE | `/api/companies/{id}` | Yes | Delete a company |

### Employees

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/api/employees` | No | List all employees |
| GET | `/api/employees/{id}` | No | Get employee details |
| POST | `/api/employees` | Yes | Create an employee |
| PUT | `/api/employees/{id}` | Yes | Update an employee |
| DELETE | `/api/employees/{id}` | Yes | Delete an employee |

### Projects

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/api/projects` | No | List all projects |
| GET | `/api/projects/{id}` | No | Get project details |
| POST | `/api/projects` | Yes | Create a project |
| PUT | `/api/projects/{id}` | Yes | Update a project |
| DELETE | `/api/projects/{id}` | Yes | Delete a project |

---

## Request Examples

### Create Company
```json
POST /api/companies
Authorization: Bearer <token>

{
    "name": "Acme Corp",
    "industry": "Technology",
    "foundedYear": 2010
}
```

### Create Employee
```json
POST /api/employees
Authorization: Bearer <token>

{
    "firstName": "John",
    "lastName": "Doe",
    "email": "john@acme.com",
    "position": "developer",
    "companyId": 1,
    "projectIds": [1, 2]
}
```

### Create Project
```json
POST /api/projects
Authorization: Bearer <token>

{
    "title": "New Mobile App",
    "description": "Cross-platform mobile application.",
    "startDate": "2024-06-01",
    "status": "in_progress",
    "companyId": 1,
    "employeeIds": [1, 2]
}
```


