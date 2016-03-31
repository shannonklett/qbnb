-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2016 at 09:30 AM
-- Server version: 10.1.8-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cisc332project`
--
CREATE DATABASE IF NOT EXISTS `cisc332project` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `cisc332project`;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) UNSIGNED NOT NULL,
  `consumer_id` int(11) UNSIGNED NOT NULL,
  `property_id` int(11) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status_id` int(2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Status:\n01 - requested\n02 - confirmed\n03 - rejected';

--
-- RELATIONS FOR TABLE `bookings`:
--   `consumer_id`
--       `users` -> `id`
--   `property_id`
--       `rental_properties` -> `id`
--   `status_id`
--       `booking_status_types` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking_status_types`
--

CREATE TABLE `booking_status_types` (
  `id` int(11) UNSIGNED NOT NULL,
  `status_type_name` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `booking_status_types`:
--

--
-- Dumping data for table `booking_status_types`
--

INSERT INTO `booking_status_types` (`id`, `status_type_name`) VALUES
(1, 'requested'),
(2, 'confirmed'),
(3, 'rejected');

-- --------------------------------------------------------

--
-- Table structure for table `city_districts`
--

CREATE TABLE `city_districts` (
  `id` int(11) UNSIGNED NOT NULL,
  `district_name` varchar(255) NOT NULL DEFAULT '',
  `points_of_interest` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `city_districts`:
--

--
-- Dumping data for table `city_districts`
--

INSERT INTO `city_districts` (`id`, `district_name`, `points_of_interest`) VALUES
(1, 'Bel-Air', 'The neighborhood, which lies across Sunset Boulevard from the University of California, Los Angeles, is the site of four private and two public pre-collegiate schools, as well as of the American Jewish University. Founded in 1923, the neighborhood has no multifamily dwellings and has been the filming location or setting for television shows.'),
(2, 'Santa Monica', 'Santa Monica is a beachfront city in western Los Angeles County, California, United States. The city is named after the Christian saint, Monica. Situated on Santa Monica Bay, it is bordered on three sides by the city of Los Angeles – Pacific Palisades to the north, Brentwood on the northeast, Sawtelle on the east, Mar Vista on the southeast, and Venice on the south. Santa Monica is well known for its affluent single-family neighborhoods but also has many neighborhoods consisting primarily of condominiums and apartments. Over two-thirds of Santa Monica''s residents are renters. The Census Bureau population for Santa Monica in 2010 was 89,736.'),
(3, 'Beverly Crest', 'Beverly Crest is a neighborhood in the Santa Monica Mountains, in the Westside area of the city of Los Angeles, California. The ''north of Sunset'' section of the Holmby Hills neighborhood is within Beverly Crest.'),
(4, 'Westwood', 'Westwood is a commercial and residential neighborhood in the northern central portion of the Westside region of Los Angeles, California. It is the home of the University of California, Los Angeles (UCLA).'),
(5, 'Downtown', 'Downtown Los Angeles is the central business district of Los Angeles, California, as well as a diverse residential neighborhood of some 50,000 people. A 2013 study found that the district is home to over 500,000 jobs.'),
(6, 'West Hollywood', 'West Hollywood, colloquially referred to as WeHo, is a city in western Los Angeles County, California, United States. Incorporated in 1984, it is home to the Sunset Strip. As of the 2010 census, its population was 34,399. As of 2013, 39% of its residents were gay men.'),
(7, 'Little Tokyo', 'Little Tokyo, also known as Little Tokyo Historic District, is an ethnically Japanese American district in downtown Los Angeles and the heart of the largest Japanese-American population in North America. It is one of only three official Japantowns in the United States, all in California (the other two are in San Francisco and San Jose). Founded around the beginning of the 20th century, the area, sometimes called Lil'' Tokyo, J-Town, 小東京 (Shō-tōkyō), is the cultural center for Japanese Americans in Southern California. It was declared a National Historic Landmark District in 1995.'),
(8, 'Chinatown', 'Chinatown is a neighborhood in Downtown Los Angeles, California that became a commercial center for Chinese and other Asian businesses in Central Los Angeles in 1938. The area includes restaurants, shops and art galleries but also has a residential neighborhood with a low-income, aging population of about 10,000 residents.'),
(9, 'Mid-City', 'Mid-City is a highly diverse, very dense urban neighborhood in Central Los Angeles, California, with renters occupying most of the housing space but also with notable districts composed of historic single-family homes.'),
(10, 'Hollywood', 'Hollywood is a neighborhood in the central region of Los Angeles, California. The neighborhood is notable for its place as the home of the U.S. film industry, including several of its historic studios. Its name has come to be a metonym for the motion picture industry of the United States. Hollywood is also a highly ethnically diverse, densely populated, economically diverse neighborhood and retail business district.'),
(11, 'LAX', 'Los Angeles International Airport is the largest and busiest airport in the Greater Los Angeles Area and the state of California, and it is one of the most important international airports in the United States. It is most often referred to by its IATA airport code LAX, with the letters pronounced individually. LAX is located in the southwestern Los Angeles area along the Pacific Ocean between the neighborhood of Westchester to its immediate north and the city of El Segundo to its immediate south. It is owned and operated by Los Angeles World Airports, an agency of the Los Angeles city government formerly known as the Department of Airports.'),
(12, 'Century City', 'Century City is a 176-acre neighborhood in Los Angeles'' Westside. The neighborhood was developed on the former backlot of film studio 20th Century Fox, and its first building was opened in 1963. There are two private schools, but no public schools in the neighborhood. Important to the economy are a shopping center, business towers, and Fox Studios.'),
(13, 'Studio City', 'Studio City is a neighborhood in the city of Los Angeles, California, in the San Fernando Valley. It is named after the studio lot that was established in the area by film producer Mack Sennett in 1927, now known as CBS Studio Center.'),
(14, 'Brentwood', 'Brentwood is an affluent neighborhood in the Westside of Los Angeles, California. It is the home of seven private and two public schools. Originally part of a Mexican land grant, the neighborhood began its modern development in the 1880s and hosted part of the pentathlon in the 1932 Summer Olympics. It was the site of the 1994 O. J. Simpson murder case and of a disastrous fire in 1961.'),
(15, 'Silver Lake', 'Silver Lake is a residential and commercial neighborhood in the central and northeastern region of Los Angeles, California, built around what was then a city reservoir which gives the district its name. The "Silver" in Silver Lake is not because of the water''s color, but named for the local engineer who built the reservoir. It is known for its restaurants and clubs, and many notable people have made their homes there. The neighborhood has three public and four private schools.'),
(16, 'Lincoln Heights', 'Lincoln Heights is considered to be the oldest neighborhood in Los Angeles, California, outside of Downtown. It is a densely populated, youthful area, with high percentages of Latino and Asian residents. It has nine public and four private schools and several historic or notable landmarks.'),
(17, 'Beverly Hills', 'Beverly Hills is a city in Los Angeles County, California, United States, surrounded by the cities of Los Angeles and West Hollywood. Originally a Spanish ranch where lima beans were grown, Beverly Hills was incorporated in 1914 by a group of investors who had failed to find oil, but found water instead and eventually decided to develop it into a town. By 2013, its population had grown to 34,658. Sometimes referred to as "90210", one of its primary ZIP codes, it is home to many actors and celebrities. The city includes the Rodeo Drive shopping district and the Beverly Hills Oil Field.'),
(18, 'El Sereno', 'El Sereno is the oldest community in Los Angeles, California. El Sereno''s history dates back 10 years before the City of Los Angeles is established. El Sereno is also Los Angeles'' easternmost neighborhood.'),
(19, 'Pacific Palisades', 'Pacific Palisades is an affluent neighborhood and district in the Westside of the city of Los Angeles, California, located among Brentwood to the east, Malibu and Topanga to the west, Santa Monica to the southeast, the Santa Monica Bay to the southwest, and the Santa Monica Mountains to the north. The area currently has about 27,000 residents. It is primarily a residential area, with a mixture of large private homes, small (usually older) houses, condominiums, and apartments. Every Fourth of July, the community''s Chamber of Commerce sponsors day-long events which include 5K and 10K runs, a parade down Sunset Boulevard, and a fireworks display at Palisades High School football field. The district also includes some large parklands and many hiking trails.'),
(20, 'Playa Vista', 'Playa Vista is a neighborhood located in the Westside of the City of Los Angeles, California, United States, north of LAX. The community has become a choice address for businesses in technology, media and entertainment and, along with Santa Monica and Venice, has become known as Silicon Beach. Prior to the development of Playa Vista, the area was the headquarters of Hughes Aircraft Company from 1941 to 1985, and was the site of the construction of the Hughes H-4 Hercules "Spruce Goose" aircraft. The area began development in 2002 as a planned community with residential, commercial, and retail components.');

-- --------------------------------------------------------

--
-- Table structure for table `degree_types`
--

CREATE TABLE `degree_types` (
  `id` int(11) UNSIGNED NOT NULL,
  `degree_type_name` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `degree_types`:
--

--
-- Dumping data for table `degree_types`
--

INSERT INTO `degree_types` (`id`, `degree_type_name`) VALUES
(1, 'BA'),
(2, 'BCMP'),
(3, 'BFA'),
(4, 'BMUS'),
(5, 'BPHE'),
(6, 'BSC'),
(7, 'BED'),
(8, 'BENG'),
(9, 'BCOMM'),
(10, 'MBA'),
(11, 'MD'),
(12, 'MA'),
(13, 'MES'),
(14, 'LLM'),
(15, 'PHD'),
(16, 'OTHER');

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE `faculties` (
  `id` int(11) UNSIGNED NOT NULL,
  `faculty_name` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `faculties`:
--

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`id`, `faculty_name`) VALUES
(1, 'Faculty of Arts and Science'),
(2, 'Faculty of Education'),
(3, 'Faculty of Engineering and Applied Science'),
(4, 'Faculty of Health Sciences'),
(5, 'Faculty of Law'),
(6, 'Smith School of Business'),
(7, 'School of Graduate Studies'),
(8, 'School of Policy Studies'),
(9, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `rental_properties`
--

CREATE TABLE `rental_properties` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `supplier_id` int(11) UNSIGNED NOT NULL,
  `address` varchar(255) NOT NULL,
  `district_id` int(11) UNSIGNED NOT NULL,
  `property_type_id` int(2) UNSIGNED NOT NULL,
  `num_guests` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `num_rooms` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `num_bathrooms` int(10) UNSIGNED NOT NULL,
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
  `has_private_bathroom` tinyint(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `rental_properties`:
--   `district_id`
--       `city_districts` -> `id`
--   `supplier_id`
--       `users` -> `id`
--   `property_type_id`
--       `rental_property_types` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `rental_property_types`
--

CREATE TABLE `rental_property_types` (
  `id` int(11) UNSIGNED NOT NULL,
  `property_type_name` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `rental_property_types`:
--

--
-- Dumping data for table `rental_property_types`
--

INSERT INTO `rental_property_types` (`id`, `property_type_name`) VALUES
(1, 'Entire Apt/House'),
(2, 'Private Room'),
(3, 'Shared Room');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `consumer_id` int(11) UNSIGNED NOT NULL,
  `property_id` int(11) UNSIGNED NOT NULL,
  `rating` int(1) UNSIGNED NOT NULL,
  `comment` text NOT NULL,
  `reply` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `reviews`:
--   `consumer_id`
--       `users` -> `id`
--   `property_id`
--       `rental_properties` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(30) NOT NULL,
  `grad_year` int(4) NOT NULL,
  `faculty_id` int(2) UNSIGNED NOT NULL,
  `degree_type_id` int(2) UNSIGNED NOT NULL,
  `gender` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Faculty Codes:\n01 - Faculty of Arts and Science\n02 - Faculty of Education\n03 - Faculty of Engineering and Applied Science\n04 - Faculty of Health Sciences\n05 - Faculty of Law\n06 - Smith School of Business\n07 - School of Graduate Studies\n09 - School of Policy Studies\n10 - Other\n\nDegree Codes:\n01 - BA\n02 - BCMP\n03 - BFA\n04 - BMUS\n05 - BPHE\n06 - BSC\n07 - BED\n08 - BENG\n09 - BCOMM\n10 - MBA\n11 - MD\n12 - MA\n13 - MES\n14 - MENG\n15 - LLM\n16 - PHD\n17 - OTHER';

--
-- RELATIONS FOR TABLE `users`:
--   `faculty_id`
--       `faculties` -> `id`
--   `degree_type_id`
--       `degree_types` -> `id`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consumer_id` (`consumer_id`),
  ADD KEY `property_id` (`property_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `booking_status_types`
--
ALTER TABLE `booking_status_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city_districts`
--
ALTER TABLE `city_districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `degree_types`
--
ALTER TABLE `degree_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rental_properties`
--
ALTER TABLE `rental_properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `district_id` (`district_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `property_type_id` (`property_type_id`);

--
-- Indexes for table `rental_property_types`
--
ALTER TABLE `rental_property_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`consumer_id`,`property_id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id` (`faculty_id`),
  ADD KEY `degree_type_id` (`degree_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `booking_status_types`
--
ALTER TABLE `booking_status_types`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `city_districts`
--
ALTER TABLE `city_districts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `degree_types`
--
ALTER TABLE `degree_types`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `faculties`
--
ALTER TABLE `faculties`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `rental_properties`
--
ALTER TABLE `rental_properties`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `rental_property_types`
--
ALTER TABLE `rental_property_types`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`consumer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`property_id`) REFERENCES `rental_properties` (`id`),
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `booking_status_types` (`id`);

--
-- Constraints for table `rental_properties`
--
ALTER TABLE `rental_properties`
  ADD CONSTRAINT `rental_properties_ibfk_1` FOREIGN KEY (`district_id`) REFERENCES `city_districts` (`id`),
  ADD CONSTRAINT `rental_properties_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `rental_properties_ibfk_3` FOREIGN KEY (`property_type_id`) REFERENCES `rental_property_types` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`consumer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`property_id`) REFERENCES `rental_properties` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`degree_type_id`) REFERENCES `degree_types` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
