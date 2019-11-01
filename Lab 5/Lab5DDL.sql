create table Customer (
	id int not null auto_increment,
	first_name varchar(25),
	last_name varchar(35),
	email varchar(50),
	phone varchar(15),
	address varchar(30),
	city varchar(30),
	provice_state varchar(30),
	postal_code varchar(6),
	country varchar(20),
	user_id varchar(25),
	password varchar(30),
	primary key (id)
);

create table PaymentMethod(
	id int not null auto_increment,
	method varchar(),
	num int,
	expiratory_date datetime,
	primary key (id)
);

create table CustomerPaymentMethod(
	customer_id int,
	payment_method_id int,
	primary key(customer_id, payment_method_id)
);

create table OrderSummary(
	id int not null auto_increment,
	customer_id int,
	order_date datetime,
	total_order_amount decimal(10, 2), 
	shipment_address varchar(40),
	city varchar(30),
	provice_state varchar(30),
	postal_code varchar(6),
	country varchar(20),
	primary key (id),
	foreign key (customer_id) references Customer(id)
);

create table Category(
	id int not null auto_increment,
	name varchar(30),
	primary key (id)
);

create table Product(
	id int not null auto_increment,
	category_id int,
	name varchar(30),
	price decimal(10, 2),
	image_url varchar(100),
	image BLOB,
	description CLOB,
	primary key (id),
	foreign key (category_id) references Category(id)

);

create table ProductOrder(
	product_id int not null,
	order_id int not null,
	quantity int,
	primary key (product_id, order_id),
	foreign key (product_id) references Product (id),
	foreign key (order_id) references Order (id)
);

create table Shipment(
	id int not null auto_increment,
	warehouse_id int,
	order_id int,
	shipment_date datetime,
	description CLOB,
	primary key(id),
	foreign key (warehouse_id) references Warehouse(id),
	foreign key (order_id) references Order(id)
);

create table Warehouse (
	id int not null auto_increment,
	name varchar(40)
);

CREATE TABLE Inventory(
	warehouse_id int not null,
	product_id int not null,
	quantity int,
	primary key (warehouse_id, product_id),
	foreign key (warehouse_id) references Warehouse (id),
	foreign key (product_id) references Product(id)
);

create table ShoppingCart(
	customer_id int not null,
	product_id int not null,
	quantity int, 
	price decimal(10, 2),
	primary key (product_id, customer_id),
	foreign key (customer_id) references Customer(id),
	foreign key (product_id) references Product(id)	
);

create table Review(
	id int not null auto_increment,
	customer_id int not null,
	product_id int not null,
	rating decimal(1,1),
	comment varchar(128),
	review_date datetime,
	primary key (id),
	foreign key (customer_id) references Customer(id),
	foreign key (product_id) references Product(id)
);
