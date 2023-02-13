CREATE EXTENSION POSTGIS;

CREATE TABLE users
(
    id INTEGER,
    username CHAR(255),
    password CHAR(255),
    fullname CHAR(255)
);

INSERT INTO "users" ("id", "username", "password", "fullname") VALUES
(0,	'superadmin',	'superadmin',	'Superadmin'),
(1,	'user_1',	'user_1',	'user_1');