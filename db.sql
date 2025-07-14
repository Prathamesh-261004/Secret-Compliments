CREATE DATABASE IF NOT EXISTS secret_compliments;
USE secret_compliments;

-- Users Table
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(100) UNIQUE,
  username VARCHAR(50) UNIQUE,
  password VARCHAR(255),
  profile_pic VARCHAR(255),
  display_name VARCHAR(100) DEFAULT NULL,
  description TEXT DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Photos Table
CREATE TABLE photos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user VARCHAR(50),
  photo_path VARCHAR(255),
  views INT DEFAULT 0,
  uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Comments Table
CREATE TABLE comments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  from_user VARCHAR(50),
  to_user VARCHAR(50),
  photo_id INT,
  comment_text TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Friend Requests Table
CREATE TABLE friend_requests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sender VARCHAR(50),
  receiver VARCHAR(50),
  status ENUM('pending','accepted') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Reactions Table
CREATE TABLE reactions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  from_user VARCHAR(50),
  to_user VARCHAR(50),
  photo_id INT,
  emoji VARCHAR(10),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Reports Table
CREATE TABLE reports (
  id INT AUTO_INCREMENT PRIMARY KEY,
  comment_id INT,
  reported_by VARCHAR(50),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
