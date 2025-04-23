# Electronic Store

## Features

- **User Authentication:**
    - Registration✅
    - Login✅
    - Password Reset

- **Product Management:**
    - Add, Edit, Delete Products✅
    - Product Categories✅
    - Product Reviews

- **Shopping Cart:**
    - Add to Cart✅
    - Update Cart✅
    - Remove from Cart✅

- **Order Management:**
    - Place Orders✅
    - Order History
    - Order Tracking✅

- **Admin Dashboard:**
    - User Management
    - Order Management✅
    - Product Management✅

- **Search Functionality:**
    - Search Products by Name, Category, and Tags

- **Responsive Design:**
    - Mobile and Tablet Friendly✅

- **API Integration:**
    - RESTful API for Mobile App Integration

- **Payment Gateway:**
    - Integration with popular payment gateways✅

- **Notifications:**
    - Email Notifications for Orders and Account Activities ✅

- **Wishlist:**
    - Add Products to Wishlist
    - Manage Wishlist Items

- **Live Chat Support:**
    - Real-time Chat with Customer Support

- **Discounts and Coupons:**
    - Apply Discount Codes
    - Manage Promotional Offers

- **Multi-language Support:**
    - Support for Multiple Languages

- **Multi-currency Support:**
    - Display Prices in Different Currencies

- **Analytics and Reports:**
    - Sales Reports
    - User Activity Reports

- **Product Recommendations:**
    - Personalized Product Suggestions

- **Social Media Integration:**
    - Share Products on Social Media
    - Social Login Options

- **Inventory Management:**
    - Track Stock Levels
    - Low Stock Alerts

- **Customer Reviews and Ratings:**
    - Allow Customers to Rate and Review Products

- **Gift Cards:**
    - Purchase and Redeem Gift Cards

- **Advanced Security:**
    - Two-Factor Authentication
    - Data Encryption


## Database Design

  **Table**

- Users   
- Products
- Categories  
- Orders  
- Order Items 
- Shopping Cart   
- Wishlist
- Reviews 
- Payments
- Coupons 
- Notifications   
- Analytics   
- Chat Messages   
- Languages   
- Currencies  
- Gift Cards  
- Inventory   


The database design for the electronic store includes the following key tables:

- **Users Table:**
    - Stores user information such as 
    username, 
    email, 
    password, 
    roles (e.g., admin, customer, seller).,
    permission (e.g., full, read, write).,


- **Products Table:**
    - Contains product details like 
    name, 
    description, 
    price, 
    stock quantity
    , category
    ,  images.

- **Categories Table:**
    - Manages product categories with fields for category name and description.

- **Orders Table:**
    - Tracks order details including user ID, order date, total amount, and order status.

- **Order Items Table:**
    - Links products to orders with fields for order ID, product ID, quantity, and price.

- **Shopping Cart Table:**
    - Stores temporary cart data for users, including user ID, product ID, and quantity.

- **Wishlist Table:**
    - Manages user wishlists with fields for user ID and product ID.

- **Reviews Table:**
    - Stores customer reviews and ratings with fields for product ID, user ID, rating, and review text.

- **Payments Table:**
    - Tracks payment transactions with fields for order ID, payment method, amount, and status.

- **Coupons Table:**
    - Manages discount codes with fields for code, discount percentage, expiration date, and usage limits.

- **Notifications Table:**
    - Stores notification data for emails and alerts with fields for user ID, type, and message.

- **Analytics Table:**
    - Logs user activity and sales data for generating reports.

- **Chat Messages Table:**
    - Stores live chat messages with fields for user ID, admin ID, message content, and timestamp.

- **Languages Table:**
    - Manages supported languages with fields for language code and name.

- **Currencies Table:**
    - Tracks supported currencies with fields for currency code, symbol, and exchange rate.

- **Gift Cards Table:**
    - Stores gift card details like code, balance, and expiration date.

- **Inventory Table:**
    - Tracks stock levels and low stock alerts for products.

This database structure ensures efficient data management and supports all the features of the electronic store.
