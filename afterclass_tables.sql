CREATE TABLE users (
  id VARCHAR(10) PRIMARY KEY,
  index_number VARCHAR(10),
  first_name VARCHAR(50),
  last_name VARCHAR(50),
  phone_number VARCHAR(20),
  password VARCHAR(255),
  created_at TIMESTAMP,
  approved TINYINT(1)
);

CREATE TABLE request_tutor (
  request_id VARCHAR(20) PRIMARY KEY,
  id VARCHAR(10),
  user_type ENUM('tutor', 'tutee'),
  programme VARCHAR(255),
  course VARCHAR(255),
  preferred_time VARCHAR(255),
  preferred_gender ENUM('male', 'female'),
  notes TEXT,
  accepted_by VARCHAR(10),
  status ENUM('pending', 'accepted', 'cancelled'),
  created_at TIMESTAMP
);

CREATE TABLE applications (
  id VARCHAR(10) PRIMARY KEY,
  email VARCHAR(255),
  programme VARCHAR(255),
  level INT(11),
  cgpa DECIMAL(3,2),
  gender ENUM('male', 'female'),
  transcript LONGBLOB,
  user_id VARCHAR(10),
  created_at TIMESTAMP
);

CREATE TABLE user_notifications (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  user_id VARCHAR(10),
  message TEXT,
  created_at TIMESTAMP,
  request_id VARCHAR(20),
  status ENUM('pending', 'accepted', 'cancelled'),
  is_read TINYINT(1)
);

CREATE TABLE admin_users (
  admin_username VARCHAR(255) PRIMARY KEY,
  password VARCHAR(255)
);

CREATE TABLE notifications (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  message TEXT,
  created_at TIMESTAMP,
  is_read TINYINT(1)
);
