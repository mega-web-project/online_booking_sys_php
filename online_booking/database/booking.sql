CREATE DATABASE booking;

USE booking;

-- Department table

CREATE TABLE
    departments (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(50),
        status INT DEFAULT 1
    );

-- Users table

CREATE TABLE
    users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(50),
        password VARCHAR(50),
        email VARCHAR(100),
        user_type ENUM(
            'admin',
            'approver',
            'customer'
        ) NOT NULL,
        profile_image VARCHAR(100),
        createddate DATETIME,
        tel VARCHAR(10),
        department_id INT,
        reset_token VARCHAR(100),
        FOREIGN KEY (department_id) REFERENCES Department(department_id)
    );

--Menu table and category

CREATE TABLE
    menu_category (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(50)
    );

CREATE TABLE
    menu (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(50),
        description VARCHAR(255),
        price DECIMAL(10, 2),
        category_id INT,
        FOREIGN KEY (category_id) REFERENCES menu_category(id)
    );


/* Whilelist */


CREATE TABLE whilelist_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    request_id INT NOT NULL,
    user_id INT NOT NULL,
    whilelisted_at DATETIME NOT NULL,
    FOREIGN KEY (request_id) REFERENCES requests(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

/* Request table */
CREATE TABLE requests (
    id INT PRIMARY KEY AUTO_INCREMENT,
    uniqid VARCHAR(255) NOT NULL UNIQUE,
    guest_name VARCHAR(255) NOT NULL,
    guest_address VARCHAR(255) NOT NULL,
    check_in_date DATETIME NOT NULL,
    check_out_date DATETIME NOT NULL,
    purpose_of_visit VARCHAR(255) NOT NULL,
    breakfast VARCHAR(255),
    dinner VARCHAR(255),
    lunch VARCHAR(255),
    num_of_people_for_menu INT NULL,
    num_of_people_for_acco INT NULL,
    employee_names VARCHAR(255),
    visitors_names VARCHAR(255),
    status VARCHAR(255),
    rejection_message VARCHAR(255) DEFAULT NULL,
    requester_id INT NOT NULL,
    approver1 INT DEFAULT NULL,
    approver2 INT DEFAULT NULL,
    approver3 INT DEFAULT NULL,
    approver4 INT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (requester_id) REFERENCES users(id),
    FOREIGN KEY (approver1) REFERENCES users(id),
    FOREIGN KEY (approver2) REFERENCES users(id),
    FOREIGN KEY (approver3) REFERENCES users(id),
    FOREIGN KEY (approver4) REFERENCES users(id)
);


ALTER TABLE requests
ADD COLUMN approver1_status ENUM('Approved', 'Rejected', 'Pending') DEFAULT 'Pending',
ADD COLUMN approver2_status ENUM('Approved', 'Rejected', 'Pending') DEFAULT 'Pending',
ADD COLUMN approver3_status ENUM('Approved', 'Rejected', 'Pending') DEFAULT 'Pending',
ADD COLUMN approver4_status ENUM('Approved', 'Rejected', 'Pending') DEFAULT 'Pending';


/* CREATE TABLE request (
 id INT AUTO_INCREMENT PRIMARY KEY,
 uniqid VARCHAR(255) UNIQUE,
 user_id INT,
 breakfast_menu_id INT,
 lunch_menu_id INT,
 dinner_menu_id INT,
 status ENUM('approved', 'rejected', 'pending'),
 guest_name VARCHAR(255),
 guest_address VARCHAR(255),
 purpose_of_visit VARCHAR(255),
 number_of_people INT,
 menu_people INT,
 check_in_date DATETIME,
 check_out_date DATETIME,
 created_at DATETIME,
 approver_id INT,
 FOREIGN KEY (user_id) REFERENCES users(id),
 FOREIGN KEY (breakfast_menu_id) REFERENCES menu(id),
 FOREIGN KEY (lunch_menu_id) REFERENCES menu(id),
 FOREIGN KEY (dinner_menu_id) REFERENCES menu(id),
 FOREIGN KEY (approver_id) REFERENCES users(id)
 ); */

/* CREATE TABLE request (
 id INT AUTO_INCREMENT PRIMARY KEY,
 uniqid VARCHAR(255) NOT NULL,
 user_id INT NOT NULL,
 breakfast_menu_id INT,
 lunch_menu_id INT,
 dinner_menu_id INT,
 status ENUM('approved', 'rejected', 'pending'),
 guest_name VARCHAR(100),
 guest_address VARCHAR(100),
 purpose_of_visit VARCHAR(255),
 number_of_people INT,
 menu_people VARCHAR(255),
 check_in_date DATETIME NOT NULL,
 check_out_date DATETIME NOT NULL,
 created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
 approver_id INT NULL,
 FOREIGN KEY (user_id) REFERENCES users (id),
 FOREIGN KEY (approver_id) REFERENCES users (id)
 ); */

/* next tabke */

/* CREATE TABLE requests (
 id INT AUTO_INCREMENT PRIMARY KEY,
 uniqid VARCHAR(255) NOT NULL,
 user_id INT NOT NULL,
 breakfast_menu_id INT,
 lunch_menu_id INT,
 dinner_menu_id INT,
 status ENUM('approved', 'rejected', 'pending') DEFAULT 'pending',
 guest_name VARCHAR(100),
 guest_address VARCHAR(100),
 purpose_of_visit VARCHAR(255),
 number_acc_people INT,
 num_menu_people INT,
 menu_people VARCHAR(500),
 check_in_date DATETIME NOT NULL,
 check_out_date DATETIME NOT NULL,
 created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
 approver_id INT NULL,
 FOREIGN KEY (user_id) REFERENCES users (id),
 FOREIGN KEY (approver_id) REFERENCES users (id)
 ); */

/* CREATE TABLE requests (
 id INT AUTO_INCREMENT PRIMARY KEY,
 uniqid VARCHAR(50) UNIQUE,
 guest_name VARCHAR(255),
 guest_address VARCHAR(255),
 check_in_date DATETIME,
 check_out_date DATETIME,
 purpose_of_visit VARCHAR(255),
 breakfast INT,
 dinner INT,
 lunch INT,
 num_of_people_for_menu INT,
 num_of_people_for_acco INT,
 employee_names VARCHAR(255),
 visitors_names VARCHAR(255),
 status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 rejection_message VARCHAR(255),
 requester_id INT,
 approver1_id INT,
 approver2_id INT,
 approver3_id INT,
 admin_id INT,
 FOREIGN KEY (requester_id) REFERENCES users(id),
 FOREIGN KEY (approver1_id) REFERENCES users(id),
 FOREIGN KEY (approver2_id) REFERENCES users(id),
 FOREIGN KEY (approver3_id) REFERENCES users(id),
 FOREIGN KEY (admin_id) REFERENCES users(id)
 );
 */