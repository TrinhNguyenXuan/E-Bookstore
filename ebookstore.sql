DROP DATABASE ebookstore;
CREATE DATABASE ebookstore;
USE ebookstore;
SET SQL_SAFE_UPDATES = 0;

CREATE TABLE book(
	id INT NOT NULL AUTO_INCREMENT,
	title VARCHAR(255),
    price INT,
    img MEDIUMBLOB,
    description TEXT,
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
    name VARCHAR (255),
    
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

CREATE TABLE evaluation(
	id INT NOT NULL AUTO_INCREMENT,
    rating INT,
    comment VARCHAR(255),
    cusId INT,
    bookId INT,
    
    PRIMARY KEY (id)
);

CREATE TABLE product_img(
	id INT NOT NULL AUTO_INCREMENT,
    img MEDIUMBLOB,
    bookId INT,
    PRIMARY KEY (id)
);

INSERT INTO category(name) VALUES ("Horror"),("Fantasy"),("Romantic");

-- INSERT INTO book(title,price,img,description,cateId) VALUES ("Book1",100,"https://upload.wikimedia.org/wikipedia/vi/4/45/Berserk_vol01.jpg","Description 1",1),
-- ("Book2",200,"https://upload.wikimedia.org/wikipedia/vi/4/45/Berserk_vol01.jpg","Description 2",2),
-- ("Book3",250,"https://upload.wikimedia.org/wikipedia/vi/4/45/Berserk_vol01.jpg","Description 3",3),
-- ("Book4",260,"https://upload.wikimedia.org/wikipedia/vi/4/45/Berserk_vol01.jpg","Description 4",2),
-- ("Book5",270,"https://upload.wikimedia.org/wikipedia/vi/4/45/Berserk_vol01.jpg","Description 5",1),
-- ("Book6",270,"https://upload.wikimedia.org/wikipedia/vi/4/45/Berserk_vol01.jpg","Description 6",2),
-- ("Book7",270,"https://upload.wikimedia.org/wikipedia/vi/4/45/Berserk_vol01.jpg","Description 7",3),
-- ("Book8",270,"https://upload.wikimedia.org/wikipedia/vi/4/45/Berserk_vol01.jpg","Description 8",3),
-- ("Book9",270,"https://upload.wikimedia.org/wikipedia/vi/4/45/Berserk_vol01.jpg","Description 9",1),
-- ("Book10",270,"https://upload.wikimedia.org/wikipedia/vi/4/45/Berserk_vol01.jpg","Description 10",1);

INSERT INTO customer(username, password,name) VALUES 
("trinhdeptrai","123abc","Nguyen Xuan Trinh"),
("tomatopice","985123A@b", "Lionel Messi"),
("hiphopneverdie","asd148$%#", "Erling Haaland")
;

INSERT INTO administrator(username, password) VALUES ("admin","123456");

INSERT INTO evaluation(rating, comment, cusId, bookId) VALUES 
(5,"Tạm ổn",1,1),
(4,"Sách chán òm",2,1),
(1,"Sách chán quá trời",1,1);

