CREATE DATABASE IF NOT EXISTS api;
USE apilaravel;

CREATE TABLE users(
id 		int(255) auto_increment not null,
email varchar(255),
pais	varchar(20),
name	varchar(255),
dni	varchar(255),
password varchar(255),
edad varchar(100),
genero varchar(100),
intereses varchar(100),
remember_token varchar(255),
created_at datetime DEFAULT NULL,
updated_at datetime DEFAULT NULL,
CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE egresados(
id 		int(255) auto_increment not null,
name	varchar(255),
pais varchar(255),
dni	varchar(100),
email  varchar(100),
password varchar(255),
intereses varchar(255),
edad varchar(255),
genero varchar(255),
created_at datetime DEFAULT NULL,
updated_at datetime DEFAULT NULL,
CONSTRAINT pk_cars PRIMARY KEY(id),
)ENGINE=InnoDb;CREATE DATABASE IF NOT EXISTS api;
USE api;

CREATE TABLE administrador(
dni 		int(255) not null,
nombre varchar(255),
direccion	varchar(20),
telefono	varchar(255),
ciudad	varchar(255),
email	varchar(255),
password varchar(255) DEFAULT '1234',
remember_token varchar(255),
CONSTRAINT pk_administrador PRIMARY KEY(dni)
)ENGINE=InnoDb;

