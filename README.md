# Laravel 8 Rest API with Sanctum Token

> ### Laravel + MySQL codebase containing examples (CRUD, auth, advanced patterns, validation, migration, seeding, etc).

This codebase was created to demonstrate a fully functional REST API built with **Laravel 8 + Sanctum + MySQL**, including CRUD operations, routing,validation, pagination, migration, seeding and more.

Hope you'll find this example helpful. Pull requests are welcome!

----------

# Getting started

## Installation

Please check the official Lumen installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/8.x/installation)


Clone the repository

    git clone https://github.com/rais-manasiya/rais_case_study.git

Switch to the repo folder

    cd rais_case_study

Install all the dependencies using composer

    composer install

Copy the example env file (if does not exist) and make the required configuration changes in the .env file

    cp .env.example .env

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Run the database seeding to generate user for authentication

    php artisan db:seed

Start the local development server

    php artisan serve

You can now access the server at http://127.0.0.1:8000

**TL;DR command list**

    git clone https://github.com/rais-manasiya/rais_case_study.git
    cd rais_case_study
    composer install
    cp .env.example .env
    
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan db:seed
    php artisan serve

***Note*** : First time database table will be an empty, You will have to insert data using post method

## Folders

- `app` - Contains all the Eloquent models
- `app/Http/Controllers` - Contains all the api controllers
- `app/Providers` - Contains all the service providers
- `config` - Contains all the application configuration files
- `database/migrations` - Contains all the database migrations
- `routes` - Contains all the api routes defined in web.php file

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

----------

# Testing API

Run the Laravel development server

    php arisan serve

The api can now be accessed at

    http://127.0.0.1:8000
    
### API Routes
| HTTP Method	| URI | Action | Scope | Desciption  |
| ----- | ----- | ----- | ---- |------------- |
| POST      | /auth/login | login |  | Get token to begin with 
| POST      | /register | register |  | Register with User & Get token to begin with 
| GET      | /products | show | products.index | Get all products
| POST     | /products | store | products.store | Create new product
| GET      | /products/{product} | show | products.show |  Get product by product_id
| PUT      | /products/{product} | update | products.update | Update product by product_id
| DELETE      | /products/{product} | destroy | products.destroy | Delete product by product_id
| GET      | /cart | show | cart.index | Get all products stored in the cart
| POST     | /cart | store | products.store | Add product to the cart
| PUT      | /cart/{cart} | update | cart.update | Update product in the cart by cart_id
| DELETE      | /cart/{cart} | destroy | cart.destroy | Remove product from the cart by cart_id


### API Usage

To get token login with: email=rais@gmail.com password=123456

    POST http://127.0.0.1:8000/auth/login
    
    email:rais@gmail.com 
    password:123456

    Output:
    {
    "message": "Hi Rais, welcome to home",
    "access_token": "1|AD0aGteErSJTcwgnJiEohz......",
    "token_type": "Bearer"
    }

OR you can register with new USER & get the auth token, Use below API

    POST http://127.0.0.1:8000/register
    
    name:Rais
    email:rais.manasiya@gmail.com
    password:12345678

    Output:
    {
    "data": {
        "name": "Rais",
        "email": "rais.manasiya@gmail.com",
        "updated_at": "2022-07-01T14:53:35.000000Z",
        "created_at": "2022-07-01T14:53:35.000000Z",
        "id": 1
    },
    "access_token": "1|04U5FZtOuodiFTRKMLHLeYbL7Vmiar4......",
    "token_type": "Bearer"
    }  

Add product to the Cart

    POST http://127.0.0.1:8000/cart

    Accept: application/json
    Authorization: Bearer 1|04U5FZtOuodiFTRKMLHLeYbL7Vmiar4.....
    Content-Type: application/x-www-form-urlencoded

    user_id=1&product_id=3&qty=2

    OUTPUT:
    
    {
    "success": true,
    "message": "Product added to the Cart.",
    "data": {
        "user_id": "1",
        "product_id": "3",
        "qty": "2",
        "updated_at": "2022-07-01T14:04:51.000000Z",
        "created_at": "2022-07-01T14:04:51.000000Z",
        "id": 2
        }
    }

