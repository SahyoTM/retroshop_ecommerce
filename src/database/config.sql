/* create table for categories */
CREATE TABLE IF NOT EXISTS categories (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name varchar(255) NOT NULL
);

/* create table for products with categories */
CREATE TABLE IF NOT EXISTS products (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name varchar(255) NOT NULL,
  description text NOT NULL,
  price float NOT NULL,
  img_url varchar(255) NOT NULL,
  category_id int(11) NOT NULL,
  FOREIGN KEY (category_id) REFERENCES categories(id)
);

/* create table for users with roles and token session */
CREATE TABLE IF NOT EXISTS users (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  username varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  role varchar(255) NOT NULL DEFAULT 'client',
  token varchar(255)
);

/*create table for orders with users*/
CREATE TABLE IF NOT EXISTS orders (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  user_id int(11) NOT NULL,
  product_id int(11) NOT NULL,
  quantity int(11) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (product_id) REFERENCES products(id)
);

/*INSERT INTO categories (name) VALUES ('Simulation');
INSERT INTO categories (name) VALUES ('RPG');
INSERT INTO categories (name) VALUES ('FPS');
INSERT INTO categories (name) VALUES ('MMORPG');
INSERT INTO categories (name) VALUES ('Sport');
INSERT INTO categories (name) VALUES ('Other');

INSERT INTO products (name, description, price, img_url, category_id) VALUES ('Minecraft', 'Minecraft is a sandbox video game created by Swedish game designer Markus Persson and later developed by Mojang.', 59.99, 'https://picsum.photos/seed/picsum/200/300', 1);
INSERT INTO products (name, description, price, img_url, category_id) VALUES ('Terraria', 'Terraria is a free-to-play, open source, 2D sandbox game created by CoderBot and published by Re-Logic.', 59.99, 'https://picsum.photos/seed/picsum/200/300', 1);
INSERT INTO products (name, description, price, img_url, category_id) VALUES ('League of Legends', 'League of Legends is a multiplayer online battle arena video game developed and published by Riot Games.', 59.99, 'https://picsum.photos/seed/picsum/200/300', 6);
INSERT INTO products (name, description, price, img_url, category_id) VALUES ('Starcraft', 'StarCraft is a free-to-play online video game developed and published by Blizzard Entertainment.', 59.99, 'https://picsum.photos/seed/picsum/200/300', 6);
INSERT INTO products (name, description, price, img_url, category_id) VALUES ('Counter Strike: Global Offensive', 'Counter Strike: Global Offensive is a first-person shooter video game developed by Hidden Path Entertainment and Valve Corporation. It is the eighth main installment in the Counter-Strike series, and was released for Microsoft Windows, PlayStation 4, and Xbox One on October 25, 2012, and for macOS and Linux on November 2, 2012.', 59.99, 'https://picsum.photos/seed/picsum/200/300', 3);
INSERT INTO products (name, description, price, img_url, category_id) VALUES ('The Witcher 3: Wild Hunt', 'The Witcher 3: Wild Hunt is a 2015 action role-playing video game developed by CD Projekt RED and published by CD Projekt RED. It is the third installment in The Witcher series, and the sequel to The Witcher: Wild Hunt. The game was released worldwide on August 29, 2015, for Microsoft Windows, PlayStation 4, and Xbox One.', 59.99, 'https://picsum.photos/seed/picsum/200/300', 2);
INSERT INTO products (name, description, price, img_url, category_id) VALUES ('Call of Duty: Modern Warfare', 'Call of Duty: Modern Warfare is a first-person shooter video game developed by Infinity Ward and published by Activision. It was released for Microsoft Windows, PlayStation 3, and Xbox 360 in March 2010, and for Microsoft Windows, PlayStation 4, and Xbox One in November 2013.', 59.99, 'https://picsum.photos/seed/picsum/200/300', 3);*/