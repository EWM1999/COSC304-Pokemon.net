DROP TABLE review;
DROP TABLE shipment;
DROP TABLE productinventory;
DROP TABLE warehouse;
DROP TABLE orderproduct;
DROP TABLE incart;
DROP TABLE product;
DROP TABLE category;
DROP TABLE ordersummary;
DROP TABLE paymentmethod;
DROP TABLE customer;


CREATE TABLE customer (
    customerId          INT IDENTITY,
    firstName           VARCHAR(40),
    lastName            VARCHAR(40),
    email               VARCHAR(50),
    phonenum            VARCHAR(20),
    address             VARCHAR(50),
    city                VARCHAR(40),
    state               VARCHAR(20),
    postalCode          VARCHAR(20),
    country             VARCHAR(40),
    userid              VARCHAR(20),
    password            VARCHAR(30),
    PRIMARY KEY (customerId)
);

CREATE TABLE paymentmethod (
    paymentMethodId     INT IDENTITY,
    paymentType         VARCHAR(20),
    paymentNumber       VARCHAR(30),
    paymentExpiryDate   DATE,
    customerId          INT,
    PRIMARY KEY (paymentMethodId),
    FOREIGN KEY (customerId) REFERENCES customer(customerid)
        ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE ordersummary (
    orderId             INT IDENTITY,
    orderDate           DATETIME,
    totalAmount         DECIMAL(10,2),
    shiptoAddress       VARCHAR(50),
    shiptoCity          VARCHAR(40),
    shiptoState         VARCHAR(20),
    shiptoPostalCode    VARCHAR(20),
    shiptoCountry       VARCHAR(40),
    customerId          INT,
    PRIMARY KEY (orderId),
    FOREIGN KEY (customerId) REFERENCES customer(customerid)
        ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE category (
    categoryId          INT IDENTITY,
    categoryName        VARCHAR(50),
    PRIMARY KEY (categoryId)
);

CREATE TABLE product (
    productId           INT IDENTITY,
    productName         VARCHAR(40),
    productPrice        DECIMAL(10,2),
    productImageURL     VARCHAR(100),
    productImage        VARBINARY(MAX),
    productDesc         VARCHAR(1000),
    categoryId          INT,
    PRIMARY KEY (productId),
    FOREIGN KEY (categoryId) REFERENCES category(categoryId)
);

CREATE TABLE orderproduct (
    orderId             INT,
    productId           INT,
    quantity            INT,
    price               DECIMAL(10,2),
    PRIMARY KEY (orderId, productId),
    FOREIGN KEY (orderId) REFERENCES ordersummary(orderId)
        ON UPDATE CASCADE ON DELETE NO ACTION,
    FOREIGN KEY (productId) REFERENCES product(productId)
        ON UPDATE CASCADE ON DELETE NO ACTION
);

CREATE TABLE incart (
    orderId             INT,
    productId           INT,
    quantity            INT,
    price               DECIMAL(10,2),
    PRIMARY KEY (orderId, productId),
    FOREIGN KEY (orderId) REFERENCES ordersummary(orderId)
        ON UPDATE CASCADE ON DELETE NO ACTION,
    FOREIGN KEY (productId) REFERENCES product(productId)
        ON UPDATE CASCADE ON DELETE NO ACTION
);

CREATE TABLE warehouse (
    warehouseId         INT IDENTITY,
    warehouseName       VARCHAR(30),
    PRIMARY KEY (warehouseId)
);

CREATE TABLE shipment (
    shipmentId          INT IDENTITY,
    shipmentDate        DATETIME,
    shipmentDesc        VARCHAR(100),
    warehouseId         INT,
    PRIMARY KEY (shipmentId),
    FOREIGN KEY (warehouseId) REFERENCES warehouse(warehouseId)
        ON UPDATE CASCADE ON DELETE NO ACTION
);

CREATE TABLE productinventory (
    productId           INT,
    warehouseId         INT,
    quantity            INT,
    price               DECIMAL(10,2),
    PRIMARY KEY (productId, warehouseId),
    FOREIGN KEY (productId) REFERENCES product(productId)
        ON UPDATE CASCADE ON DELETE NO ACTION,
    FOREIGN KEY (warehouseId) REFERENCES warehouse(warehouseId)
        ON UPDATE CASCADE ON DELETE NO ACTION
);

CREATE TABLE review (
    reviewId            INT IDENTITY,
    reviewRating        INT,
    reviewDate          DATETIME,
    customerId          INT,
    productId           INT,
    reviewComment       VARCHAR(1000),
    PRIMARY KEY (reviewId),
    FOREIGN KEY (customerId) REFERENCES customer(customerId)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (productId) REFERENCES product(productId)
        ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO category(categoryName) VALUES ('Bug'); --1
INSERT INTO category(categoryName) VALUES ('Dark'); --2
INSERT INTO category(categoryName) VALUES ('Dragon'); --3
INSERT INTO category(categoryName) VALUES ('Electric'); --4
INSERT INTO category(categoryName) VALUES ('Fairy'); --5
INSERT INTO category(categoryName) VALUES ('Fighting'); --6
INSERT INTO category(categoryName) VALUES ('Fire'); --7
INSERT INTO category(categoryName) VALUES ('Ghost'); --8
INSERT INTO category(categoryName) VALUES ('Grass'); --9
INSERT INTO category(categoryName) VALUES ('Ground'); --10
INSERT INTO category(categoryName) VALUES ('Ice'); --11
INSERT INTO category(categoryName) VALUES ('Normal'); -- 12
INSERT INTO category(categoryName) VALUES ('Poison'); --13
INSERT INTO category(categoryName) VALUES ('Psychic'); --14
INSERT INTO category(categoryName) VALUES ('Rock'); --15
INSERT INTO category(categoryName) VALUES ('Type-changed'); --16
INSERT INTO category(categoryName) VALUES ('Steel'); --17
INSERT INTO category(categoryName) VALUES ('Unknown'); --18
INSERT INTO category(categoryName) VALUES ('Water'); --19

INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Chaizard', 7, 'Chaizard is a draconic, bipedal Pokémon',18.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Mimikyu',8,'Mimikyu is a small Pokémon whose body is almost entirely hidden under a rag',19.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Ivysaur',9,'Ivysaur is a quadruped Pokémon that has blue-green skin with darker patches',10.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Lapras',19,'Lapras is a large sea Pokémon that resembles a plesiosaur',22.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Eevee',12,'Eevee is a mammalian, quadruped Pokémon with primarily brown fur',21.35);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Metapod',1,'Metapod is a Pokémon that resembles a green chrysalis',25.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Gastly',8,'Gastly has no true form, due to 95% of its body being poisonous gas',30.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Oddish',9,'Oddish is a Pokémon that resembles a blue plant bulb',40.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Mew',14,'Mew is a pink, bipedal Pokémon with mammalian features',97.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Mewtwo',14,'Mewtwo is a Pokémon created by science',31.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Snorlax',12,'Snorlax is a huge, bipedal, dark blue-green Pokémon with a cream-colored face, belly, and feet',21.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Drowzee',14,'Drowzee is a bipedal Pokémon that resembles a tapir',38.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Psyduck',19,'Psyduck is a yellow Pokémon resembling a duck or bipedal platypus',23.25);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Hitmonlee',6,'Hitmonlee is a humanoid Pokémon with an ovoid body',15.50);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Gyarados',19,'Gyarados is a serpentine Pokémon with a long body covered in slightly overlapping scales',17.45);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Beedrill',1,'Beedrill mostly resembles a bipedal, yellow wasp',39.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Articuno',11,'Articuno is a large avian Pokémon with predominantly blue plumage and wings said to be made of ice',62.50);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Butterfree',1,'Butterfree resembles a vaguely anthropomorphic butterfly with a purple body',9.20);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Abra',14,'Abra is a bipedal Pokémon that is primarily yellow',81.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Parasect',1,'Parasect is an orange, insectoid Pokémon that has been completely overtaken by the parasitic mushroom on its back',10.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Bellossom',9,'Bellossom is a primarily green Pokémon with circular blue eyes and red markings on its cheeks',21.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Hoothoot',12,'Hoothoot is an avian Pokémon that resembles an owl with a round body',14.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Electrike',4,'Electrike is a green, canine Pokémon with yellow markings',18.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Pikachu',4,'Pikachu is a short, chubby rodent Pokémon',19.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Pidgey',12,'Pidgey is a small, plump-bodied avian Pokémon',18.40);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Gothita',14,'Gothita is a small, humanoid Pokémon',9.65);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Drilbur',10,'Drilbur has a short, wide body with two small, ovoid feet with three toes each.',14.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Litwick',8,'Litwick is a small, candle-like Pokémon with a purple flame atop its head',21.05);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Zubat',13,'Zubat is a blue, bat-like Pokémon',14.00);

