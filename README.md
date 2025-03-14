# README

## Laravel Senior Developer Exam

### Setup

- clone repository
- make launch
- make setup
- make setup-asset

### Login credentials

#### Admin

```
email: admin@example.com
password: password
```

#### Non-Admin

```
email: user@example.com
password: password
```

### System Summary

- `Models:` `User`, `Product`
- `User` has many `Product`
- User model has a method to call all products
- Has a middleware to check if user is admin
- Added del_flag
- Created global scope to filter products that are not deleted
- `Product::all()` returns only not deleted products
- Created routes for admins only
    - admin/users
    - admin/products
- Admin can view all users with their products
- non-admin users can (create, update, delete, view) products
- non-admin users can only view their product
- Create custom command to update quantity of the products `php artisan products:update-quantity {quantity}`
- Added ftp server for saving images
- Created scheduler to delete products with less than 10 quantity every monday midnight
- Dispatch cron job via event channel to send email every time product is created
- Integrated <https://fakestoreapi.com/> and <https://fakeapi.platzi.com/>` using Interface
- Admin user can view and add products from the api's
- Admin can switch which api will be used
- Used mysql for unit test not sqlite and should be different from the database used by the app.
- Used caching for get all products
- Dockerized

### What are not done

- Unit Tests
- Api documentation
