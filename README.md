<div align="center">

# 🛒 E-Commerce API

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Firebase](https://img.shields.io/badge/Firebase-Cloud_Messaging-FFCA28?style=for-the-badge&logo=firebase&logoColor=black)](https://firebase.google.com/)
[![Google OAuth](https://img.shields.io/badge/Google_OAuth-Socialite-4285F4?style=for-the-badge&logo=google&logoColor=white)](https://developers.google.com/identity)
[![Docker](https://img.shields.io/badge/Docker-Sail-2496ED?style=for-the-badge&logo=docker&logoColor=white)](https://laravel.com/docs/12.x/sail)
[![Sanctum](https://img.shields.io/badge/Sanctum-4.3-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com/docs/12.x/sanctum)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)

**A multi-role e-commerce RESTful API built with Laravel 12, featuring Admin, Vendor, and Customer dashboards, Google OAuth authentication, Firebase push notifications, product variants, cart checkout, order management, and Docker containerization.**

</div>

---

## 🌟 Overview

E-Commerce API is a production-grade, multi-tenant backend system designed to power online marketplaces where multiple vendors can list and sell their products through a unified platform. Built with **Laravel 12** and following REST API best practices, the system implements a sophisticated **role-based architecture** with three distinct user types — Admin, Vendor, and Customer — each with their own set of endpoints, permissions, and business logic.

The API integrates **Google OAuth** via Laravel Socialite for seamless social login, eliminating friction during registration and sign-in. **Firebase Cloud Messaging (FCM)** enables real-time push notifications, keeping users informed about order status updates, new product listings, and promotional alerts. The product system supports **variants** (size, color, material), allowing vendors to offer flexible product options while maintaining precise **stock tracking** per variant.

The Admin dashboard provides full oversight of the platform: managing users with soft-delete capabilities, controlling product publication status, and organizing categories with visibility toggles. Vendors manage their own product catalogs, variants, and order fulfillment. Customers enjoy a complete shopping experience with cart management, checkout, and order tracking. The entire system is containerized with **Laravel Sail** (Docker), ensuring consistent development and deployment environments.

---

## ✨ Features

### 👑 Admin Dashboard
- Soft-delete and restore user accounts
- Publish or unpublish vendor products
- Create, update, and delete categories
- Toggle category visibility (show/hide)
- Full platform oversight and user management

### 🏪 Vendor Dashboard
- Create, update, and delete own products
- Manage product variants (size, color, material, etc.)
- View and manage orders containing their products
- Update order status (processing, shipped, delivered)
- Track inventory per product variant

### 🛒 Customer Experience
- Browse products by category and latest arrivals
- View product details with variant options
- Add to cart, update quantities, remove items
- Checkout flow with cart-to-order conversion
- View order history and order details
- Manage user profile

### 🔐 Authentication & Security
- Email/password registration and login
- **Google OAuth** social login via Laravel Socialite
- Sanctum token-based API authentication
- Token validation endpoint
- Role-based middleware (admin, vendor, user)

### 🔔 Real-Time Notifications
- **Firebase Cloud Messaging (FCM)** push notifications
- FCM token registration and updates per user
- Order status change notifications
- New product and promotional alerts

### 📦 Product System
- Full product CRUD with variant support
- Product variants with individual stock tracking
- Category-based product filtering
- Latest products endpoint for home page
- Product publish/unpublish workflow by admin

---

## 🏗️ Architecture

The application follows a **role-based API architecture** where each user type accesses a dedicated set of endpoints protected by middleware. The system is designed as a pure **API backend** (no Blade views), intended to be consumed by frontend applications (React, Vue, Flutter, etc.) or mobile apps.

```
┌──────────────────────────────────────────────────────────────────────┐
│                         Client Applications                          │
│                                                                      │
│   ┌────────────────┐  ┌────────────────┐  ┌────────────────────┐   │
│   │  Admin Panel    │  │  Vendor App     │  │  Customer App      │   │
│   │  (Web/Mobile)   │  │  (Web/Mobile)   │  │  (Web/Mobile)      │   │
│   └───────┬────────┘  └───────┬────────┘  └────────┬───────────┘   │
└───────────┼───────────────────┼─────────────────────┼───────────────┘
            │                   │                     │
            │  Bearer Token + Role Middleware          │
            │                   │                     │
┌───────────▼───────────────────▼─────────────────────▼───────────────┐
│                      Laravel 12 API                                  │
│                                                                      │
│   ┌────────────────────────────────────────────────────────────┐    │
│   │                    Middleware Layer                          │    │
│   │  auth:sanctum  |  role:admin  |  role:vendor  |  role:user  │    │
│   └──────────────────────────┬─────────────────────────────────┘    │
│                              │                                       │
│   ┌──────────────────────────▼─────────────────────────────────┐    │
│   │                  Controller Layer                            │    │
│   │                                                              │    │
│   │  AuthApiController    CategoryController    CartController  │    │
│   │  ProductController    VariantController     OrderController │    │
│   │  OrderProductsController                                    │    │
│   └──────────────────────────┬─────────────────────────────────┘    │
│                              │                                       │
│   ┌──────────────────────────▼─────────────────────────────────┐    │
│   │                 Service & Business Logic                     │    │
│   │  Google OAuth  |  Firebase FCM  |  Cart Checkout  |  Stock  │    │
│   └──────────────────────────┬─────────────────────────────────┘    │
│                              │                                       │
│   ┌──────────────────────────▼─────────────────────────────────┐    │
│   │               Eloquent ORM + MySQL                          │    │
│   └────────────────────────────────────────────────────────────┘    │
│                                                                      │
└──────────────────────────────────────────────────────────────────────┘
            │                        │
┌───────────▼──────────┐  ┌──────────▼──────────────────────────────┐
│    MySQL Database     │  │    External Services                     │
│  Users, Products,    │  │    Google OAuth API                       │
│  Variants, Categories│  │    Firebase Cloud Messaging               │
│  Carts, Orders       │  │                                           │
└──────────────────────┘  └──────────────────────────────────────────┘
```

### Role-Based Route Separation

```
/api/
├── /auth/*                    → Public (register, login, Google OAuth)
├── /products/*                → Public (browse) + Vendor (manage)
├── /categories/*              → Public (browse) + Admin (manage)
├── /variants/*                → Public (browse) + Vendor (manage)
├── /admin/*                   → Admin only (users, publish, categories)
├── /user/cart/*               → Customer only (cart, checkout)
├── /user/orders/*             → Customer only (order history)
├── /vendor/products/*         → Vendor only (product management)
├── /vendor/variants/*         → Vendor only (variant management)
├── /vendor/orders/*           → Vendor only (order fulfillment)
└── /profile                   → Authenticated users
```

---

## 🧰 Tech Stack

| Category               | Technology                                                                         |
|------------------------|------------------------------------------------------------------------------------|
| **Framework**          | ![Laravel 12](https://img.shields.io/badge/Laravel-12.x-FF2D20) Laravel 12        |
| **Language**           | ![PHP 8.2](https://img.shields.io/badge/PHP-8.2-777BB4) PHP 8.2+                  |
| **Database**           | ![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1) MySQL                      |
| **ORM**                | Eloquent ORM with Soft Deletes                                                     |
| **API Auth**           | ![Sanctum 4](https://img.shields.io/badge/Sanctum-4.3-FF2D20) Laravel Sanctum     |
| **Social Auth**        | ![Socialite](https://img.shields.io/badge/Socialite-5.27-4285F4) Laravel Socialite |
| **Google API**         | ![Google API](https://img.shields.io/badge/Google_API-2.19-4285F4) google/apiclient |
| **Push Notifications** | ![Firebase](https://img.shields.io/badge/Firebase_SDK-6.2-FFCA28) kreait/laravel-firebase |
| **Docker**             | ![Sail](https://img.shields.io/badge/Laravel_Sail-1.41-2496ED) Laravel Sail        |
| **Code Style**         | Laravel Pint                                                                       |
| **Testing**            | PHPUnit 11                                                                         |
| **Logging**            | Laravel Pail (real-time log streaming)                                             |

---


## 📡 API Endpoints

### 🔑 Authentication (Public)

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| POST | `/api/auth/register` | Register a new user | ❌ |
| POST | `/api/auth/login` | Login and get Sanctum token | ❌ |
| POST | `/api/auth/google` | Google OAuth login | ❌ |
| POST | `/api/auth/google/account` | Get Google account info | ❌ |
| POST | `/api/checkToken` | Validate current token | ❌ |

### 🛍️ Products (Public Browse)

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| GET | `/api/products` | List all products | ❌ |
| GET | `/api/products/{id}` | Get product details | ❌ |
| GET | `/api/products/latest` | Get latest products | ❌ |
| GET | `/api/products/category/{cat_id}` | Get products by category | ❌ |

### 🎨 Variants (Public Browse)

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| GET | `/api/variants` | List all variants | ❌ |
| GET | `/api/variants/{id}` | Get variant details | ❌ |

### 📂 Categories (Public Browse)

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| GET | `/api/categories` | List all visible categories | ❌ |
| GET | `/api/categories/{id}` | Get category details | ❌ |

### 👤 User Profile (Authenticated)

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| GET | `/api/profile` | Get authenticated user profile | ✅ |
| PUT | `/api/auth/notify/save-fcm-token` | Save/update FCM token for notifications | ✅ |

---

### 👑 Admin Endpoints

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| DELETE | `/api/delete/{id}` | Soft-delete a user | 🔒 Admin |
| PUT | `/api/restore/{id}` | Restore a soft-deleted user | 🔒 Admin |
| PUT | `/api/admin/products/publish/{id}` | Publish/unpublish a product | 🔒 Admin |
| POST | `/api/admin/categories` | Create a new category | 🔒 Admin |
| PUT | `/api/admin/categories/{id}` | Update a category | 🔒 Admin |
| DELETE | `/api/admin/categories/{id}` | Delete a category | 🔒 Admin |
| PUT | `/api/categories/SorHCat/{id}` | Show or hide a category | 🔒 Admin |

---

### 🛒 Customer Endpoints

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| GET | `/api/user/cart` | Get user's cart | 🔒 User |
| POST | `/api/user/cart` | Add item to cart | 🔒 User |
| PUT/PATCH | `/api/user/cart/{id}` | Update cart item | 🔒 User |
| DELETE | `/api/user/cart/{id}` | Remove item from cart | 🔒 User |
| DELETE | `/api/user/cart/item/{id}` | Decrement cart item quantity | 🔒 User |
| POST | `/api/user/cart/checkout` | Checkout cart → create order | 🔒 User |
| GET | `/api/user/orders` | List user's orders | 🔒 User |
| GET | `/api/user/orders/{id}` | Get order details | 🔒 User |

---

### 🏪 Vendor Endpoints

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| POST | `/api/vendor/products` | Create a new product | 🔒 Vendor |
| PUT/PATCH | `/api/vendor/products/{id}` | Update a product | 🔒 Vendor |
| DELETE | `/api/vendor/products/{id}` | Delete a product | 🔒 Vendor |
| POST | `/api/vendor/variants` | Create a new variant | 🔒 Vendor |
| PUT/PATCH | `/api/vendor/variants/{id}` | Update a variant | 🔒 Vendor |
| DELETE | `/api/vendor/variants/{id}` | Delete a variant | 🔒 Vendor |
| GET | `/api/vendor/orderProds` | List order products | 🔒 Vendor |
| POST | `/api/vendor/orderProds` | Create order product | 🔒 Vendor |
| GET | `/api/vendor/orderProds/{id}` | Get order product details | 🔒 Vendor |
| PUT/PATCH | `/api/vendor/orderProds/{id}` | Update order product | 🔒 Vendor |
| DELETE | `/api/vendor/orderProds/{id}` | Delete order product | 🔒 Vendor |
| PUT | `/api/vendor/orders/{id}` | Update order status | 🔒 Vendor |

---

## 🔐 Authentication & Roles

The API uses **Laravel Sanctum** for stateless token-based authentication with **role-based middleware** controlling access to endpoints.

### Roles

| Role | Description | Key Capabilities |
|------|-------------|------------------|
| **Admin** | Platform administrator | Manage users (soft-delete/restore), publish products, manage categories, toggle visibility |
| **Vendor** | Seller / shop owner | Manage own products & variants, view and fulfill orders, update order status |
| **User** | Customer / buyer | Browse products, manage cart, checkout, view orders, manage profile |

### Role Middleware Flow

```
┌─────────────┐     ┌──────────────┐     ┌──────────────────┐
│   Request    │────▶│  auth:sanctum│────▶│  role:admin      │──▶ Admin Endpoints
│  + Token     │     │  (Verify     │     │  role:vendor     │──▶ Vendor Endpoints
│              │     │   Bearer     │     │  role:user       │──▶ User Endpoints
│              │     │   Token)     │     │                  │
└─────────────┘     └──────────────┘     └──────────────────┘
                           │                      │
                           ▼                      ▼
                    ┌──────────────┐     ┌──────────────────┐
                    │  401         │     │  403 Forbidden    │
                    │  Unauthenticated│   │  (Wrong Role)     │
                    └──────────────┘     └──────────────────┘
```

---
## 🔵 Google OAuth Integration

The API integrates **Google OAuth** via Laravel Socialite, allowing users to sign in with their Google account without creating a new password.

### Google OAuth Flow

```
┌──────────┐     ┌──────────┐     ┌──────────────┐     ┌──────────────┐
│  Client   │────▶│  API      │────▶│  Google      │────▶│  Google      │
│  App      │     │  /auth/   │     │  OAuth       │     │  Consent     │
│           │     │  google   │     │  Server      │     │  Screen      │
└──────────┘     └──────────┘     └──────────────┘     └──────┬───────┘
                                                                │
                                          ┌─────────────────────┘
                                          ▼
                                   ┌──────────────┐     ┌──────────────┐
                                   │  API receives │────▶│  Create/Find │
                                   │  Google token │     │  User in DB  │
                                   │  + user info  │     │  + Return    │
                                   └──────────────┘     │  Sanctum     │
                                                        │  Token       │
                                                        └──────────────┘
```

### Google OAuth Endpoints

| Endpoint | Purpose |
|----------|---------|
| `POST /api/auth/google` | Send Google ID token → API verifies and logs in/registers user |
| `POST /api/auth/google/account` | Retrieve Google account information |
| `GET /auth/google` | Redirect to Google consent screen (web flow) |
| `GET /auth/google/callback` | Handle Google OAuth callback (web flow) |


## 🔔 Firebase Push Notifications

The API integrates **Firebase Cloud Messaging (FCM)** via the `kreait/laravel-firebase` package, enabling real-time push notifications to users' devices.

### FCM Token Flow

```
┌──────────┐     ┌──────────────────────┐     ┌──────────────┐
│  Client   │────▶│  PUT /auth/notify/   │────▶│  Save FCM    │
│  App      │     │  save-fcm-token      │     │  Token to    │
│           │     │  { fcm_token: "..." } │     │  User Model  │
└──────────┘     └──────────────────────┘     └──────┬───────┘
                                                      │
                                                      ▼
                                               ┌──────────────┐
                                               │  Server sends │
                                               │  Push via FCM │
                                               │  when event   │
                                               │  triggers     │
                                               └──────────────┘
```

### Notification Triggers

| Event | Recipient | Notification |
|-------|-----------|-------------|
| Order status updated | Customer | "Your order #123 is now Shipped" |
| New order placed | Vendor | "New order received for your product" |
| Product published | Vendor | "Your product is now live" |
| Account restored | User | "Your account has been restored" |

---
## 🧩 Core Modules

### Product Variants & Stock

Products can have multiple variants (e.g., different sizes, colors), each with its own stock level:

```
Product: "Running Shoes"
├── Variant: Size 42 / Black   → Stock: 15
├── Variant: Size 42 / White   → Stock: 8
├── Variant: Size 43 / Black   → Stock: 12
└── Variant: Size 44 / Black   → Stock: 0 (Out of Stock)
```

### Cart & Checkout Flow

```
┌──────────┐     ┌──────────┐     ┌──────────┐     ┌──────────┐
│  Add to   │────▶│  Update   │────▶│  Checkout │────▶│  Order   │
│  Cart     │     │  Quantity │     │  (Cart →  │     │  Created │
│           │     │  / Remove │     │  Order)   │     │          │
└──────────┘     └──────────┘     └──────────┘     └──────────┘
                                          │
                                          ▼
                                   ┌──────────────┐
                                   │  Stock       │
                                   │  Decremented │
                                   │  + FCM       │
                                   │  Notification│
                                   └──────────────┘
```

### Admin User Management (Soft Delete)

```
User Lifecycle:
  [Active] ──soft-delete──▶ [Trashed] ──restore──▶ [Active]
                                │
                          (filtered from
                           normal queries)
```

### Category Visibility Toggle

```
Category Visibility:
  [Visible] ──SorHCat──▶ [Hidden] ──SorHCat──▶ [Visible]
                    (hidden categories don't appear in public listing)
```
---



<div align="center">


 If you found this project helpful, please give it a star!

</div>
