# Z+ Software Solutions

A Laravel-based eCommerce platform for selling digital products, software licenses, and managing customer accounts.

## Features

### Admin Panel
- ✅ Dashboard with sales statistics and recent orders
- ✅ Product management (CRUD operations)
- ✅ Order management and customer data
- ✅ License generation and management
- ✅ Content management (blog posts, pages)
- ✅ User management with role-based access

### Customer Portal
- ✅ User registration and authentication
- ✅ Profile management
- ✅ License management
- ✅ Download history
- ✅ Order history

### Frontend
- ✅ Responsive design for desktop, tablet, and mobile devices
- ✅ Home page with featured products and company information
- ✅ About page with company information
- ✅ Products listing page with filtering and sorting options
- ✅ Product detail pages with specifications, pricing, and screenshots
- ✅ Blog/News section with articles and industry updates
- ✅ Projects/Portfolio showcase of past work and case studies
- ✅ Contact page with Google Maps integration and contact form
- ✅ Shopping cart
- ✅ Checkout process
- ⬜ Payment gateway integration

### Technical Features
- ✅ Built with Laravel 10 and PHP 8.2+
- ✅ Uses Tailwind CSS for responsive frontend
- ✅ Integration with Alpine.js for interactive UI components
- ✅ Secure download system with tokenized links
- ✅ License key generation and validation
- ⬜ API endpoints for third-party integrations
- ⬜ Webhook support for payment notifications

## Installation

### Requirements
- PHP 8.2 or higher
- Composer
- MySQL or PostgreSQL
- Node.js and NPM

### Setup Instructions
1. Clone the repository
   ```
   git clone https://github.com/yourusername/zplus.git
   ```

2. Install dependencies
   ```
   composer install
   npm install
   ```

3. Create the environment file
   ```
   cp .env.example .env
   ```

4. Configure your database settings in the `.env` file

5. Generate application key
   ```
   php artisan key:generate
   ```

6. Run migrations and seed the database
   ```
   php artisan migrate --seed
   ```

7. Link storage
   ```
   php artisan storage:link
   ```

8. Compile assets
   ```
   npm run dev
   ```

9. Start the development server
   ```
   php artisan serve
   ```

## Default Credentials

After seeding the database, you can log in with the following credentials:

- Admin:
  - Email: admin@example.com
  - Password: password

- Customer:
  - Email: customer@example.com  
  - Password: password

## License

This project is licensed under the MIT License.
