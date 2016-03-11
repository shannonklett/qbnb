# ************************************************************
# Sequel Pro SQL dump
# Version 4529
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.42)
# Database: cisc332project
# Generation Time: 2016-03-09 15:51:20 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table booking_status_types
# ------------------------------------------------------------

DROP TABLE IF EXISTS `booking_status_types`;

CREATE TABLE `booking_status_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status_type_name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `booking_status_types` WRITE;
/*!40000 ALTER TABLE `booking_status_types` DISABLE KEYS */;

INSERT INTO `booking_status_types` (`id`, `status_type_name`)
VALUES
	(1,'requested'),
	(2,'confirmed'),
	(3,'rejected');

/*!40000 ALTER TABLE `booking_status_types` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table bookings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `bookings`;

CREATE TABLE `bookings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `consumer_id` int(11) unsigned NOT NULL,
  `property_id` int(11) unsigned NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status_id` int(2) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `consumer_id` (`consumer_id`),
  KEY `property_id` (`property_id`),
  KEY `status_id` (`status_id`),
  CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`consumer_id`) REFERENCES `users` (`id`),
  CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`property_id`) REFERENCES `rental_properties` (`id`),
  CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `booking_status_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Status:\n01 - requested\n02 - confirmed\n03 - rejected';

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;

INSERT INTO `bookings` (`id`, `consumer_id`, `property_id`, `start_date`, `end_date`, `status_id`)
VALUES
	(1,3,1,'2016-03-14','2016-03-21',1),
	(2,3,13,'2016-06-01','2016-06-08',1),
	(3,4,2,'2016-07-11','2016-07-18',2),
	(4,5,4,'2016-11-03','2016-11-10',2),
	(5,8,4,'2016-04-20','2016-04-13',3);

/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table city_districts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `city_districts`;

