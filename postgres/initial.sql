CREATE EXTENSION POSTGIS;

CREATE TABLE users
(
    id INTEGER,
    username CHAR(255),
    password CHAR(255),
    fullname CHAR(255),
    role CHAR(255)
);

INSERT INTO "users" ("id", "username", "password", "fullname", "role") VALUES
(0,	'superadmin',	'superadmin',	'Superadmin', 'admin'),
(1,	'user_1',	'user_1',	'user_1', 'guest');

CREATE TABLE iframe_layers
(
    id INTEGER NOT NULL DEFAULT nextval('iframe_layers_id_seq'),
    iframe_url CHAR(255),
    name_iframe CHAR(255)
);