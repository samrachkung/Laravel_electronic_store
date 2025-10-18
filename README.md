# E-Commerce Platform

A full-featured Laravel e-commerce platform with Stripe & KHQR payment integration, admin panel, and customer management system.

##  Features

### Customer Features
- ✅ User registration & authentication & forget password with OTP verify 
- ✅ Product catalog with categories & brands
- ✅ Shopping cart functionality
- ✅ Secure Stripe & KHQR checkout
- ✅ Order management & tracking
- ✅ Invoice generation (PDF)
- ✅ Order status tracking with progress bar
- ✅ Multi-language support (English, Khmer)

### Admin Features
- ✅ Admin dashboard with analytics
- ✅ Product management (CRUD)
- ✅ Category & brand management
- ✅ Order management & status updates
- ✅ Inventory management (warehouse)
- ✅ Sales reporting & income tracking
- ✅ User management
- ✅ Telegram Notifications

##  Technology Stack

- **Backend**: Laravel 10.x
- **Frontend**: Bootstrap 5, jQuery
- **Database**: MySQL
- **Payment**: Stripe & KHQR Integration
- **PDF Generation**: DomPDF
- **Icons**: Bootstrap Icons, Font Awesome

##  Installation

### Prerequisites
- PHP 8.1+
- Composer
- MySQL 5.7+
- Node.js & NPM