CREATE TABLE `city_districts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `district_name` varchar(255) NOT NULL DEFAULT '',
  `points_of_interest` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `city_districts` WRITE;
/*!40000 ALTER TABLE `city_districts` DISABLE KEYS */;

INSERT INTO `city_districts` (`id`, `district_name`, `points_of_interest`)
VALUES
	(1,'Bel-Air','The neighborhood, which lies across Sunset Boulevard from the University of California, Los Angeles, is the site of four private and two public pre-collegiate schools, as well as of the American Jewish University. Founded in 1923, the neighborhood has no multifamily dwellings and has been the filming location or setting for television shows.'),
	(2,'Santa Monica','Santa Monica is a beachfront city in western Los Angeles County, California, United States. The city is named after the Christian saint, Monica. Situated on Santa Monica Bay, it is bordered on three sides by the city of Los Angeles – Pacific Palisades to the north, Brentwood on the northeast, Sawtelle on the east, Mar Vista on the southeast, and Venice on the south. Santa Monica is well known for its affluent single-family neighborhoods but also has many neighborhoods consisting primarily of condominiums and apartments. Over two-thirds of Santa Monica\'s residents are renters. The Census Bureau population for Santa Monica in 2010 was 89,736.'),
	(3,'Beverly Crest','Beverly Crest is a neighborhood in the Santa Monica Mountains, in the Westside area of the city of Los Angeles, California. The \'north of Sunset\' section of the Holmby Hills neighborhood is within Beverly Crest.'),
	(4,'Westwood','Westwood is a commercial and residential neighborhood in the northern central portion of the Westside region of Los Angeles, California. It is the home of the University of California, Los Angeles (UCLA).'),
	(5,'Downtown','Downtown Los Angeles is the central business district of Los Angeles, California, as well as a diverse residential neighborhood of some 50,000 people. A 2013 study found that the district is home to over 500,000 jobs.'),
	(6,'West Hollywood','West Hollywood, colloquially referred to as WeHo, is a city in western Los Angeles County, California, United States. Incorporated in 1984, it is home to the Sunset Strip. As of the 2010 census, its population was 34,399. As of 2013, 39% of its residents were gay men.'),
	(7,'Little Tokyo','Little Tokyo, also known as Little Tokyo Historic District, is an ethnically Japanese American district in downtown Los Angeles and the heart of the largest Japanese-American population in North America. It is one of only three official Japantowns in the United States, all in California (the other two are in San Francisco and San Jose). Founded around the beginning of the 20th century, the area, sometimes called Lil\' Tokyo, J-Town, 小東京 (Shō-tōkyō), is the cultural center for Japanese Americans in Southern California. It was declared a National Historic Landmark District in 1995.'),
	(8,'Chinatown','Chinatown is a neighborhood in Downtown Los Angeles, California that became a commercial center for Chinese and other Asian businesses in Central Los Angeles in 1938. The area includes restaurants, shops and art galleries but also has a residential neighborhood with a low-income, aging population of about 10,000 residents.'),
	(9,'Mid-City','Mid-City is a highly diverse, very dense urban neighborhood in Central Los Angeles, California, with renters occupying most of the housing space but also with notable districts composed of historic single-family homes.'),
	(10,'Hollywood','Hollywood is a neighborhood in the central region of Los Angeles, California. The neighborhood is notable for its place as the home of the U.S. film industry, including several of its historic studios. Its name has come to be a metonym for the motion picture industry of the United States. Hollywood is also a highly ethnically diverse, densely populated, economically diverse neighborhood and retail business district.'),
	(11,'LAX','Los Angeles International Airport is the largest and busiest airport in the Greater Los Angeles Area and the state of California, and it is one of the most important international airports in the United States. It is most often referred to by its IATA airport code LAX, with the letters pronounced individually. LAX is located in the southwestern Los Angeles area along the Pacific Ocean between the neighborhood of Westchester to its immediate north and the city of El Segundo to its immediate south. It is owned and operated by Los Angeles World Airports, an agency of the Los Angeles city government formerly known as the Department of Airports.'),
	(12,'Century City','Century City is a 176-acre neighborhood in Los Angeles\' Westside. The neighborhood was developed on the former backlot of film studio 20th Century Fox, and its first building was opened in 1963. There are two private schools, but no public schools in the neighborhood. Important to the economy are a shopping center, business towers, and Fox Studios.'),
	(13,'Studio City','Studio City is a neighborhood in the city of Los Angeles, California, in the San Fernando Valley. It is named after the studio lot that was established in the area by film producer Mack Sennett in 1927, now known as CBS Studio Center.'),
	(14,'Brentwood','Brentwood is an affluent neighborhood in the Westside of Los Angeles, California. It is the home of seven private and two public schools. Originally part of a Mexican land grant, the neighborhood began its modern development in the 1880s and hosted part of the pentathlon in the 1932 Summer Olympics. It was the site of the 1994 O. J. Simpson murder case and of a disastrous fire in 1961.'),
	(15,'Silver Lake','Silver Lake is a residential and commercial neighborhood in the central and northeastern region of Los Angeles, California, built around what was then a city reservoir which gives the district its name. The \"Silver\" in Silver Lake is not because of the water\'s color, but named for the local engineer who built the reservoir. It is known for its restaurants and clubs, and many notable people have made their homes there. The neighborhood has three public and four private schools.'),
	(16,'Lincoln Heights','Lincoln Heights is considered to be the oldest neighborhood in Los Angeles, California, outside of Downtown. It is a densely populated, youthful area, with high percentages of Latino and Asian residents. It has nine public and four private schools and several historic or notable landmarks.'),
	(17,'Beverly Hills','Beverly Hills is a city in Los Angeles County, California, United States, surrounded by the cities of Los Angeles and West Hollywood. Originally a Spanish ranch where lima beans were grown, Beverly Hills was incorporated in 1914 by a group of investors who had failed to find oil, but found water instead and eventually decided to develop it into a town. By 2013, its population had grown to 34,658. Sometimes referred to as \"90210\", one of its primary ZIP codes, it is home to many actors and celebrities. The city includes the Rodeo Drive shopping district and the Beverly Hills Oil Field.'),
	(18,'El Sereno','El Sereno is the oldest community in Los Angeles, California. El Sereno\'s history dates back 10 years before the City of Los Angeles is established. El Sereno is also Los Angeles\' easternmost neighborhood.'),
	(19,'Pacific Palisades','Pacific Palisades is an affluent neighborhood and district in the Westside of the city of Los Angeles, California, located among Brentwood to the east, Malibu and Topanga to the west, Santa Monica to the southeast, the Santa Monica Bay to the southwest, and the Santa Monica Mountains to the north. The area currently has about 27,000 residents. It is primarily a residential area, with a mixture of large private homes, small (usually older) houses, condominiums, and apartments. Every Fourth of July, the community\'s Chamber of Commerce sponsors day-long events which include 5K and 10K runs, a parade down Sunset Boulevard, and a fireworks display at Palisades High School football field. The district also includes some large parklands and many hiking trails.'),
	(20,'Playa Vista','Playa Vista is a neighborhood located in the Westside of the City of Los Angeles, California, United States, north of LAX. The community has become a choice address for businesses in technology, media and entertainment and, along with Santa Monica and Venice, has become known as Silicon Beach. Prior to the development of Playa Vista, the area was the headquarters of Hughes Aircraft Company from 1941 to 1985, and was the site of the construction of the Hughes H-4 Hercules \"Spruce Goose\" aircraft. The area began development in 2002 as a planned community with residential, commercial, and retail components.');

/*!40000 ALTER TABLE `city_districts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table degree_types
# ------------------------------------------------------------

