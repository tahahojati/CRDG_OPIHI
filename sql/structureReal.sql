--
-- Table structure for table transect_data
--

  drop table  if exists quadrant_data ;
  drop table  if exists transect_data;
  drop table  if exists location_substrate;
  drop table  if exists session_metadata;
--  drop table  if exists teacher_assistant ;
  drop table  if exists substrate;
  drop table  if exists user;
  drop table  if exists school;
  drop table  if exists stress;
  drop table  if exists organism;
  drop table  if exists location;
  drop table if exists random_id; 


--
-- Table structure for table school
--

CREATE TABLE school (
  id int unsigned NOT NULL AUTO_INCREMENT,
  school_name varchar(50) NOT NULL,
  phone varchar(15),
  address varchar(100) NOT NULL,
  island ENUM('Oahu', 'Hawaii', 'Maui', 'Kauai', 'Molokai', 'Lanai') NOT NULL DEFAULT 'Oahu',
  city varchar(25) NOT NULL,
  state varchar(25) NOT NULL DEFAULT 'HI',
  zip int unsigned NOT NULL,
  country varchar(25) NOT NULL DEFAULT 'USA',
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
--
-- Table structure for table user
--

CREATE TABLE user (
  id int unsigned NOT NULL AUTO_INCREMENT,
  first_name varchar(25) NOT NULL,
  last_name varchar(25) NOT NULL,
 -- school_id int unsigned,
  school_name varchar(50) DEFAULT NULL ,
  school_address varchar(200) DEFAULT NULL ,
  island VARCHAR(15) NOT NULL DEFAULT 'Oahu',
  email varchar(255) NOT NULL,
  salt varchar (32) NOT NULL, 
  role varchar (10) NOT NULL DEFAULT 'teacher', 
  password varchar (40) NOT NULL,
  PRIMARY KEY (id)
 -- FOREIGN KEY (school_id) REFERENCES school (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table location
--

CREATE TABLE location (
  id int unsigned NOT NULL AUTO_INCREMENT,
  location_name varchar(50) NOT NULL,
  island ENUM('Oahu', 'Hawaii', 'Maui', 'Kauai', 'Molokai', 'Lanai') NOT NULL DEFAULT 'Oahu',
  latitude float(10,6) NOT NULL,
  longitude float(10,6) NOT NULL,
  sand_in_grooves boolean NOT NULL,
  sand_above boolean NOT NULL,
  sand_side boolean NOT NULL,
  freshwater_input boolean NOT NULL,
  freshwater_comment varchar(25) DEFAULT NULL,
  photo tinyblob DEFAULT NULL, 
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table organism
--

CREATE TABLE organism (
  id int unsigned NOT NULL AUTO_INCREMENT ,
  category enum('Algae','Invertebrates') NOT NULL,
  genus varchar(20) NOT NULL,
  species varchar(20) NOT NULL,
  photo tinyblob NOT NULL,
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table stress
--

CREATE TABLE stress (
  id int unsigned NOT NULL AUTO_INCREMENT,
  stress_name varchar(25) NOT NULL,
  photo tinyblob NOT NULL,
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table substrate
--

CREATE TABLE substrate (
  id int unsigned NOT NULL AUTO_INCREMENT,
  substrate_name varchar(25) NOT NULL,
  photo tinyblob,
  PRIMARY KEY(id)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table location_substrate
--

-- CREATE TABLE location_substrate (
--   location_id int unsigned NOT NULL,
--   substrate_id int unsigned NOT NULL,
--   substrate_size int unsigned NOT NULL,
--   FOREIGN KEY (location_id) REFERENCES location (id),
--   FOREIGN KEY (substrate_id) REFERENCES substrate (id)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;




--
-- Table structure for table session_metadata
--

CREATE TABLE session_metadata (
  id int unsigned NOT NULL,
  location_id int unsigned NOT NULL,
  user_id int unsigned NOT NULL,
  date date NOT NULL,
  low_tide_time time NOT NULL,
  num_students int unsigned NOT NULL,
--  num_assistants int unsigned NOT NULL DEFAULT '0',
  start_time time NOT NULL,
  stop_time time NOT NULL,
  wind_speed enum('0-1 (calm)','1-3 (light air)','4-7 (light breeze, wind felt on face, leaves rustle)','8-12 (gentle breeze, leaves in constant)','13-18 (moderate breeze, raises dust and loose paper, small branches move)','19-24 (fresh breeze, small trees sway)','25-31 (strong breeze, large branches move, hard to use umbrella)','32-38 (near gale, whole trees move)','39-46 (gale, wind impedes walking)') NOT NULL,
  weather enum('Sunny','Partly Cloudy','Cloudy','Voggy','Light Rain','Raining','Stormy') NOT NULL,
  prior_rain boolean NOT NULL DEFAULT '0',
  rain_amount float(4,2) unsigned DEFAULT NULL,
  stress_id int unsigned DEFAULT NULL,
  wave_height enum('1-3','4-6','7-10','11-15','16-20','above 20') NOT NULL,
  num_people enum('0','1-5','6-10','11-15','16-20','21-25','26-30') NOT NULL DEFAULT '0',
  num_fishing enum('0','1-5','6-10','11-15','16-20') NOT NULL DEFAULT '0',
  num_collecting enum('0','1-5','6-10','11-15') NOT NULL DEFAULT '0',
  collecting varchar(5) DEFAULT NULL,
  num_transect_lines int unsigned NOT NULL,
  num_quadrants_per_transect int unsigned NOT NULL DEFAULT 0, 
  length_transect_lines float(4,2) NOT NULL,
  point_spacing enum('1/4 meter','1/2 meter','3/4 meter','1 meter') NOT NULL,
  comments text DEFAULT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY (location_id) REFERENCES location(id),
  FOREIGN KEY (user_id)  REFERENCES user(id),
  FOREIGN KEY (stress_id) REFERENCES stress (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------


CREATE TABLE transect_data (
  id int unsigned auto_increment,
  session_id int unsigned NOT NULL,
  transect_num int unsigned NOT NULL,
  transect_point int unsigned NOT NULL,
  organism_id int unsigned DEFAULT NULL,
--  organism_num int unsigned ,
  substrate_id int unsigned DEFAULT NULL,
--  substrate_num int unsigned ,
  PRIMARY KEY(id),
  UNIQUE (session_id, transect_num, transect_point),
  FOREIGN KEY (session_id) REFERENCES session_metadata (id),
  FOREIGN KEY (organism_id) REFERENCES organism(id),
  FOREIGN KEY (substrate_id) REFERENCES substrate(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- Table structure for table quadrant_data
--

CREATE TABLE quadrant_data (
  id int unsigned not null auto_increment,
  session_id int unsigned NOT NULL,
  transect_num int unsigned NOT NULL,
  quadrant_placement int unsigned NOT NULL,
  organism_id int unsigned DEFAULT NULL,
  organism_num int unsigned DEFAULT NULL,
  substrate_id int unsigned DEFAULT NULL,
  substrate_num int unsigned DEFAULT NULL,
  primary key(id), 
  UNIQUE(session_id, transect_num, quadrant_num),
  FOREIGN KEY (session_id) REFERENCES session_metadata (id),
  FOREIGN KEY (organism_id) REFERENCES organism(id),
  FOREIGN KEY (substrate_id) REFERENCES substrate(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--Table of random page ids used for the transect pages

CREATE TABLE random_id (
 id INT UNSIGNED NOT NULL AUTO_INCREMENT,
 random INT UNSIGNED NOT NULL,
 PRIMARY KEY (id),
 UNIQUE(random)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;