# Smart Talent Screener

🚀 **Smart Talent Screener** is an AI-powered platform for screening and analyzing candidate CVs, built with Laravel, Vue.js, and PostgreSQL (Supabase).

## 🧱 Tech Stack

- **Backend:** Laravel 11.x
- **Frontend:** Vue.js 3.x (Inertia.ts)
- **Database:** PostgreSQL (Supabase)
- **Authentication:** Laravel Breeze
- **AI Integration:** Gemini AI

## 🗂️ Project Structure

- `app/Services`: Business logic layer.
- `app/Integrations`: External API integration layer (e.g., Gemini AI).
- `resources/js`: Vue.js components and frontend logic.

## 🚀 Getting Started

### Prerequisites

- PHP 8.2+
- Composer
- Node.js & NPM

### Installation

1. Clone the repository.
2. Install PHP dependencies:
    ```bash
    composer install
    ```
3. Install Node dependencies:
    ```bash
    npm install
    ```
4. Copy `.env.example` to `.env` and configure your database and Gemini API key:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
5. Run migrations:
    ```bash
    php artisan migrate
    ```
6. Build assets:
    ```bash
    npm run dev
    ```

## 🧭 Notes

- This is a scaffolding phase.
- AI integration logic is located in `app/Integrations/GeminiAI.php`.
- Business logic should be placed in `app/Services`.
