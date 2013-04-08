CREATE TABLE users ( id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(256), email VARCHAR(256), password VARCHAR(256));
CREATE TABLE groups (user_one INT, user_two INT, status INT);
CREATE TABLE purchases (id INT AUTO_INCREMENT PRIMARY KEY, user_submit INT, user_view INT, status INT, amount FLOAT(2), description VARCHAR(140));