### Step-by-Step Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/samrachkung/Laravel_electronic_store.git
   cd Laravel_electronic_store
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install frontend dependencies**
   ```bash
   npm install
   npm run build
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure environment variables**
   Edit `.env` file:
   ```env
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   
   STRIPE_KEY=your_stripe_publishable_key
   STRIPE_SECRET=your_stripe_secret_key
   ```

6. **Database setup**
   ```bash
   php artisan migrate --seed
   ```

7. **Storage link**
   ```bash
   php artisan storage:link
   ```

8. **Start development server**
   ```bash
   php artisan serve
   ```

##  Configuration

### Stripe Configuration
1. Create a Stripe account at [stripe.com](https://stripe.com)
2. Get your API keys from Stripe Dashboard
3. Add them to your `.env` file:
   ```env
   STRIPE_KEY=pk_test_your_publishable_key
   STRIPE_SECRET=sk_test_your_secret_key
   ```

### File Upload Configuration
Ensure your `uploads/image` directory is writable:
```bash
chmod -R 755 storage
chmod -R 755 public/uploads
```

##  User Roles

### Customer
- Browse products and categories
- Add products to cart
- Place orders with Stripe payment
- View order history and status
- Download invoices

### Administrator
- Manage all products, categories, and brands
- Process orders and update status
- View sales reports and analytics
- Manage inventory levels
- View customer information

##  Shopping Flow

1. **Browse Products** → Customers can view products by category/brand
2. **Add to Cart** → Select products and quantities
3. **Checkout** → Secure Stripe payment process
4. **Order Confirmation** → Automatic cart clearance and stock update
5. **Order Tracking** → Real-time status updates
6. **Invoice Download** → PDF invoice generation

# E-Commerce Platform - Complete Route Documentation

##  Application Routes Overview

This document provides a comprehensive overview of all available routes in the e-commerce platform.

##  Frontend Routes

### Public Routes (Unauthenticated)

| Method | URI | Name | Controller | Action |
|--------|-----|------|------------|---------|
| GET | `/` | `frontend.home` | `HomeController` | `index` |
| GET | `/about` | `frontend.about` | `AboutController` | `about` |
| GET | `/contact` | `frontend.contact` | `ContactController` | `contact` |
| GET | `/shop` | `frontend.shop` | `ShopController` | `shop` |

### Authentication Routes

| Method | URI | Name | Controller | Action |
|--------|-----|------|------------|---------|
| GET | `/auth/login` | `frontend.login` | `LoginController` | `login` |
| POST | `/auth/login` | `frontend.login.post` | `LoginController` | `authenticate` |
| POST | `/auth/logout` | `frontend.logout` | `LoginController` | `logout` |
| GET | `/auth/register` | `frontend.register` | `RegisterController` | `register` |
| POST | `/auth/register` | `frontend.register.post` | `RegisterController` | `registerUser` |

### Shopping Cart Routes

| Method | URI | Name | Controller | Action |
|--------|-----|------|------------|---------|
| GET | `/cart` | `frontend.cart` | `CartController` | `cart` |
| GET | `/cart/view` | `frontend.cart.view` | `CartController` | `viewCart` |
| POST | `/cart/add` | `frontend.cart.add` | `CartController` | `addToCart` |
| POST | `/cart/remove` | `frontend.cart.remove` | `CartController` | `removeCart` |
| POST | `/cart/update` | `frontend.cart.update` | `CartController` | `updateCart` |

### Authenticated User Routes

| Method | URI | Name | Controller | Action |
|--------|-----|------|------------|---------|
| GET | `/myorder` | `frontend.myorder` | `MyOrderController` | `myorder` |
| GET | `/order/{orderId}/invoice` | `frontend.order.printInvoice` | `MyOrderController` | `printInvoice` |

### Checkout Routes (Authenticated)

| Method | URI | Name | Controller | Action |
|--------|-----|------|------------|---------|
| GET | `/checkout` | `frontend.checkout.index` | `CheckoutController` | `index` |
| POST | `/checkout/placeOrder` | `frontend.checkout.placeOrder` | `CheckoutController` | `placeOrder` |
| GET | `/checkout/success/{order}` | `frontend.checkout.success` | `CheckoutController` | `success` |
| GET | `/checkout/cancel/{order}` | `frontend.checkout.cancel` | `CheckoutController` | `cancel` |

## 🔧 API Routes

### Product API

| Method | URI | Name | Controller | Action |
|--------|-----|------|------------|---------|
| GET | `/api/products/{id}` | `frontend.` | Closure | Return product details |

### Admin API Routes

| Method | URI | Name | Controller | Action |
|--------|-----|------|------------|---------|
| POST | `/api/admin/auth/login` | - | `AdminAuthController` | `login` |
| POST | `/api/admin/auth/logout` | - | `AdminAuthController` | `logout` |
| GET | `/api/admin/auth/me` | - | `AdminAuthController` | `me` |
| GET | `/api/admin/dashboard` | - | `BDashboardController` | `dashboard` |

### User API Routes

| Method | URI | Name | Controller | Action |
|--------|-----|------|------------|---------|
| GET | `/api/auth/csrf-cookie` | - | - | CSRF Cookie |
| POST | `/api/auth/login` | - | `UserAuthController` | `login` |
| POST | `/api/auth/logout` | - | `UserAuthController` | `logout` |
| GET | `/api/auth/me` | - | `UserAuthController` | `me` |
| POST | `/api/auth/register` | - | `UserAuthController` | `register` |

##  Admin Panel Routes

### Authentication

| Method | URI | Name | Controller | Action |
|--------|-----|------|------------|---------|
| GET | `/admin/login` | `admin.login` | `AdminAuthController` | `getloginpage` |
| POST | `/admin/login` | `admin.login.post` | `AdminAuthController` | `postlogin` |

### Dashboard

| Method | URI | Name | Controller | Action |
|--------|-----|------|------------|---------|
| GET | `/admin/dashboard` | `admin.dashboard` | `BDashboardController` | `index` |
| GET | `/admin/dashboard/data` | `admin.` | `BDashboardController` | `getChartData` |

### Product Management

| Method | URI | Name | Controller | Action |
|--------|-----|------|------------|---------|
| GET | `/admin/product` | `admin.product.index` | `BProductController` | `index` |
| POST | `/admin/product` | `admin.product.store` | `BProductController` | `store` |
| GET | `/admin/product/create` | `admin.product.create` | `BProductController` | `create` |
| GET | `/admin/product/{product}` | `admin.product.show` | `BProductController` | `show` |
| PUT/PATCH | `/admin/product/{product}` | `admin.product.update` | `BProductController` | `update` |
| DELETE | `/admin/product/{product}` | `admin.product.destroy` | `BProductController` | `destroy` |
| GET | `/admin/product/{product}/edit` | `admin.product.edit` | `BProductController` | `edit` |

### Category Management

| Method | URI | Name | Controller | Action |
|--------|-----|------|------------|---------|
| GET | `/admin/category` | `admin.category.index` | `BCateogryController` | `index` |
| POST | `/admin/category` | `admin.category.store` | `BCateogryController` | `store` |
| GET | `/admin/category/create` | `admin.category.create` | `BCateogryController` | `create` |
| PUT/PATCH | `/admin/category/{category}` | `admin.category.update` | `BCateogryController` | `update` |
| DELETE | `/admin/category/{category}` | `admin.category.destroy` | `BCateogryController` | `destroy` |
| GET | `/admin/category/{category}/edit` | `admin.category.edit` | `BCateogryController` | `edit` |

### Brand Management

| Method | URI | Name | Controller | Action |
|--------|-----|------|------------|---------|
| GET | `/admin/brand` | `admin.brand.index` | `BBrandController` | `index` |
| POST | `/admin/brand` | `admin.brand.store` | `BBrandController` | `store` |
| GET | `/admin/brand/create` | `admin.brand.create` | `BBrandController` | `create` |
| PUT/PATCH | `/admin/brand/{brand}` | `admin.brand.update` | `BBrandController` | `update` |
| DELETE | `/admin/brand/{brand}` | `admin.brand.destroy` | `BBrandController` | `destroy` |
| GET | `/admin/brand/{brand}/edit` | `admin.brand.edit` | `BBrandController` | `edit` |

### Order Management

| Method | URI | Name | Controller | Action |
|--------|-----|------|------------|---------|
| GET | `/admin/order` | `admin.orders.index` | `BOrderController` | `index` |
| GET | `/admin/order/{id}` | `admin.orders.show` | `BOrderController` | `show` |
| POST | `/admin/order/{id}` | `admin.order.updateStatus` | `BOrderController` | `updateStatus` |
| DELETE | `/admin/order/{id}` | `admin.order.destroy` | `BOrderController` | `destroy` |

### Warehouse & Inventory

| Method | URI | Name | Controller | Action |
|--------|-----|------|------------|---------|
| GET | `/admin/warehouse` | `admin.warehouse` | `BWarehouseController` | `index` |
| GET | `/admin/warehouse/filter` | `admin.warehouse.filter` | `BWarehouseController` | `filter` |
| POST | `/admin/warehouse/{product}/update-stock` | `admin.warehouse.update-stock` | `BWarehouseController` | `updateStock` |

### Sales & Income Reports

| Method | URI | Name | Controller | Action |
|--------|-----|------|------------|---------|
| GET | `/admin/income` | `admin.income` | `IncomeController` | `index` |
| GET | `/admin/income/data` | `admin.income.data` | `IncomeController` | `getIncomeData` |
| GET | `/admin/sales` | `admin.sales` | `BSaleController` | `index` |
| GET | `/admin/sales/chart-data` | `admin.` | `BSaleController` | `getChartData` |

### User Management

| Method | URI | Name | Controller | Action |
|--------|-----|------|------------|---------|
| GET | `/admin/users` | `admin.users.index` | `UserController` | `index` |
| POST | `/admin/users` | `admin.users.store` | `UserController` | `store` |
| GET | `/admin/users/create` | `admin.users.create` | `UserController` | `create` |
| GET | `/admin/users/{user}` | `admin.users.show` | `UserController` | `show` |
| PUT/PATCH | `/admin/users/{user}` | `admin.users.update` | `UserController` | `update` |
| DELETE | `/admin/users/{user}` | `admin.users.destroy` | `UserController` | `destroy` |
| GET | `/admin/users/{user}/edit` | `admin.users.edit` | `UserController` | `edit` |

##  Utility Routes

| Method | URI | Name | Controller | Action |
|--------|-----|------|------------|---------|
| GET | `/lang/{locales}` | - | Closure | Language switcher |
| GET | `/sanctum/csrf-cookie` | `sanctum.csrf-cookie` | `CsrfCookieController` | `show` |

##  Ignition Debug Routes

| Method | URI | Name | Controller | Action |
|--------|-----|------|------------|---------|
| POST | `/_ignition/execute-solution` | `ignition.executeSolution` | `ExecuteSolutionController` | `executeSolution` |
| GET | `/_ignition/health-check` | `ignition.healthCheck` | `HealthCheckController` | `healthCheck` |
| POST | `/_ignition/update-config` | `ignition.updateConfig` | `UpdateConfigController` | `updateConfig` |

##  Key Route Groups

### Frontend Group
- **Prefix**: None
- **Name**: `frontend.`
- **Middleware**: Mixed (some public, some auth)

### Admin Group
- **Prefix**: `/admin`
- **Name**: `admin.`
- **Middleware**: `auth:admin`

### API Group
- **Prefix**: `/api`
- **Middleware**: API authentication

##  Authentication Middleware

- **Frontend Auth**: `auth` middleware
- **Admin Auth**: `auth:admin` middleware  
- **Guest Routes**: Authentication pages
- **API Auth**: Sanctum tokens

##  Usage Examples

### Customer Shopping Flow
```bash
# Browse products
GET /shop

