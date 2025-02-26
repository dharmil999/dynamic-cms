# Laravel Project Setup

## Prerequisites

Before you begin, ensure you have met the following requirements:
- PHP >= 8.2
- Composer
- MySQL
- Node.js (v18 or higher)
- npm (v10 or higher)

## Installation

1. **Clone the repository:**
    ```bash
    git clone https://github.com/dharmil999/dynamic-cms.git
    cd dynamic-cms
    ```

2. **Install backend dependencies:**
    ```bash
    composer install
    ```

3. **Set up the environment file:**
    ```bash
    cp .env.example .env
    ```

4. **Generate an application key:**
    ```bash
    php artisan key:generate
    ```

5. **Run database migrations:**
    ```bash
    php artisan migrate
    ```
6. **Start the Laravel development server:**
    ```bash
    php artisan serve
    ```
7. **Install frontend dependencies:**
    ```bash
    npm install
    ```
8. **Compile frontend assets:**
   ```bash
   npm run dev
   ```
9. Open browser and go to http://127.0.0.1:8000/