List all items in the cart

    GET http://127.0.0.1:8000/cart

    Accept: application/json
    Authorization: Bearer 6|HGWCSd9XGRbbe4Tf5RpOpYTg1tqbz6r69B2UcLTm

    OUTPUT:
    {
    "success": true,
    "message": "Products in cart",
    "data": [
        {
            "name": "Iphone 13",
            "qty": 2,
            "price": 85000,
            "avatar": "images/avatra2.png"
        }
        ]
    }

Update cart Item

    PUT http://127.0.0.1:8000/cart/1

    Accept: application/json
    Authorization: Bearer 1|04U5FZtOuodiFTRKMLHLeYbL7Vmiar4.....
    Content-Type: application/x-www-form-urlencoded

    user_id=1&product_id=3&qty=2&session_id=sesid9866bgf65665

    OUTPUT:

    {
    "success": true,
    "message": "Product updated successfully.",
    "data": {
        "id": 1,
        "session_id": "sesid9866bgf65665",
        "user_id": "1",
        "product_id": "3",
        "qty": "2",
        "created_at": "2022-07-01T14:03:05.000000Z",
        "updated_at": "2022-07-01T14:04:45.000000Z"
        }
    }

Remove cart Item

    DELETE http://127.0.0.1:8000/cart/2

    Accept: application/json
    Authorization: Bearer 1|04U5FZtOuodiFTRKMLHLeYbL7Vmiar4.....
    Content-Type: application/x-www-form-urlencoded

    OUTPUT:
    {
    "success": true,
    "message": "Product deleted from the Cart successfully."
    }

=======================================================================================================================

Product API does not use AUTH Token

To fetch all products 

    GET http://127.0.0.1:8000/products

    OUTPUT:
    {
    "success": true,
    "message": "Product List",
    "data": [
        {
            "id": 1,
            "name": "Iphone 13",
            "price": 85000,
            "category": "Mobile",
            "description": "Product Description",
            "avatar": "images/iphone_avt.png",
            "created_at": "2022-07-01T14:54:05.000000Z",
            "updated_at": "2022-07-01T14:54:05.000000Z"
        },
        {
            "id": 2,
            "name": "Macbook M2",
            "price": 1300000,
            "category": "Laptop",
            "description": "Product Description",
            "avatar": "images/macbook_m2_avt.png",
            "created_at": "2022-07-01T14:54:16.000000Z",
            "updated_at": "2022-07-01T14:54:16.000000Z"
        }
        ]
    }    
    
To fetch single product

    GET http://127.0.0.1:8000/products/1
   
    OUTPUT:
    {
    "success": true,
    "message": "Product retrieved successfully.",
    "data": {
        "id": 1,
        "name": "Iphone 13",
        "price": 85000,
        "category": "Mobile",
        "description": "Product Description",
        "avatar": "images/iphone_avt.png",
        "created_at": "2022-07-01T14:54:05.000000Z",
        "updated_at": "2022-07-01T14:54:05.000000Z"
        }
    }
   
To Add new product
    
    Post http://127.0.0.1:8000/products

    Accept: application/json
    Content-Type: application/x-www-form-urlencoded

    Post Parameters:
    name=Iphone 13, price=85000, category=Mobile, description=Product Description, avatar=images/iphone_avt.png

    OUTPUT:
    {
    "success": true,
    "message": "Product added successfully.",
    "data": {
        "name": "Iphone 13",
        "price": 85000,
        "category": "Mobile",
        "description": "Product Description",
        "avatar": "images/iphone_avt.png",
        "created_at": "2022-07-01T14:54:05.000000Z",
        "updated_at": "2022-07-01T14:54:05.000000Z"
        "id": 1
    }
}

To Edit new product
    
    PUT http://127.0.0.1:8000/products/4
   
    Accept: application/json
    Content-Type: application/x-www-form-urlencoded

    Post Parameters:
    name=Iphone 13, price=85000, category=Mobile, description=Product Description, avatar=images/iphone_avt.png

    OUTPUT:
    {
    "success": true,
    "message": "Product updated successfully.",
    "data": {
        "name": "Iphone 13",
        "price": 85000,
        "category": "Mobile",
        "description": "Product Description",
        "avatar": "images/iphone_avt.png",
        "created_at": "2022-07-01T14:54:05.000000Z",
        "updated_at": "2022-07-01T14:54:05.000000Z"
        "id": 1
    }

    
To delete(soft delete) product

    http://127.0.0.1:8000/products/1
   
    OUTPUT:
    {
    "success": true,
    "message": "Product deleted successfully."
    }
    

Validation, pagination and soft delete features are added






