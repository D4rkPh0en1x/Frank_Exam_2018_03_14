CREATE TABLE movies (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(255) NOT NULL,
    actors VARCHAR(255),
    director VARCHAR(255),
    producer VARCHAR(255),
    year_of_prod YEAR,
    language VARCHAR(255),
    category ENUM ('Comedy','Action','Horror','Love','Thriller','Adventure','Drama','Musical','Sci-Fi','War','Western','Crime','Epics'),
    storyline TEXT,
    video VARCHAR(255)
)ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_bin;


 