CREATE DATABASE IF NOT EXISTS brain_boost CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE brain_boost;

-- Tabelat
CREATE TABLE IF NOT EXISTS users (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    firstname  VARCHAR(50)  NOT NULL,
    lastname   VARCHAR(50)  NOT NULL,
    email      VARCHAR(150) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    role       ENUM('admin','user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS courses (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    title       VARCHAR(200) NOT NULL,
    description TEXT         NOT NULL,
    price       DECIMAL(8,2) NOT NULL DEFAULT 0.00,
    instructor  VARCHAR(100) NOT NULL,
    file_path   VARCHAR(300) DEFAULT NULL,
    video_url   VARCHAR(500) DEFAULT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS purchases (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT NOT NULL,
    course_id  INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id)   REFERENCES users(id)   ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    UNIQUE KEY unique_purchase (user_id, course_id)
);

CREATE TABLE IF NOT EXISTS contact_messages (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL,
    message    TEXT         NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- insertimi i demo data

-- Admin password: Admin123!
INSERT INTO users (firstname, lastname, email, password, role) VALUES
('Admin', 'User', 'admin@brainboost.com', '$2y$12$siEx9PMYF.yPyzNO47c9cujpxM/IBmxXpBWJ/blh3LojeuS6jcByu', 'admin');

-- User password: User123!
INSERT INTO users (firstname, lastname, email, password, role) VALUES
('Demo', 'Student', 'student@brainboost.com', '$2y$12$0J/vOAzdH9XNL/TYJgeLSOHrUPJu3dO4Gzg1hrTQs2T9zY8kGoN7i', 'user');

INSERT INTO courses (title, description, price, instructor, video_url) VALUES
('PHP Basics',            'Learn PHP from zero to hero. Variables, loops, functions, OOP and more.', 29.99, 'Admin User', ''),
('OOP in PHP',            'Master Object-Oriented Programming. Classes, inheritance, interfaces.',   24.99, 'Admin User', ''),
('JavaScript Fundamentals','DOM manipulation, events, fetch API, async/await and ES6+ features.',    19.99, 'Admin User', ''),
('MySQL & Databases',     'Relational databases, SQL queries, joins, indexes and optimization.',     34.99, 'Admin User', '');