DROP TABLE IF EXISTS `degree_types`;

CREATE TABLE `degree_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `degree_type_name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `degree_types` WRITE;
/*!40000 ALTER TABLE `degree_types` DISABLE KEYS */;

INSERT INTO `degree_types` (`id`, `degree_type_name`)
VALUES
	(1,'BA'),
	(2,'BCMP'),
	(3,'BFA'),
	(4,'BMUS'),
	(5,'BPHE'),
	(6,'BSC'),
	(7,'BED'),
	(8,'BENG'),
	(9,'BCOMM'),
	(10,'MBA'),
	(11,'MD'),
	(12,'MA'),
	(13,'MES'),
	(14,'LLM'),
	(15,'PHD'),
	(16,'OTHER');

/*!40000 ALTER TABLE `degree_types` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table faculties
# ------------------------------------------------------------

DROP TABLE IF EXISTS `faculties`;

CREATE TABLE `faculties` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `faculty_name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `faculties` WRITE;
/*!40000 ALTER TABLE `faculties` DISABLE KEYS */;

INSERT INTO `faculties` (`id`, `faculty_name`)
VALUES
	(1,'Faculty of Arts and Science'),
	(2,'Faculty of Education'),
	(3,'Faculty of Engineering and Applied Science'),
	(4,'Faculty of Health Sciences'),
	(5,'Faculty of Law'),
	(6,'Smith School of Business'),
	(7,'School of Graduate Studies'),
	(8,'School of Policy Studies'),
	(9,'Other');

/*!40000 ALTER TABLE `faculties` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table rental_properties
# ------------------------------------------------------------

DROP TABLE IF EXISTS `rental_properties`;

CREATE TABLE `rental_properties` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `supplier_id` int(11) unsigned NOT NULL,
  `address` varchar(255) NOT NULL,
  `district_id` int(11) unsigned NOT NULL,
  `property_type_id` int(2) unsigned NOT NULL,
  `num_guests` int(10) unsigned NOT NULL DEFAULT '0',
  `num_rooms` int(10) unsigned NOT NULL DEFAULT '0',
  `num_bathrooms` int(10) unsigned NOT NULL,
  `price` int(5) NOT NULL,
  `description` text NOT NULL,
  `has_air_conditioning` tinyint(11) NOT NULL DEFAULT '0',
  `has_cable_tv` tinyint(11) NOT NULL DEFAULT '0',
  `has_laundry_machines` tinyint(11) NOT NULL DEFAULT '0',
  `has_parking` tinyint(11) NOT NULL DEFAULT '0',
  `has_gym` tinyint(11) NOT NULL DEFAULT '0',
  `has_internet` tinyint(11) NOT NULL DEFAULT '0',
  `pets_allowed` tinyint(11) NOT NULL DEFAULT '0',
  `has_wheelchair_access` tinyint(11) NOT NULL DEFAULT '0',
  `has_pool` tinyint(11) NOT NULL DEFAULT '0',
  `has_transport_access` tinyint(11) NOT NULL DEFAULT '0',
  `has_private_bathroom` tinyint(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `district_id` (`district_id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `property_type_id` (`property_type_id`),
  CONSTRAINT `rental_properties_ibfk_1` FOREIGN KEY (`district_id`) REFERENCES `city_districts` (`id`),
  CONSTRAINT `rental_properties_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `users` (`id`),
  CONSTRAINT `rental_properties_ibfk_3` FOREIGN KEY (`property_type_id`) REFERENCES `rental_property_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `rental_properties` WRITE;
/*!40000 ALTER TABLE `rental_properties` DISABLE KEYS */;

