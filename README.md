# Eshhnly API

## Description
Eshhnly is a ride-sharing and shipment service that allows users to create trips, manage shipments, and book rides. The project is built using **Laravel** for the backend and follows RESTful API principles.

## Features
- **User Authentication** (Register, Login, JWT-based authentication)
- **Clients Management** (CRUD operations for clients)
- **Trips Management** (Create, Read, Update, Delete trips)
- **Shipments Management** (CRUD operations for shipments)
- **Booking System** (Allow users to book trips for shipments)

## Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/your-repo/eshhnly.git
   ```
2. Navigate to the project directory:
   ```bash
   cd eshhnly
   ```
3. Install dependencies:
   ```bash
   composer install
   ```
4. Configure environment variables:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
5. Set up the database and run migrations:
   ```bash
   php artisan migrate --seed
   ```
6. Start the development server:
   ```bash
   php artisan serve
   ```

## API Endpoints

### **Authentication**
- **Register a user**  
  `POST /api/auth/register`
  ```json
  {
    "name": "John Doe",
    "email": "john@example.com",
    "password": "12345678",
    "password_confirmation": "12345678"
  }
  ```
- **Login a user**  
  `POST /api/auth/login`
  ```json
  {
    "email": "john@example.com",
    "password": "12345678"
  }
  ```

### **Clients**
- **Create a Client**  
  `POST /api/clients`
  ```json
  {
    "name": "Client4",
    "email": "client4@example.com",
    "password": "12345678",
    "phone": "01012345678"
  }
  ```
- **Get all Clients**  
  `GET /api/clients`
- **Get a specific Client**  
  `GET /api/clients/{id}`
- **Update a Client**  
  `PUT /api/clients/{id}`
  ```json
  {
    "name": "Updated Name",
    "phone": "01111222333"
  }
  ```
- **Delete a Client**  
  `DELETE /api/clients/{id}`

### **Trips**
- **Create a Trip**  
  `POST /api/trips`
  ```json
  {
    "From": "Cairo",
    "To": "Alexandria",
    "departure_date": "2025-03-10",
    "arrival_date": "2025-03-11",
    "free_weight": 500.0,
    "status": "pending",
    "created_by": 1
  }
  ```
- **Get all Trips**  
  `GET /api/trips`
- **Get a specific Trip**  
  `GET /api/trips/{id}`
- **Update a Trip**  
  `PUT /api/trips/{id}`
  ```json
  {
    "From": "Giza",
    "To": "Luxor",
    "free_weight": 700.0,
    "status": "completed"
  }
  ```
- **Delete a Trip**  
  `DELETE /api/trips/{id}`

### **Shipments**
- **Create a Shipment**  
  `POST /api/ships`
  ```json
  {
    "note": "Electronics shipment",
    "from": "Cairo",
    "to": "Alexandria",
    "weight": 15.5,
    "price": 250.75,
    "quantity": 3,
    "status": "pending",
    "added_by": 1
  }
  ```
- **Get all Shipments**  
  `GET /api/ships`
- **Update a Shipment**  
  `PATCH /api/ships/{id}`
  ```json
  {
    "status": "in_transit"
  }
  ```
- **Delete a Shipment**  
  `DELETE /api/ships/{id}`

### **Bookings**
- **Create a Booking**  
  `POST /api/bookings`
  ```json
  {
    "price": 100.5,
    "status": "pending",
    "trip_id": 1,
    "ship_id": 1
  }
  ```
- **Get all Bookings**  
  `GET /api/bookings`
- **Delete a Booking**  
  `DELETE /api/bookings/{id}`

## Authentication
All secured endpoints require a **Bearer Token**. Use the token received during login in the `Authorization` header:
```http
Authorization: Bearer {your_token_here}
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License
This project is licensed under the MIT License.

