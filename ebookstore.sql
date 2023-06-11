DROP DATABASE ebookstore;
CREATE DATABASE ebookstore;
USE ebookstore;
SET SQL_SAFE_UPDATES = 0;

CREATE TABLE book(
	id INT NOT NULL AUTO_INCREMENT,
	title VARCHAR(255),
    price INT,
    img VARCHAR(255),
    cateId INT,
    PRIMARY KEY (id)
);

CREATE TABLE cart(
	bookId INT,
    cusId INT,
    quantity INT,
    PRIMARY KEY (bookId,cusId)
);

CREATE TABLE customer(
	id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(255),
    password VARCHAR(255),
    
    PRIMARY KEY (id)
);

CREATE TABLE administrator(
	id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(255),
    password VARCHAR(255),
    
    PRIMARY KEY (id)
);

CREATE TABLE category(
	id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255),
    PRIMARY KEY(id)
);

INSERT INTO category(name) VALUES ("Horror"),("Fantasy"),("Romantic");

INSERT INTO book(title,price,img,cateId) VALUES ("Book1",100,"https://upload.wikimedia.org/wikipedia/vi/4/45/Berserk_vol01.jpg",1),
("Book2",200,"https://upload.wikimedia.org/wikipedia/vi/4/45/Berserk_vol01.jpg",2),
("Book3",250,"https://upload.wikimedia.org/wikipedia/vi/4/45/Berserk_vol01.jpg",3),
("Book4",260,"https://upload.wikimedia.org/wikipedia/vi/4/45/Berserk_vol01.jpg",2),
("Book5",270,"https://upload.wikimedia.org/wikipedia/vi/4/45/Berserk_vol01.jpg",1),
("Book6",270,"https://upload.wikimedia.org/wikipedia/vi/4/45/Berserk_vol01.jpg",2),
("Book7",270,"https://upload.wikimedia.org/wikipedia/vi/4/45/Berserk_vol01.jpg",3),
("Book8",270,"https://upload.wikimedia.org/wikipedia/vi/4/45/Berserk_vol01.jpg",3),
("Book9",270,"https://upload.wikimedia.org/wikipedia/vi/4/45/Berserk_vol01.jpg",1),
("Book10",270,"https://upload.wikimedia.org/wikipedia/vi/4/45/Berserk_vol01.jpg",1);

INSERT INTO customer(username, password) VALUES ("trinhdeptrai","123abc"),
("tomatopice","985123A@b");

INSERT INTO administrator(username, password) VALUES ("admin","123456");

