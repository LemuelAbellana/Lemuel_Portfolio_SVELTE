# Lemuel G. Abellana Portfolio

A professional portfolio web application for Lemuel G. Abellana, built with Laravel, Inertia, and Svelte.

This project showcases:

- Academic and personal projects
- Technical skills and development stack
- Leadership and affiliations
- Achievements and certifications
- Contact form and downloadable resume

## About Me

I am a Bachelor of Science in Information Technology student at the University of the Immaculate Conception, based in Davao City.

My focus areas include:

- Full-stack web development
- Progressive Web Applications (PWA)
- Mobile application development
- AI-integrated solutions
- Technical leadership and community engagement

## Tech Stack

- Backend: Laravel 13, PHP 8.3+
- Frontend: Svelte 5, Inertia.js
- Build tools: Vite, Tailwind CSS 4
- Database: SQLite (default local), MySQL supported
- Animation/UI: GSAP, Bits UI, Lucide Svelte

## Features

- Modern single-page portfolio experience with section-based navigation
- Hero, About, Skills, Projects, Leadership, Achievements, Contact, and Resume sections
- About carousel with auto-slide and manual controls
- Contact form with server-side validation and persistence
- Resume download support from public/resume.pdf
- Responsive layout for desktop, tablet, and mobile

## Quick Start

### 1. Prerequisites

Install the following:

- PHP 8.3+
- Composer
- Node.js 20+
- npm

### 2. Install Dependencies and Initialize

Run this from the project root:

```bash
composer run setup
```

This command:

- Installs Composer dependencies
- Creates .env if missing
- Generates app key
- Runs migrations
- Installs npm dependencies
- Builds frontend assets

### 3. Run Development Mode

```bash
composer run dev
```

This starts:

- Laravel app server
- Queue listener
- Vite dev server

Open: http://127.0.0.1:8000

## Windows Note

On Windows, the default dev command excludes Laravel Pail to avoid pcntl extension errors.

- Use composer run dev for normal development.
- Use composer run dev:with-pail only on environments where pcntl is available (for example Linux/WSL/macOS).

## Available Scripts

- composer run setup: First-time project setup
- composer run dev: Start local development services
- composer run dev:with-pail: Start development with Laravel Pail logging
- composer run test: Run application tests
- npm run dev: Start only Vite dev server
- npm run build: Build production assets

## Project Structure

- routes/web.php: Inertia route and profile data props
- resources/js/Pages/Portfolio/Home.svelte: Portfolio page composition
- resources/js/components/sections: Main section components
- resources/js/components/ui: Reusable UI elements
- resources/css/app.css: Theme variables and global styles
- app/Http/Controllers/ContactController.php: Contact form handling

## Contact Form Setup

The contact form saves messages to the contacts table.

If needed, run migrations manually:

```bash
php artisan migrate
```

## Customization Tips

- Update profile values in routes/web.php
- Replace public/resume.pdf with your final CV
- Set real LinkedIn and GitHub URLs in profile props
- Update project and achievements content in section components

## License

This portfolio project is for personal/professional use by the author.
