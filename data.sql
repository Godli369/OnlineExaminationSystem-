CREATE DATABASE admin;
USE admin;
CREATE TABLE cms_admin(
        id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(10) NOT NULL UNIQUE,
        password VARCHAR(32) NOT NULL
        );
INSERT INTO cms_admin VALUES(1,'admin','123456');

