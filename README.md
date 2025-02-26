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

2. **Install dependencies:**
    ```bash
    composer install
    ```

3. **Copy the `.env` file and set up your environment variables:**
    ```bash
    copy .env.example to .env
    ```

4. **Generate an application key:**
    ```bash
    php artisan key:generate
    ```

5. **Run migrations:**
    ```bash
    php artisan migrate
    ```
5. **Start Server:**
    ```bash
    php artisan serve
    ```
6. **install frontend dependencies:**
    ```bash
    npm install
    ```
7. **Bundle frontend code:**
   ```bash
   npm run dev
   ```