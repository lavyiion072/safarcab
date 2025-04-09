CREATE TABLE users (
    user_id        INT PRIMARY KEY AUTO_INCREMENT,
    first_name     VARCHAR(100) NOT NULL,
    last_name      VARCHAR(100) NOT NULL,
    email          VARCHAR(255) UNIQUE NOT NULL,
    phone          VARCHAR(15) UNIQUE NOT NULL,
    password       VARCHAR(255) NOT NULL, -- Hashed
    address        TEXT NOT NULL, -- User Address for Checkout
    city           VARCHAR(100) NOT NULL,
    state          VARCHAR(100) NOT NULL,
    pincode        VARCHAR(10) NOT NULL,
    role           ENUM('customer', 'admin') DEFAULT 'customer',
    created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cabs (
    cab_id         INT PRIMARY KEY AUTO_INCREMENT,
    cab_number     VARCHAR(20) UNIQUE NOT NULL,
    model          VARCHAR(100) NOT NULL,
    fuel_type      VARCHAR(100) NOT NULL,
    capacity       INT NOT NULL CHECK (capacity >= 1),
    type           VARCHAR(100) NOT NULL,
    fare_per_km    DECIMAL(10,2) NOT NULL,
    availability   BOOLEAN DEFAULT TRUE
);

CREATE TABLE locations (
    location_id    INT PRIMARY KEY AUTO_INCREMENT,
    city_name      VARCHAR(100) NOT NULL UNIQUE,
    state_name     VARCHAR(100) NOT NULL
);

CREATE TABLE cab_locations (
    cab_id        INT NOT NULL,
    location_id   INT NOT NULL,
    PRIMARY KEY (cab_id, location_id),
    FOREIGN KEY (cab_id) REFERENCES cabs(cab_id) ON DELETE CASCADE,
    FOREIGN KEY (location_id) REFERENCES locations(location_id) ON DELETE CASCADE
);

CREATE TABLE bookings (
    booking_id     INT PRIMARY KEY AUTO_INCREMENT,
    user_id        INT NOT NULL,
    cab_id         INT NOT NULL,
    pickup_point   VARCHAR(255) NOT NULL,
    dropoff_point  VARCHAR(255) NOT NULL,
    pickup_city    VARCHAR(100) NOT NULL,
    dropoff_city   VARCHAR(100) NOT NULL,
    trip_type      ENUM('one-way', 'round-trip') NOT NULL,
    pickup_date    DATE NOT NULL,
    pickup_time    TIME NOT NULL,
    return_date    DATE NULL, -- Required for round-trip
    return_time    TIME NULL, -- Required for round-trip
    total_distance DECIMAL(10,2) NOT NULL, -- Distance in KM
    base_fare      DECIMAL(10,2) NOT NULL, -- Fare before discounts
    discount       DECIMAL(10,2) DEFAULT 0, -- Discount Amount
    total_fare     DECIMAL(10,2) NOT NULL, -- Final Amount After Discount
    status         ENUM('pending', 'confirmed', 'cancelled', 'completed') DEFAULT 'pending',
    checkout_time  TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Checkout Timestamp
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (cab_id) REFERENCES cabs(cab_id) ON DELETE CASCADE
);

CREATE TABLE cab_schedule (
    schedule_id    INT PRIMARY KEY AUTO_INCREMENT,
    cab_id         INT NOT NULL,
    booking_id     INT NOT NULL,
    available_from DATETIME NOT NULL,
    available_until DATETIME NOT NULL,
    FOREIGN KEY (cab_id) REFERENCES cabs(cab_id) ON DELETE CASCADE,
    FOREIGN KEY (booking_id) REFERENCES bookings(booking_id) ON DELETE CASCADE
);

ALTER TABLE cabs ADD COLUMN image_path VARCHAR(255) NULL;

INSERT INTO cabs (cab_number, model, fuel_type, capacity, type, fare_per_km, availability) VALUES
('GJ01AB1234', '    ', 'Diesel', 7, 'SUV', 15.00, 1),
('GJ02XY5678', 'Maruti Dzire', 'Petrol', 4, 'Sedan', 10.00, 1),
('MH05PQ6789', 'Hyundai Xcent', 'CNG', 4, 'Hatchback', 8.00, 1),
('RJ09LM4321', 'Tata Indigo', 'Diesel', 4, 'Sedan', 12.00, 1),
('DL10UV9876', 'Honda Amaze', 'Petrol', 4, 'Sedan', 11.50, 1),
('GJ03KL2345', 'Mahindra XUV500', 'Diesel', 7, 'SUV', 16.50, 1);

INSERT INTO locations (city_name, state_name) VALUES
('Ahmedabad', 'Gujarat'),
('Vadodara', 'Gujarat'),
('Dhwarka', 'Gujarat'),
('Saputara', 'Gujarat'),
('Surat', 'Gujarat'),
('Diu', 'Gujarat');

INSERT INTO cab_locations (cab_id, location_id) VALUES
(1, 1), 
(2, 2), 
(3, 2), 
(4, 3), 
(5, 4), 
(6, 5);

UPDATE cabs 
SET image_path = 'images/cabs/Innova.jpeg' WHERE cab_id = 1;

UPDATE cabs 
SET image_path = 'images/cabs/marutidzire.jpeg' WHERE cab_id = 2;

UPDATE cabs 
SET image_path = 'images/cabs/xcent.jpg' WHERE cab_id = 3;

UPDATE cabs 
SET image_path = 'images/cabs/default.png' WHERE cab_id = 4;

UPDATE cabs 
SET image_path = 'images/cabs/hondaamaze.jpg' WHERE cab_id = 5;

UPDATE cabs 
SET image_path = 'images/cabs/default.png' WHERE cab_id = 6;

ALTER TABLE locations
ADD COLUMN lattitude varchar(255) null;

ALTER TABLE locations
ADD COLUMN longitude varchar(255) null;
