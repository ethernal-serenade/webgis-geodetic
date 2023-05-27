CREATE EXTENSION POSTGIS;

CREATE TABLE users
(
    id INTEGER,
    username VARCHAR,
    password VARCHAR,
    fullname VARCHAR,
    role VARCHAR
);

INSERT INTO "users" ("id", "username", "password", "fullname", "role") VALUES
(1,	'superadmin',	'superadmin',	'Superadmin',	'admin'),
(2,	'user1',	'abc',	'abc',	'registered');

CREATE TABLE iframe_layers
(
    id SERIAL,
    iframe_url VARCHAR,
    name_iframe VARCHAR
);
