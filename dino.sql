CREATE TABLE  `dino` (
  `id` int AUTO_INCREMENT,
  `species` text,
  `info` text,
  `price` int,
  `image` text,
  `stock` int,
  PRIMARY KEY (`id`)
);
INSERT INTO `dino`
(`species`, `info`, `price`, `image`, `stock`)
VALUES
  ('T-Rex', 'Eats man and all other meats and lives in arid scrublands to well-vegetated, moist, sub-tropical woodlands. Enjoys chasing its prey.', '120', 'images/officialtrex.jpg', '234'),
  ('Pterodactyl', 'Can fly, likes to eat meats and fish, and lives in wetlands, marshes, and swamps', '150', 'images/pterodactyl.jpg', '156'),
  ('Allosaurus', 'Has very sharp teeth along with arms up to a foot long. Eats lots of meat, can run up to 40 MPH, and mostly lives in areas such as floodplains, conifer forests, savannas, and gallery forests of large ferns.', '140', 'images/allosaurus.jpg', '138'),
  ('Brontosaurus', 'A very large herbivore with a long, craning neck. Likes to eat leaves from the top of the tallest trees and live in swamps', '175', 'images/officialbrontosaurus.jpg', '113'),
  ('Stegosaurus', 'Large herbivore that has two rows of armored plates. Lives on land and is a herbivore.', '110', 'images/stego.jpg', '15'),
  ('Oculudentavis', 'Weird, primitive bird and is the smallest dinosaur as of now.', '65', 'images/weirdbird.jpg', '3537'),
  ('Apatosaurus', 'Extremely large herbivore, had an extra long neck. Lived near rivers to find water and food.', '175', 'images/apato.jpg', '160'),
  ('Triceratops', 'Only has 2 real horns, the third is closer to a nail. They usually live in dry, forrested areas and plains', '110', 'images/triceratop.jpg', '374'),
  ('Adamantisaurus', 'Long necked herbivore that was very long in length, inhabited South America.', '125', 'images/adamantisaurus.jpg', '256'),
  ('Aeolosaurus', 'Large, spiny herbivore that lived in the woodlands of Africa that layed eggs and lived in a terrestrial environment.', '140', 'images/aeolosaurus.jpg', '120');

CREATE TABLE  `accessory` (
  `id` int AUTO_INCREMENT,
  `name` text,
  `price` int,
  `image` text,
  `stock` int,
  PRIMARY KEY (`id`)
);
INSERT INTO `accessory` (`name`, `price`, `image`, `stock`) VALUES
  ('Extended Claws', '30', 'images/claws.jpg', '45'),
  ('Armor', '50', 'images/armor.jpg', '25'),
  ('Saddle', '35', 'images/saddle.jpg', '5'),
  ('Giant leash', '20', 'images/leash.jpg', '26'),
  ('Herbivore mix', '40', 'images/herbivore.jpg', '120'),
  ('Carnivore mix', '40', 'images/carnivore.jpg', '120'),
  ('Dino Nail Clipper', '50', 'images/clipper.jpg', '60'),
  ('Dino Jacket', '150', 'images/jacket.jpg', '70'),
  ('Giant Toothbrush', '200', 'images/brush.jpg', '10'),
  ('Dino Soap', '20', 'images/soap.jpg', '200');

CREATE TABLE  `user` (
  `id` int AUTO_INCREMENT,
  `name` text,
  `password` text,
  `address` text,
  `email` text,
  PRIMARY KEY (`id`)
);
INSERT INTO `user` (`name`, `password`, `address`, `email`) VALUES
  ('Admin', 'iamadmin', 'Admin', 'admin@email.com');

CREATE TABLE  `cart` (
  `id` int AUTO_INCREMENT,
  `user_id` int,
  `dino_id` int,
  `accessory_id` int,
  `purchase_id` int,
  PRIMARY KEY (`id`)
);

CREATE TABLE  `purchase` (
  `id` int AUTO_INCREMENT,
  `complete` text,
  `user_id` int,
  PRIMARY KEY (`id`)
);
