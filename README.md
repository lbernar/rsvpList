# RSVP List (Drupal Custom Module)

**RSVP List** is a custom Drupal module developed as a demo to showcase backend and frontend integration within the Drupal ecosystem.  
It provides a reusable **block** that allows users to confirm their attendance (RSVP) for any event in a simple, dynamic way.

---

## 🧩 Overview

The module adds a custom **RSVP block** that can be placed anywhere in a Drupal site.  
It integrates Drupal’s Form API, entity storage, and rendering system to create a modern and extensible RSVP management solution.

### ✨ Features

- Custom **RSVP form block** available through the block layout interface.  
- Saves RSVP data to a custom database table.  
- Uses Drupal’s Form API and Dependency Injection best practices.  
- Easily extendable for event-specific logic or user permissions.  
- Clean, modular structure following **SOLID** and **Drupal Coding Standards**.

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-------------|
| CMS | [Drupal 10](https://www.drupal.org/) |
| Backend | PHP 8+, Drupal Form API |
| Frontend | Twig templating, CSS |
| Tools & Standards | Dependency Injection, PSR-4 autoloading, Clean Code principles |

---

## 🚀 Installation

1. Clone the repository into your Drupal installation’s `modules/custom` directory:

   ```bash
   cd web/modules/custom
   git clone https://github.com/lbernar/rsvpList.git
2. Enable the module:
   
```bash
  drush en rsvplist -y
```
3. Go to Structure → Block layout, find RSVP List Block, and place it in any region of your theme.

---

## 🧠 How It Works

- When a user fills out the RSVP form, their name and email are stored via the module’s custom service.
- The logic is encapsulated within RsvpService, making it easy to switch to entity-based storage later
- All UI elements are rendered through Twig templates for flexibility and theming consistency.

---

## 🧭 Future Improvements

- [X] Add administrative listing of RSVP entries.
- [X] Add email confirmation upon submission.
- [] Integrate with Drupal Views for filtering and exports.
- [] Add configuration options for event-specific RSVP limits.
