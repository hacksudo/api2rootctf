CREATE DATABASE IF NOT EXISTS vulnreset;
USE vulnreset;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    otp VARCHAR(10),
    otp_attempts INT DEFAULT 0,
    otp_last_sent DATETIME NULL
);

INSERT INTO users (email, password) VALUES ('admin@hacksudo.com', MD5('admin123'))
ON DUPLICATE KEY UPDATE email=email;
