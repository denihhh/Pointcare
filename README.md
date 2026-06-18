# PointCare – Clinical Booking System

[![Laravel](https://img.shields.io/badge/Framework-Laravel%2011-red?logo=laravel)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/Frontend-Livewire%20v3-pink?logo=livewire)](https://livewire.laravel.com)
[![Alpine.js](https://img.shields.io/badge/Scripting-Alpine.js-blue?logo=alpinejs)](https://alpinejs.dev)
[![Tailwind CSS](https://img.shields.io/badge/Styling-Tailwind%20CSS-38B2AC?logo=tailwindcss)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green)](https://opensource.org/licenses/MIT)

## Project Overview

**PointCare** is an enterprise-grade, web-based clinical booking application developed during my professional software engineering internship. The system is architected to eliminate traditional clinic operational bottlenecks, allowing patients to seamlessly schedule, track, and manage appointments online, dramatically reducing their waiting times.

Built with a focus on modern, real-time reactive user interfaces and robust security practices, PointCare delivers an optimized workspace for both healthcare consumers (Patients) and clinical providers (Doctors).

---

## Tech Stack & Architecture

PointCare leverages the power of the **TALL Stack**, prioritizing a decoupled, component-driven approach for long-term maintainability:

* **Backend Core:** Laravel 11 (Expressive routing, Eloquent ORM, and dependency injection service layers).
* **Reactivity Layer:** Livewire v3 (Asynchronous, AJAX-driven DOM hydration with zero complex JavaScript overhead).
* **Frontend State Management:** Alpine.js (Lightweight reactive scripting for absolute UI controls such as overlays and modal layers).
* **Design Language:** Tailwind CSS (Custom premium aesthetic focusing on clean minimalist slate tracking and high-contrast crimson/rose accents).

---

## Core Product Features

### Dual-Role Adaptive Dashboards
* **Patient Portal:** A streamlined historical ledger view where users can securely review upcoming and past consultations, audit booking timestamps, and filter scheduling history seamlessly via a smart status-tab strip.
* **Doctor Workspace:** An active operational queue detailing daily clinical schedules, patient consultation metrics (pending approvals vs. completed sessions), and intuitive availability parameter controls.

### Seamless Asynchronous UI
* **Reactive Pagination:** High-performance, unconflicted Livewire datasets that transition smoothly through layout pages without ever triggering a hard browser tab refresh.
* **Visual Stacking Isolation:** Precision-engineered modal popups utilizing fixed viewport clamping (`fixed inset-0`) and isolated z-indexing to fully clear global layouts (sidebars/navbars) across all mobile and desktop viewports.

### Enterprise Security & Integrity
* **Strict Access Control:** Custom role-based middleware guarding administrative endpoints and restricting unauthorized visibility boundaries between clinical files and public ledgers.
* **Data Protection:** Comprehensive protection parameters guarding forms against cross-site scripting, direct object references, and data mutations.

---

## Getting Started

### Prerequisites
* PHP >= 8.2
* Composer
* Node.js & NPM
* MySQL or SQLite Database

### Installation & Local Setup

1. **Clone the Repository:**
   ```bash
   git clone [https://github.com/yourusername/pointcare-booking.git](https://github.com/yourusername/pointcare-booking.git)
   cd pointcare-booking