INSERT INTO `rental_properties` (`id`, `name`, `supplier_id`, `address`, `district_id`, `property_type_id`, `num_guests`, `num_rooms`, `num_bathrooms`, `price`, `description`, `has_air_conditioning`, `has_cable_tv`, `has_laundry_machines`, `has_parking`, `has_gym`, `has_internet`, `pets_allowed`, `has_wheelchair_access`, `has_pool`, `has_transport_access`, `has_private_bathroom`)
VALUES
	(1,'Signature Beverly Hills Studio',1,'707 N Beverly Dr, Beverly Hills, CA 90210, USA',17,1,2,1,1,109,'Located in exclusive Beverly Hills, just steps from Rodeo Dr, this beautiful studio puts you in the heart of the luxury capital of the world! Originally built as a hotel 1924, this historic property has hosted some of Hollywood\'s brightest stars.',1,1,1,0,0,0,1,0,1,0,1),
	(2,'DOWNTOWN LA CITY VIEW POOL STUDIO',15,'1133 S Olive St, Los Angeles, CA 90015, USA',5,1,4,1,1,183,'Los Angeles City views suite, located just above the financial district. High end decorated apartment at an affordable price! Incredible views, FREE WiFi, FREE parking, Pool, Gym. Walk to LA Live, Staples Center, Restaurants, and Bars.',1,0,0,1,0,1,0,1,0,1,0),
	(3,'STAY IN SILVER LAKE!',3,'1699 Rotary Dr, Los Angeles, CA 90026, USA',15,2,2,1,1,85,'Your private bedroom with a view. Be greeted by my 2 dogs and then enter into a skylight lit 2bdrm/ 1bth air conditioned cottage in the hippest neighborhood in the USA (according to Forbes Magazine).Go to some of our clubs and hear the latest in \"the Silver Lake Sound\", after all, it is the home of the Red Hot Chilli Peppers and Beck. Drive around our hood and see the Masters of 20th Century Architecture (Frank LLoyd Wright, Neutra and Shindler). Sit on the deck and chill out from all the excitement of Los Angeles.You can walk to the bus and subway. Plenty of parking on the street. Walk to all the wonderful, unique, and interesting shops of Silver Lake.The artsy, bohemian village center is an easy 10 minute stroll from the cottage. Take a stroll around the Silver Lake (yes, there is a REAL lake here!) and enjoy the cranes and other wildlife.While in Silver Lake, meet the \"creative community of Los Angeles! WELCOME!!',0,0,1,0,0,1,0,1,0,1,0),
	(4,'Private Room in Venice Beach',7,'1708 Linden Ave, Venice, CA 90291, USA',5,2,3,1,1,92,'See the ocean from the window of this private room. Stay in an ocean view Venice Beach penthouse, located on a walk street in Venice. Just steps away from the beach and Venice Boardwalk. Walk to Washington, Abbot Kinney and the Canals.',1,0,1,1,0,0,0,1,0,1,0),
	(5,'HOLLYWOOD HIGHLAND - MODERN 1 BED',18,'1315 N Kingsley Dr, Los Angeles, CA 90027, USA',10,1,3,1,1,140,'Walk to the Bowl, Walk of Fame, Kodak Theater. Enjoy this brand new luxury 1 BED flat equipped with full kitchen, new furniture, FREE parking, FREE WiFi, Fitness Room. Secure building and safe neighborhood.',0,0,0,0,0,1,0,1,0,1,0),
	(6,'Hollywood Holiday (Private Suite)',8,'446 N Hobart Blvd, Los Angeles, CA 90027, USA',10,1,2,1,2,170,'Welcome to the middle of Hollywood. Free parking space. Wifi, cable, hair dryer, soaps/shampoos, towels, sheets, iron/ironing board, and fully equipped kitchen all included.',1,0,1,0,1,1,1,1,0,1,0),
	(7,'Wonderful room in SM mountain view',12,'858 14th St, Santa Monica, CA 90403, USA',2,3,2,1,1,99,'Hi friends, we will be glad to open to you the doors of our house. It is a modern apartment complex with two swimming pools,hot tub,gym and free parking place in the garage. Santa Monica\'s pier is near as a promenade with all restaurants and shops.',0,1,0,1,0,0,1,0,1,1,1),
	(8,'Cozy living room by the beach',13,'932 17th St, Santa Monica, CA 90403, USA',2,3,2,1,1,99,'This is 1 bedroom apartment and you will be sharing the bathroom with me and my lovely kitten. The room has everything you need for short stay including wi-fi access,kitchen ,washing machine,toaster,outside area gas grill,gym,laundry and many cafes!',1,1,1,1,1,1,1,1,1,1,1),
	(9,'Nice, quite place in lovely house',10,'529 E Temple St, Los Angeles, CA 90012, USA',7,3,1,1,1,32,'This is clean and comfy bunk bed place in a house, close to USC',1,1,0,0,0,0,0,1,0,0,0),
	(10,'downtown loft',2,'179 N Los Angeles St, Los Angeles, CA 90012, USA',7,1,2,1,1,143,'beautifully located in the heart of the city',0,0,0,0,0,0,0,0,0,0,0),
	(11,'Guest Cottage Near the Sea!',10,'14919 La Cumbre Dr, Pacific Palisades, CA 90272, USA',19,1,2,1,1,156,'Our lovely, comfortable guest cottage is just blocks from the beach.Enjoy your own private garden view and patio. It comfortably sleeps two and is convenient to all of LA including Santa Monica, Venice Beach, Hollywood, LAX. Easy access to bus lines.',1,1,1,1,1,0,0,0,1,1,1),
	(12,'Hollywood Hills Lux A-List PoolView',5,'639 Westbourne Dr, West Hollywood, CA 90069, USA',6,1,12,5,6,2293,'Live Hollywood HISTORY! 5 bedroom Modern Masterpiece seen inTV/Films. BREATHTAKING VIEWS of Hollywood Sign, Ocean, City Lights &Canyons. Massive POOL & GYM. 3 min to Universal Studios, Hollywd Walk of Fame. 30 min to beach. Walk to Canyons. Private!',1,0,0,1,0,1,0,1,1,1,1),
	(13,'Guest Suite-Heart of West Hollywood',6,'8540 Melrose Ave, West Hollywood, CA 90069, USA',6,2,2,1,1,204,'Large guest suite w/queen size \"heavenly\" pillowtop bed, gorgeous private bathroom in beautiful 2 bedroom modern stylish house. \n32\" Flat screen tv w/Dish Network and Netflix. Fast Wifi. Driveway parking\nSteps from Sunset strip/Santa Monica Bl.',0,0,0,0,0,1,1,1,1,1,1),
	(14,'Private Room with Private Entrance',9,'13044 Discovery Creek, Los Angeles, CA 90094, USA',20,2,2,1,1,152,'We have a beautiful private room with a private full bathroom and a separate entrance. We are less than 10 min away from LAX and just over 1 mile away from the beach. We have an incredible location with restaurants and shops within walking distance.',1,1,1,1,0,0,0,1,0,0,0),
	(15,'Zen Paradise in Beverly Hills',4,'9749 Sunset Blvd, Beverly Hills, CA 90210, USA',17,1,2,1,2,270,'The feng shui energy is balanced with museum quality crystals. I guarantee you will feel better after visiting this sanctuary.',1,1,1,1,1,0,0,0,0,0,0);

