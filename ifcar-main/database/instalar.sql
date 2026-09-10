CREATE DATABASE IF NOT EXISTS `IfCar-main`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

CREATE USER IF NOT EXISTS 'ifcar_app'@'localhost'
    IDENTIFIED BY 'ifcar_dev_2026';

GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER, INDEX, REFERENCES
    ON `IfCar-main`.*
    TO 'ifcar_app'@'localhost';

FLUSH PRIVILEGES;
