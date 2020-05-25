CREATE TABLE pafap_users (
uid int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
fname VARCHAR(250),
lname VARCHAR(250),
email VARCHAR(250),
sex VARCHAR(10),
birthday date,
pass VARCHAR(255),
status TINYINT(1),
role VARCHAR(7),
date_created datetime
);

CREATE TABLE pafap_category (
cid INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
cname varchar(255)
);
ALTER TABLE pafap_category AUTO_INCREMENT = 101;

CREATE TABLE pafap_category_type(
ctid INT( 11 ) NOT NULL REFERENCES pafap_category( cid ) ,
ctname VARCHAR( 255 )
);

CREATE TABLE pafap_profile (
pid INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
uid INT(11) NOT NULL REFERENCES pafap_users(uid),
image VARCHAR(255) NOT NULL DEFAULT 'users/DEFAULT.PNG',
relationship VARCHAR(30),
nationality VARCHAR(100),
residence VARCHAR(100),
friends INT(7) NOT NULL,
education TEXT,
infocontact TEXT
);
ALTER TABLE pafap_profile AUTO_INCREMENT = 1001;

CREATE TABLE pafap_profile_category (
pid INT(11) NOT NULL REFERENCES pafap_profile(pid),
cid INT(11) NOT NULL,
cname VARCHAR(250)
);

CREATE TABLE pafap_profile_category_type (
pid INT(11) NOT NULL,
cid INT(11) NOT NULL REFERENCES pafap_profile_category(cid),
ctname VARCHAR(250)
);

CREATE TABLE pafap_wall (
wid INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
cid INT(11) NOT NULL,
wuid INT(11) NOT NULL REFERENCES pafap_users(uid),
notes TEXT,
date_created datetime
);
ALTER TABLE pafap_wall AUTO_INCREMENT = 10001;

CREATE TABLE pafap_comments (
wid INT(11) NOT NULL REFERENCES pafap_wall(wid),
cuid INT(11) NOT NULL,
notes TEXT,
date_created datetime
);

CREATE TABLE pafap_agree (
wid INT(11) NOT NULL REFERENCES pafap_wall(wid),
auid INT(11) NOT NULL
);

CREATE TABLE pafap_images (
iid INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
img_url TEXT,
iuid INT(11) NOT NULL REFERENCES pafap_users(uid)
);
ALTER TABLE pafap_images AUTO_INCREMENT = 100001;

CREATE TABLE pafap_images_comments (
iid INT(11) NOT NULL REFERENCES pafap_images(iid),
icuid INT(11) NOT NULL,
notes TEXT,
date_created datetime
);

CREATE TABLE pafap_images_agree (
icaid INT(11) NOT NULL REFERENCES pafap_images(iid),
icauid INT(11) NOT NULL
);


CREATE TABLE pafap_invitations (
uid INT(11) NOT NULL,
iid INT(11) NOT NULL,
status TINYINT(1),
type ENUM('friendship', 'join')
);

CREATE TABLE pafap_friends (
uid INT(11) NOT NULL REFERENCES pafap_users(uid),
fuid INT(11) NOT NULL
);

CREATE TABLE pafap_states (
stateID INT(7) NOT NULL AUTO_INCREMENT PRIMARY KEY,
state VARCHAR(70)
);
ALTER TABLE pafap_states AUTO_INCREMENT = 11;

CREATE TABLE pafap_cities (
citiesID INT(7) NOT NULL REFERENCES pafap_states(stateID),
city VARCHAR(70)
);

CREATE TABLE pafap_messages (
mid INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
fromUID INT(11) NOT NULL,
toUID INT(11) NOT NULL,
notes TEXT,
status TINYINT(1),
date_created DATETIME
);
ALTER TABLE pafap_messages AUTO_INCREMENT = 1000001;

CREATE TABLE pafap_chat (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  fromName VARCHAR(255) NOT NULL DEFAULT '',
  toName VARCHAR(255) NOT NULL DEFAULT '',
  message TEXT NOT NULL,
  sent DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  recd INTEGER UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (id)
);
ALTER TABLE pafap_chat AUTO_INCREMENT = 201;

CREATE TABLE pafap_games (
  gid INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NULL,
  img_url TEXT NULL,
  link TEXT NULL
);
ALTER TABLE pafap_games AUTO_INCREMENT = 301;
ALTER TABLE pafap_agree ADD COLUMN date_created datetime;

alter table pafap_users add owner int;
alter table pafap_wall add status varchar(7);

CREATE TABLE pafap_follows (
fid INT(11) NOT NULL,
fuid INT(11) NOT NULL,
fusr TEXT NULL
);
ALTER TABLE pafap_follows AUTO_INCREMENT = 301;

CREATE TABLE pafap_news (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  noteAlb TEXT NULL,
  noteEng TEXT NULL,
  date_modified DATETIME,
  PRIMARY KEY (id)
);
ALTER TABLE pafap_news AUTO_INCREMENT = 401;