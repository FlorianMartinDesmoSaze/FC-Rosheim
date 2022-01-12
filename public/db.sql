fc_rosheimCREATE TABLE Team(
   id INT,
   team_name VARCHAR(255) NOT NULL,
   season VARCHAR(50) NOT NULL,
   picture VARCHAR(255),
   slug VARCHAR(255) NOT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE Sponsor(
   id INT,
   title VARCHAR(255) NOT NULL,
   link VARCHAR(255) NOT NULL,
   picture VARCHAR(255),
   slug VARCHAR(255) NOT NULL,
   status LOGICAL,
   PRIMARY KEY(id)
);

CREATE TABLE Game(
   id INT,
   opponent VARCHAR(255) NOT NULL,
   score_team INT,
   score_opponent INT,
   game_date DATETIME NOT NULL,
   home LOGICAL NOT NULL,
   id_1 INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(id_1) REFERENCES Team(id)
);

CREATE TABLE Training(
   id INT,
   title VARCHAR(255) NOT NULL,
   description ,
   location VARCHAR(255) NOT NULL,
   days VARCHAR(255),
   start_time TIME NOT NULL,
   end_time TIME NOT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE Users(
   user_id INT,
   mail VARCHAR(255),
   password VARCHAR(255) NOT NULL,
   role VARCHAR(255) NOT NULL,
   nickname VARCHAR(50),
   phone VARCHAR(50),
   first_name VARCHAR(255),
   last_name VARCHAR(255),
   birthdate DATETIME,
   license LOGICAL,
   id INT,
   PRIMARY KEY(user_id),
   UNIQUE(mail),
   FOREIGN KEY(id) REFERENCES Team(id)
);

CREATE TABLE Player(
   id INT,
   first_name VARCHAR(255) NOT NULL,
   last_name VARCHAR(255) NOT NULL,
   numero VARCHAR(50) NOT NULL,
   birthdate VARCHAR(255) NOT NULL,
   picture VARCHAR(255),
   slug VARCHAR(255) NOT NULL,
   id_1 INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(id_1) REFERENCES Team(id)
);

CREATE TABLE Role(
   id INT,
   name VARCHAR(50),
   id_1 INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(id_1) REFERENCES Player(id)
);

CREATE TABLE Staff(
   id INT,
   first_name VARCHAR(255) NOT NULL,
   last_name VARCHAR(255) NOT NULL,
   positions VARCHAR(255) NOT NULL,
   phone VARCHAR(50),
   email VARCHAR(255),
   user_id INT,
   PRIMARY KEY(id),
   UNIQUE(user_id),
   FOREIGN KEY(user_id) REFERENCES Users(user_id)
);

CREATE TABLE Stats(
   id INT,
   game_played INT,
   clean_sheets INT,
   saves INT,
   assists INT,
   goals INT,
   yellow_card INT,
   red_card INT,
   id_1 INT NOT NULL,
   PRIMARY KEY(id),
   UNIQUE(id_1),
   FOREIGN KEY(id_1) REFERENCES Player(id)
);

CREATE TABLE Event(
   id INT,
   title VARCHAR(255) NOT NULL,
   text  NOT NULL,
   type VARCHAR(255) NOT NULL,
   location VARCHAR(255) NOT NULL,
   start_date DATETIME NOT NULL,
   end_date DATETIME NOT NULL,
   slug VARCHAR(255) NOT NULL,
   user_id INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(user_id) REFERENCES Users(user_id)
);

CREATE TABLE News(
   id INT,
   title VARCHAR(255) NOT NULL,
   content  NOT NULL,
   picture VARCHAR(255),
   slug VARCHAR(255) NOT NULL,
   created_at DATETIME NOT NULL,
   updated_at DATETIME,
   id_1 INT,
   id_2 INT,
   user_id INT NOT NULL,
   PRIMARY KEY(id),
   UNIQUE(id_2),
   FOREIGN KEY(id_1) REFERENCES Team(id),
   FOREIGN KEY(id_2) REFERENCES Event(id),
   FOREIGN KEY(user_id) REFERENCES Users(user_id)
);

CREATE TABLE MultiPicture(
   id INT,
   name VARCHAR(255) NOT NULL,
   created_at DATETIME NOT NULL,
   updated_at VARCHAR(50),
   id_1 INT,
   id_2 INT,
   PRIMARY KEY(id),
   FOREIGN KEY(id_1) REFERENCES Event(id),
   FOREIGN KEY(id_2) REFERENCES Team(id)
);

CREATE TABLE train(
   id INT,
   id_1 INT,
   PRIMARY KEY(id, id_1),
   FOREIGN KEY(id) REFERENCES Team(id),
   FOREIGN KEY(id_1) REFERENCES Training(id)
);