# Add to cart
POST /cart/add

# View cart
GET /cart

# Checkout (authenticated)
GET /checkout
POST /checkout/placeOrder

# View orders
GET /myorder
```

### Admin Management
```bash
# View dashboard
GET /admin/dashboard

# Manage products
GET /admin/product
POST /admin/product

# Process orders
GET /admin/order
POST /admin/order/{id}
```

This route structure provides a complete e-commerce platform with separate frontend shopping experience and backend administration panel.

##  Payment Integration

The system uses Stripe for secure payments:
- Credit card processing
- Secure payment verification
- Automatic order status updates
- Email notifications (can be integrated)

##  Admin Dashboard Features

- Sales analytics and charts
- Order statistics
- Revenue tracking
- Product performance
- Customer insights

##  Security Features

- CSRF protection
- XSS prevention
- SQL injection protection
- Secure file uploads
- Input validation
- Authentication middleware

##  Database Structure

Key Models:
- `User` - Customer accounts
- `Product` - Product information
- `Category` - Product categories
- `Brand` - Product brands
- `Cart` - Shopping cart items
- `Order` - Customer orders
- `OrderItem` - Order line items
- `Address` - Shipping addresses

##  Multi-language Support

Switch between:
- English (en)
- Khmer (kh) 


##  Deployment

### Production Deployment Steps

1. **Server Requirements**
   - PHP 8.1+
   - MySQL 5.7+
   - Web server (Apache/Nginx)

2. **Deployment Commands**
   ```bash
   composer install --optimize-autoloader --no-dev
   npm run production
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan migrate --force
   ```

3. **Environment Setup**
   - Set `APP_ENV=production`
   - Configure production database
   - Set up SSL certificate
   - Configure Stripe live keys

##  Troubleshooting

### Common Issues

1. **Stripe Payment Fails**
   - Check Stripe API keys in `.env`
   - Verify Stripe webhook configuration
   - Check server SSL configuration

2. **Image Upload Issues**
   - Verify `storage/app/public` permissions
   - Check `public/uploads` directory exists
   - Verify file size limits in PHP configuration

3. **PDF Generation Problems**
   - Check DomPDF installation
   - Verify write permissions in storage
   - Check for missing fonts

4. **Cart Not Working**
   - Verify session configuration
   - Check database connections
   - Verify cart relationships in models

##  API Endpoints

### Product API
```
GET /api/products/{id} - Get product details
```

### Cart API
```
POST /cart/add - Add item to cart
POST /cart/update - Update cart quantity  
POST /cart/remove - Remove item from cart
GET /cart/view - View cart contents
```

##  Contributing

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

##  Support

For support and questions:
- Check the troubleshooting section above
- Review Laravel documentation
- Check Stripe integration guides
- Open an issue in the repository
- Massage Me Telegram @samrachkung - Fb : Samrach Kung 

---

**Note**: This is a production-ready e-commerce platform. Make sure to configure all environment variables properly and test thoroughly before deployment.
