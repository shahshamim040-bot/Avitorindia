CREATE DATABASE IF NOT EXISTS aviator_db;
USE aviator_db;

-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    country VARCHAR(50) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    refer_code VARCHAR(50) UNIQUE,
    referred_by VARCHAR(50),
    balance DECIMAL(10,2) DEFAULT 0.00,
    is_verified INT DEFAULT 0,
    status VARCHAR(20) DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Transactions Table (Deposit & Withdraw)
CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_email VARCHAR(100),
    type VARCHAR(20), -- Deposit / Withdraw
    method VARCHAR(20), -- bKash / Nagad
    amount DECIMAL(10,2),
    sender_number VARCHAR(20),
    trx_id VARCHAR(100),
    screenshot VARCHAR(255),
    status VARCHAR(20) DEFAULT 'Pending', -- Pending / Success / Rejected
    reject_reason TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Admin Notice Table
CREATE TABLE notice (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
INSERT INTO notice (message) VALUES ('স্বাগতম Aviator India-এ! ডিপোজিট করার আগে নোটিশ বোর্ড চেক করুন।');