INSERT INTO customer (firstName, lastName, email, phonenum, address, city, state, postalCode, country, userid, password) VALUES ('Arnold', 'Anderson', 'a.anderson@gmail.com', '204-111-2222', '103 AnyWhere Street', 'Winnipeg', 'MB', 'R3X 45T', 'Canada', 'arnold' , 'test');
INSERT INTO customer (firstName, lastName, email, phonenum, address, city, state, postalCode, country, userid, password) VALUES ('Bobby', 'Brown', 'bobby.brown@hotmail.ca', '572-342-8911', '222 Bush Avenue', 'Boston', 'MA', '22222', 'United States', 'bobby' , 'bobby');
INSERT INTO customer (firstName, lastName, email, phonenum, address, city, state, postalCode, country, userid, password) VALUES ('Candace', 'Cole', 'cole@charity.org', '333-444-5555', '333 Central Crescent', 'Chicago', 'IL', '33333', 'United States', 'candace' , 'password');
INSERT INTO customer (firstName, lastName, email, phonenum, address, city, state, postalCode, country, userid, password) VALUES ('Darren', 'Doe', 'oe@doe.com', '250-807-2222', '444 Dover Lane', 'Kelowna', 'BC', 'V1V 2X9', 'Canada', 'darren' , 'pw');
INSERT INTO customer (firstName, lastName, email, phonenum, address, city, state, postalCode, country, userid, password) VALUES ('Elizabeth', 'Elliott', 'engel@uiowa.edu', '555-666-7777', '555 Everwood Street', 'Iowa City', 'IA', '52241', 'United States', 'beth' , 'test');