/*!40000 ALTER TABLE `rental_properties` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table rental_property_types
# ------------------------------------------------------------

DROP TABLE IF EXISTS `rental_property_types`;

CREATE TABLE `rental_property_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `property_type_name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `rental_property_types` WRITE;
/*!40000 ALTER TABLE `rental_property_types` DISABLE KEYS */;

INSERT INTO `rental_property_types` (`id`, `property_type_name`)
VALUES
	(1,'Entire Apt/House'),
	(2,'Private Room'),
	(3,'Shared Room');

/*!40000 ALTER TABLE `rental_property_types` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table reviews
# ------------------------------------------------------------

DROP TABLE IF EXISTS `reviews`;

CREATE TABLE `reviews` (
  `consumer_id` int(11) unsigned NOT NULL,
  `property_id` int(11) unsigned NOT NULL,
  `rating` int(1) unsigned NOT NULL,
  `comment` text NOT NULL,
  `reply` text NOT NULL,
  PRIMARY KEY (`consumer_id`,`property_id`),
  KEY `property_id` (`property_id`),
  CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`consumer_id`) REFERENCES `users` (`id`),
  CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`property_id`) REFERENCES `rental_properties` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;

INSERT INTO `reviews` (`consumer_id`, `property_id`, `rating`, `comment`, `reply`)
VALUES
	(2,1,4,'What a lovely place. Truly a paradise! Would definitely love to come back when I visit LA again. And Lauren is such a wonderful host!','Thanks!'),
	(6,9,4,'Nice host at nice location. Quiet street for sleeping and parking. Room and house is clean!',''),
	(12,1,3,'Great place to stay advert welcoming hosts',''),
	(12,3,4,'Perfect location close to Sunset Blvd, absolutely ideal. The house was chic & clean & very accommodating. I\'ll definitely be staying with Ron next time I\'m in LA!','Glad you enjoyed your stay! Come back anytime.'),
	(19,14,5,'Easy to find in a quiet area that is also close to lots of things to see and do! Had a great time in the guest cottage.','');

/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(30) NOT NULL,
  `grad_year` int(4) NOT NULL,
  `faculty_id` int(2) unsigned NOT NULL,
  `degree_type_id` int(2) unsigned NOT NULL,
  `gender` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `faculty_id` (`faculty_id`),
  KEY `degree_type_id` (`degree_type_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`),
  CONSTRAINT `users_ibfk_2` FOREIGN KEY (`degree_type_id`) REFERENCES `degree_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Faculty Codes:\n01 - Faculty of Arts and Science\n02 - Faculty of Education\n03 - Faculty of Engineering and Applied Science\n04 - Faculty of Health Sciences\n05 - Faculty of Law\n06 - Smith School of Business\n07 - School of Graduate Studies\n09 - School of Policy Studies\n10 - Other\n\nDegree Codes:\n01 - BA\n02 - BCMP\n03 - BFA\n04 - BMUS\n05 - BPHE\n06 - BSC\n07 - BED\n08 - BENG\n09 - BCOMM\n10 - MBA\n11 - MD\n12 - MA\n13 - MES\n14 - MENG\n15 - LLM\n16 - PHD\n17 - OTHER';

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `is_admin`, `first_name`, `last_name`, `email`, `password`, `phone_number`, `grad_year`, `faculty_id`, `degree_type_id`, `gender`)
VALUES
	(1,0,'Steven','Henley','steven_soccer_4ever@hotmail.com','mjfJc9RS45bEPXYZT5kL','+1 905-952-3917',2010,1,1,'Male'),
	(2,1,'Jaclyn','Shultis','xx_crazy_bunny_xx@gmail.ca','3mpbFdUsqvckD4ajaWHM','+1 416-371-6339',2002,1,15,'Female'),
	(3,0,'Eva','Yarbrough','eva_yar_89@gmail.com','7f524eZAvaTd8KTUGhyD','+1 604-866-6140',1999,1,7,'Female'),
	(4,0,'David','Thompson','davidthompson@teleworm.us','GKYhtRytw3MhvjpxBREE','+1 450-659-4960',2003,1,6,'Male'),
	(5,0,'Gerald','Coppola','geraldy_95@live.ca','dRkLbtVmMCdyUASXdEta','+1 416-395-2649',2014,1,6,'Male'),
	(6,0,'Frank','Norman','frank_norman@norman.ca','S9tYDrnDhaDJxZjkkNU3','+1 604-992-7607',2007,1,4,'Male'),
	(7,0,'Jodi','Navarro','jodi_t@rogers.ca','NS5CWAnMRfV8gwwMHbGS','+1 604-433-1612',1990,1,10,'Female'),
	(8,0,'John','Parker','johnbparker@gmail.com','Z8jpvvEHGVVZMAD9DAcs','+1 416-472-3379',1997,1,12,'Male'),
	(9,0,'Terry','Foote','terryb_foote@hotmail.co.uk','a9mBxWSZ2P8FHfmn77Zc','+61 (02) 4063 5416',2002,1,2,'Male'),
	(10,0,'Minnie','Bookman','minnie_crazy_fish_summer_z83@hotmail.com','GfqhPJZfeteR2JHVQA9h','+1 626-532-5793',2002,1,15,'Female'),
	(11,0,'Jennifer','Reed','jenni_reedi@yahoo.ca','xsvNx2DhTuv8bXYEfWJL','+1 416-923-0174',1999,1,14,'Female'),
	(12,0,'Chow','Chu','chowchu@gmail.com','RCxErUyDKCQZaVVFtjqp','+1 518-967-0079',1986,1,1,'Female'),
	(13,0,'Ming','T\'an','mingtan@gmail.com','sJUZFGLhExju43U6MdUJ','+1 867-980-5765',1995,1,6,'Male'),
	(14,1,'Aladdin','Almasi','aladdinazimalmasi@hotmail.co.uk','6UbMdt7Wm5bKh9SkE5d7','+31 06-66816332',1992,1,16,'Male'),
	(15,0,'Théodore','Pouchard','theodore_pouchard@yahoo.com','KcnqUmVfrrCgfPfc97s6','+1 613-774-6733',2006,1,1,'Male'),
	(16,0,'Karen','Park','kpark@outlook.ca','h5rGr8gKxWnJ4sDA6k6z','+1 250-432-1517',2004,1,2,'Female'),
	(17,0,'Lima','Shcherbakova','shcherbakova@lima.ca','yWgDgU38hN7g57cCc97q','+1 604-930-3411',2001,1,9,'Female'),
	(18,0,'Doàn','Nhân','doannhan@hotmail.com','KUZXuCzuLz5PZQW7vs2z','+1 416-376-1754',2002,1,8,'Male'),
	(19,0,'Lilian','Nordström','liliannordstrom@gmail.com','28EENcwyQLuQASteH9ux','+1 416-649-7073',1988,1,1,'Female'),
	(20,0,'Alma','Moretti','alma_moretti@live.com','28EENcwyQLuQASteH9ux','+39 0370 4698148',1996,4,11,'Female'),
	(21,0,'Blake','Flores','blake_flores@live.ca','eVJxQYpbby37BVLP62Qq','+1 418-818-6321',2006,1,1,'Male'),
	(22,0,'Estelle','St-Jean','estellexoxo123@hotmail.ca','fsMUqmtMfNkERg3j7rrA','+1 250-365-4685',2003,1,15,'Female'),
	(23,0,'Charles','Short','shorty_dude_bro_43@gmail.com','YrQS3SckdtQsc47zMa8p','+1 705-766-3388',2000,1,6,'Male'),
	(24,0,'Alice','Whitehead','maple_leafs_lover_32@yahoo.ca','Pm49YNw3XQK2M6MXdqVm','+1 705-624-1911',1994,1,1,'Female'),
	(25,0,'Mark','Powell','markhpowell@bell.ca','ZzbSWUDzp42dAPGX993D','+1 306-230-0157',2001,1,1,'Male');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
