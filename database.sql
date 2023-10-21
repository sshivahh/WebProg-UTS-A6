CREATE DATABASE database_webprog_lec;

USE database_webprog_lec;

create table users(
    id int auto_increment PRIMARY KEY,
    fullname varchar(50) not null,
    email varchar(25)  not null ,
    password varchar(25) not null
);

CREATE TABLE menu(
    id int PRIMARY KEY,
    nama varchar(50),
    gambar varchar(255),
    harga int,
    kategori varchar(25)
    deskripsi varchar(255)
);

CREATE TABLE cart(
    id_user int,
    id_menu int,
    jumlah int,
    PRIMARY KEY (id_user, id_menu),
    FOREIGN KEY (id_user) REFERENCES users(id),
    FOREIGN KEY (id_menu) REFERENCES menu(id)
);