DECLARE @orderId int
INSERT INTO ordersummary (customerId, orderDate, totalAmount) VALUES (1, '2019-10-15 10:25:55', 91.70)
SELECT @orderId = @@IDENTITY
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 1, 1, 18)
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 5, 2, 21.35)
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 10, 1, 31);

DECLARE @orderId int
INSERT INTO ordersummary (customerId, orderDate, totalAmount) VALUES (2, '2019-10-16 18:00:00', 106.75)
SELECT @orderId = @@IDENTITY
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 5, 5, 21.35);

DECLARE @orderId int
INSERT INTO ordersummary (customerId, orderDate, totalAmount) VALUES (3, '2019-10-15 3:30:22', 140)
SELECT @orderId = @@IDENTITY
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 6, 2, 25)
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 7, 3, 30);

DECLARE @orderId int
INSERT INTO ordersummary (customerId, orderDate, totalAmount) VALUES (2, '2019-10-17 05:45:11', 327.85)
SELECT @orderId = @@IDENTITY
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 3, 4, 10)
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 8, 3, 40)
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 13, 3, 23.25)
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 28, 2, 21.05)
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 29, 4, 14);

DECLARE @orderId int
INSERT INTO ordersummary (customerId, orderDate, totalAmount) VALUES (5, '2019-10-15 10:25:55', 277.40)
SELECT @orderId = @@IDENTITY
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 5, 4, 21.35)
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 19, 2, 81)
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 20, 3, 10);
