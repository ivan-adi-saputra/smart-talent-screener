# Smart Talent Screener

🚀 **Smart Talent Screener** is an AI-powered platform for screening and analyzing candidate CVs, built with Laravel, React.js, and PostgreSQL (Supabase).

## 🧱 Tech Stack

- **Backend:** Laravel 11.x
- **Frontend:** React.js 18.x (Inertia.ts)
- **Styling:** Tailwind CSS
- **State Management:** Zustand
- **Database:** PostgreSQL (Supabase)
- **AI Integration:** Gemini AI

## 🗂️ Project Structure

### Frontend (React)

- `resources/js/components`: UI Components.
- `resources/js/pages`: Page-level components.
- `resources/js/layouts`: Layout wrappers.
- `resources/js/store`: Zustand state management.
- `resources/js/utils`: Helper functions.

### Backend (Laravel)

- `app/Services`: Business logic layer.
- `app/Integrations`: External API integration layer (e.g., Gemini AI).

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

- This is the initial refactor from Vue to React.
- State management uses **Zustand** located in `resources/js/store`.
- Business logic should be placed in the Service layer.
