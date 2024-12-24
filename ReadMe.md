# Fullstack Application

## Table of Contents
1. [Introduction](#introduction)
2. [Getting Started Locally](#getting-started-locally)
3. [Environment Variables](#environment-variables)
4. [Running the Application Locally](#running-the-application-locally)
5. [Deploying with CI/CD](#deploying-with-cicd)

---

## Introduction
This guide provides instructions to set up and run the full-stack application locally, as well as deploy it using Continuous Integration/Continuous Deployment (CI/CD) scripts.

## Getting Started Locally

### Prerequisites
Make sure you have the following installed:

1. **Backend Requirements:**
   - PHP 8.x or higher
   - Composer
   - MySQL
   - Redis
   - Docker (optional but recommended)

2. **Frontend Requirements:**
   - Node.js 16.x or higher
   - Yarn (optional but recommended)
   - Docker (optional but recommended)

### Environment Variables
Create the `.env` file for the backend and frontend environments.

#### Backend
Copy the `.env.example` to `.env` in the backend root directory and configure the required variables, e.g.,

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

Run `php artisan config:clear` to refresh the configuration cache.

#### Frontend
Create a `.env` file in the frontend directory with entries such as:

```
REACT_APP_API_URL=http://localhost:8000/api
```

---

## Running the Application Locally

### Backend
1. Navigate to the backend directory:
   ```bash
   cd backend
   ```
2. Install dependencies using Composer:
   ```bash
   composer install
   ```
3. Run migrations and seed the database:
   ```bash
   php artisan migrate --seed
   ```
4. Start the server:
   ```bash
   php artisan serve
   ```
   The backend will run on `http://127.0.0.1:8000`.

### Frontend
1. Navigate to the frontend directory:
   ```bash
   cd frontend
   ```
2. Install dependencies:
   ```bash
   npm install
   ```
3. Start the React development server:
   ```bash
   npm start
   ```
   The frontend will run on `http://localhost:3000`.

---

## Deploying with CI/CD

### Prerequisites
- CI/CD pipeline tool, e.g., GitHub Actions, GitLab CI, or Jenkins.
- Docker installed on the build agent/server.
- Push access to the deployment environment (e.g., Heroku, AWS, etc.).

### Example Steps for CI/CD Deployment

#### 1. **Pipeline Configuration**
- Add a configuration file based on your CI/CD service.

##### GitHub Actions Example
Create a `.github/workflows/deploy.yml`:

```yaml
name: Deploy Application

on:
  push:
    branches:
      - main

jobs:
  build-and-deploy:
    runs-on: ubuntu-latest

    steps:
    - name: Checkout code
      uses: actions/checkout@v3

    - name: Set up Node.js
      uses: actions/setup-node@v3
      with:
        node-version: '16'

    - name: Install frontend dependencies
      run: |
        cd frontend
        npm install
        npm run build

    - name: Set up PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.1'
        extensions: mbstring, pdo_mysql

    - name: Install backend dependencies
      run: |
        cd backend
        composer install
        php artisan migrate --force

    - name: Deploy to Server
      run: |
        # Example command for deployment, replace with your tool e.g., rsync/ssh/docker
        echo "Deploying application"
```

#### 2. **Environment Variables for CI/CD**
Ensure your environment variables for production are set in your CI/CD tool.

#### 3. **Build and Deploy**
- Commit and push your changes to the main branch to trigger the pipeline.
- Monitor the pipeline logs for success or failure.

