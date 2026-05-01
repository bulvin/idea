# 💡 Idea

![Laravel](https://img.shields.io/badge/Laravel-13-red)
![PHP](https://img.shields.io/badge/PHP-8.5-blue)
![Tailwind](https://img.shields.io/badge/TailwindCSS-4.x-38B2AC)
![Alpine.js](https://img.shields.io/badge/Alpine.js-lightweight-8BC0D0)
![Tests](https://img.shields.io/badge/tests-Pest-purple)
![Status](https://img.shields.io/badge/status-MVP-yellow)
![License](https://img.shields.io/badge/license-MIT-green)

**Idea** is a web application that allows you to create, organize, and share your ideas in a structured way.

Visit app here: [idea-bulvinkel.on-forge.com](https://idea-bulvinkel.on-forge.com)
---

##  Features

###  Idea Management
- Create, update, delete ideas
- View single idea
- Filter ideas list
- Support formatting using markdown

###  Steps System
- Add structured steps to each idea
- Complete, edit and remove steps anytime

###  Sharing
- Generate **share codes**
- Temporary **public links** (expire after time)
- Guest access to shared ideas in read-mode

###  Authentication & User System
- User registration
- Login / logout
- Secure session-based authentication
- Protected user content

###  User Profile
- Edit user profile data

---

## Tech Stack

| Layer       | Technology |
|-----------|-----------|
| Backend     | Laravel 13, PHP 8.5 |
| Frontend    | Blade, Alpine.js, Tailwind CSS |
| Testing     | Pest (Browser & Unit) tests |
| Tooling     | composer, npm |

## 🚀 Getting Started

### Requirements

- PHP 8.3+
- Composer
- Node.js & npm
- Database SQLite

---

### Installation

```bash
git clone https://github.com/bulvin/idea.git

cd idea

composer run setup

php artisan serve
```

---

## 🧪 Testing

```bash
# run all tests
php artisan test

# browser tests
php artisan test --testsuite=Browser
```

---
