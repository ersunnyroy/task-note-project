# Task Note Project

Welcome to the Task Note Project! Below, you'll find important information about the project and installation instructions.

## Installation

To get started with the project, follow these steps:

```bash
git clone https://github.com/ersunnyroy/task-note-project.git
cd task-note-project
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

# Step 2: Configure the database in .env as per your environment 

## For example below : 
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_CHARSET=utf8
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=

# Step 3: Migrate DB & Seed Test Data 

## Using Commands below : 
    php artisan migrate
    php artisan db:seed

# STEP 4: Serve Your Application & You are ready to go 
    php artisan serve 

## Access it using http://localhost:8000/ base url on localhost 

# Testing Credentials

#### Email : sunnyroy@yopmail.com
#### Password : password123

# API DOCUMENTATION 

### 1.User Registration

#### Endpoint

- **Method:** POST
- **URL:** `/api/register`
- **Content Type:** `application/json`

#### Request Body

```json
{
  "name": "Sunny Roy",
  "email": "sunny@example.com",
  "password": "password123"
}
```

#### Response Body:

```json
    {
        "user": {
            "name": "Sunny Roy",
            "email": "sunny@yopmail.com",
            "updated_at": "2024-02-27T16:31:32.000000Z",
            "created_at": "2024-02-27T16:31:32.000000Z",
            "id": 2
        }
    }
```

## 2. User Login

#### Endpoint

- **Method:** POST
- **URL:** `/api/login`
- **Content Type:** `application/json`

#### Request Body

```json
{
  "email": "sunny@yopmail.com",
  "password": "password123"
}
```
#### Response Body 

```json
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTcwOTA2MTA5NSwiZXhwIjoxNzA5MDY0Njk1LCJuYmYiOjE3MDkwNjEwOTUsImp0aSI6ImFhV0JyWG9nbGRHSFB5Z1MiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.5aQrNebnmD4M7rPB1GbZYDWImb_8xY1UEbtMgZuT7O4"
}
```

## 3. Add Task with Notes

#### Endpoint

- **Method:** POST
- **URL:** `/api/tasks`
- **Authentication:** Required (Token-based)
- **Content Type:** `multipart/form-data`

#### Request Body (Form Data)

- `subject` (Text, required): The subject of the task.
- `description` (Textarea, optional): The description of the task.
- `start_date` (Date, required): The start date of the task.
- `due_date` (Date, required): The due date of the task.
- `status` (Enum: New, Incomplete, Complete, required): The status of the task.
- `priority` (Enum: High, Medium, Low, required): The priority of the task.
- `notes` (Array of Notes, optional): An array of notes, each with a subject, attachment, and note.
-  `notes[][subject], notes[][attachment] = file, notes[][note]`


#### Response

- **Status Code:** 201 Created
- **Body:**
```json
      {
        "task": {
            "subject": "Medium Priority Task",
            "description": "Medium priority task description",
            "start_date": "2024-02-24",
            "due_date": "2024-02-24",
            "status": "Incomplete",
            "priority": "Medium",
            "user_id": 1,
            "updated_at": "2024-02-27T19:11:47.000000Z",
            "created_at": "2024-02-27T19:11:47.000000Z",
            "id": 9
        }
      }
```

### 4. Get Tasks

#### Endpoint

- **Method:** GET
- **URL:** `/api/tasks`
- **Authentication:** Required (Token-based)

#### Response

- **Status Code:** 200 OK
- **Body:** JSON representation of the list of tasks.

Example Response:

```json
[
  {
    "id": 1,
    "subject": "Task 1",
    "description": "This is the first task.",
    "start_date": "2024-03-01",
    "due_date": "2024-03-10",
    "status": "New",
    "priority": "High",
    "created_at": "2024-03-01T12:00:00Z",
    "updated_at": "2024-03-01T12:00:00Z",
    "notes": [
      {
        "id": 1,
        "subject": "Note 1",
        "attachment": "attachments/attachment1.jpg",
        "note": "This is a note for Task 1.",
        "created_at": "2024-03-01T12:00:00Z",
        "updated_at": "2024-03-01T12:00:00Z"
      },
      {
        "id": 2,
        "subject": "Note 2",
        "attachment": "attachments/attachment2.jpg",
        "note": "This is another note for Task 1.",
        "created_at": "2024-03-01T12:00:00Z",
        "updated_at": "2024-03-01T12:00:00Z"
      }
    ]
  },
]
```
### 5. Get Tasks with Filters

#### Endpoint

- **Method:** GET
- **URL:** `/api/tasks`
- **Authentication:** Required (Token-based)
- **Query Parameters:**
  - `status` (optional): Filter tasks by status (e.g., `status=New`).
  - `due_date` (optional): Filter tasks by due date (e.g., `due_date=2024-03-10`).
  - `priority` (optional): Filter tasks by priority (e.g., `priority=High`).
  - `notes` (optional): Filter tasks that have a minimum of one note attached (e.g., `notes=true`).

#### Response

- **Status Code:** 200 OK
- **Body:** JSON representation of the list of tasks based on applied filters.

Example Response:

```json
[
  {
    "id": 1,
    "subject": "Task 1",
    "description": "This is the first task.",
    "start_date": "2024-03-01",
    "due_date": "2024-03-10",
    "status": "New",
    "priority": "High",
    "created_at": "2024-03-01T12:00:00Z",
    "updated_at": "2024-03-01T12:00:00Z",
    "notes": [
      {
        "id": 1,
        "subject": "Note 1",
        "attachment": "attachments/attachment1.jpg",
        "note": "This is a note for Task 1.",
        "created_at": "2024-03-01T12:00:00Z",
        "updated_at": "2024-03-01T12:00:00Z"
      },
      {
        "id": 2,
        "subject": "Note 2",
        "attachment": "attachments/attachment2.jpg",
        "note": "This is another note for Task 1.",
        "created_at": "2024-03-01T12:00:00Z",
        "updated_at": "2024-03-01T12:00:00Z"
      }
    ]
  },
]
```


   
    



    
