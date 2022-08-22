DROP TABLE Description CASCADE CONSTRAINTS;
DROP TABLE ProfileWrite_1 CASCADE CONSTRAINTS;
DROP TABLE ProfileWrite_2 CASCADE CONSTRAINTS;
DROP TABLE ProfileWrite_3 CASCADE CONSTRAINTS;
DROP TABLE Match CASCADE CONSTRAINTS;
DROP TABLE ChatStart CASCADE CONSTRAINTS;
DROP TABLE Receive CASCADE CONSTRAINTS;
DROP TABLE ProfileCreate_1 CASCADE CONSTRAINTS;
DROP TABLE ProfileCreate_2 CASCADE CONSTRAINTS;
DROP TABLE ProfileCreate_3 CASCADE CONSTRAINTS;
DROP TABLE UserDeactivate_1 CASCADE CONSTRAINTS;
DROP TABLE UserDeactivate_2 CASCADE CONSTRAINTS;
DROP TABLE PhotoPost CASCADE CONSTRAINTS;
DROP TABLE Free CASCADE CONSTRAINTS;
DROP TABLE Preference CASCADE CONSTRAINTS;
DROP TABLE PremiumSet CASCADE CONSTRAINTS;
DROP TABLE OtherSocialLink CASCADE CONSTRAINTS;

CREATE TABLE Description (
    did INTEGER PRIMARY KEY,
    text CHAR(150),
    prompt CHAR(50)
);

CREATE TABLE ProfileWrite_1 (
    dob DATE PRIMARY KEY,
    age INTEGER
);

CREATE TABLE ProfileWrite_2 (
    dob DATE PRIMARY KEY,
    horoscope CHAR(10)
);

CREATE TABLE ProfileWrite_3 (
    id INTEGER PRIMARY KEY,
    name CHAR(20),
    height INTEGER,
    gender CHAR(6),
    dob DATE,
    did INTEGER,
    FOREIGN KEY (did) REFERENCES Description(did) 
);

CREATE TABLE Match (
    mid INTEGER PRIMARY KEY
);

CREATE TABLE ChatStart (
    first_msg CHAR(80),
    mid INTEGER,
    last_msg CHAR(80),
    PRIMARY KEY (first_msg, mid),
    FOREIGN KEY (mid)
        REFERENCES Match(mid)
        ON DELETE CASCADE -- Weak Entity
);

CREATE TABLE Receive (
    mid INTEGER,
    id INTEGER,
    recDate DATE,
    PRIMARY KEY (mid, id),
    FOREIGN KEY (mid) REFERENCES Match(mid),
    FOREIGN KEY (id) REFERENCES ProfileWrite_3(id)
);

CREATE TABLE ProfileCreate_1 (
    dob DATE PRIMARY KEY,
    age INTEGER
);

CREATE TABLE ProfileCreate_2 (
    dob DATE PRIMARY KEY,
    horoscope CHAR(10)
);

CREATE TABLE ProfileCreate_3 (
    id INTEGER PRIMARY KEY,
    name CHAR(20),
    height INTEGER,
    gender CHAR(6),
    dob DATE
    -- userid INTEGER NOT NULL, -- Total Participation
    -- FOREIGN KEY (userid) REFERENCES UserDeactivate_2(userid) -- Removed due to cyclic foreign keys
    --     ON DELETE CASCADE
);

CREATE TABLE UserDeactivate_1 (
    email CHAR(30) PRIMARY KEY,
    password CHAR(50)
);

CREATE TABLE UserDeactivate_2 (
    userid INTEGER,
    email CHAR(30),
    id INTEGER UNIQUE, -- Key Constraint
    PRIMARY KEY (userid),
    FOREIGN KEY (id) REFERENCES ProfileCreate_3(id)
        ON DELETE CASCADE -- One-to-One
);

CREATE TABLE PhotoPost (
    purl CHAR(30) PRIMARY KEY,
    caption CHAR(50),
    id INTEGER,
    FOREIGN KEY (id) REFERENCES ProfileCreate_3(id)
        ON DELETE CASCADE
);

CREATE TABLE Free (
    id INTEGER PRIMARY KEY,
    free_count INTEGER,
    FOREIGN KEY (id) REFERENCES ProfileCreate_3(id)
        ON DELETE CASCADE -- ISA
);

CREATE TABLE Preference (
    pid INTEGER PRIMARY KEY,
    gender CHAR(6),
    distance INTEGER,
    location CHAR(20),
    race CHAR(20),
    age INTEGER,
    horoscope CHAR(10)
);

CREATE TABLE PremiumSet (
    id INTEGER PRIMARY KEY,
    pid INTEGER,
    voice_message CHAR(50),
    cost INTEGER,
    premium_count INTEGER,
    FOREIGN KEY (id) REFERENCES ProfileCreate_3(id)
        ON DELETE CASCADE, -- ISA
    FOREIGN KEY (pid) REFERENCES Preference(pid)
);

CREATE TABLE OtherSocialLink (
    surl CHAR(50) PRIMARY KEY,
    id INTEGER,
    FOREIGN KEY (id) REFERENCES ProfileCreate_3(id)
        ON DELETE CASCADE
);

GRANT SELECT ON Description TO PUBLIC;
GRANT SELECT ON ProfileWrite_1 TO PUBLIC;
GRANT SELECT ON ProfileWrite_2 TO PUBLIC;
GRANT SELECT ON ProfileWrite_3 TO PUBLIC;
GRANT SELECT ON Match TO PUBLIC;
GRANT SELECT ON ChatStart TO PUBLIC;
GRANT SELECT ON Receive TO PUBLIC;
GRANT SELECT ON ProfileCreate_1 TO PUBLIC;
GRANT SELECT ON ProfileCreate_2 TO PUBLIC;
GRANT SELECT ON ProfileCreate_3 TO PUBLIC;
GRANT SELECT ON UserDeactivate_1 TO PUBLIC;
GRANT SELECT ON UserDeactivate_2 TO PUBLIC;
GRANT SELECT ON PhotoPost TO PUBLIC;
GRANT SELECT ON Free TO PUBLIC;
GRANT SELECT ON PremiumSet TO PUBLIC;
GRANT SELECT ON Preference TO PUBLIC;
GRANT SELECT ON OtherSocialLink TO PUBLIC;

INSERT INTO Description(did, text, prompt) VALUES (1, 'flowers', 'What is your favourite item?');
INSERT INTO Description(did, text, prompt) VALUES (2, 'basketball', 'What is your favourite hobby?');
INSERT INTO Description(did, text, prompt) VALUES (3, 'sushi', 'What is your favourite meal?');
INSERT INTO Description(did, text, prompt) VALUES (4, 'play hockey', 'What do you like to do in your pastime?');
INSERT INTO Description(did, text, prompt) VALUES (5, 'you vibe with me', 'I like you if...');

INSERT INTO ProfileWrite_1(dob, age) VALUES (TO_DATE('2002-10-25','YYYY-MM-DD'), 19);
INSERT INTO ProfileWrite_1(dob, age) VALUES (TO_DATE('2002-10-20','YYYY-MM-DD'), 19);
INSERT INTO ProfileWrite_1(dob, age) VALUES (TO_DATE('2002-09-26','YYYY-MM-DD'), 19);
INSERT INTO ProfileWrite_1(dob, age) VALUES (TO_DATE('2001-01-01','YYYY-MM-DD'), 20);
INSERT INTO ProfileWrite_1(dob, age) VALUES (TO_DATE('2002-07-07','YYYY-MM-DD'), 0);

INSERT INTO ProfileWrite_2(dob, horoscope) VALUES (TO_DATE('2002-10-25','YYYY-MM-DD'), 'Scorpio');
INSERT INTO ProfileWrite_2(dob, horoscope) VALUES (TO_DATE('2002-10-20','YYYY-MM-DD'), 'Libra');
INSERT INTO ProfileWrite_2(dob, horoscope) VALUES (TO_DATE('2002-09-26','YYYY-MM-DD'), 'Libra');
INSERT INTO ProfileWrite_2(dob, horoscope) VALUES (TO_DATE('2001-01-01','YYYY-MM-DD'), 'Capricorn');
INSERT INTO ProfileWrite_2(dob, horoscope) VALUES (TO_DATE('2002-07-07','YYYY-MM-DD'), 'Cancer');

INSERT INTO ProfileWrite_3(id, name, height, gender, dob, did) VALUES (1, 'Sam Zhao', 182, 'male', TO_DATE('2002-10-25','YYYY-MM-DD'), 1);
INSERT INTO ProfileWrite_3(id, name, height, gender, dob, did) VALUES (2, 'Alvin Chao', 181, 'female', TO_DATE('2002-10-20','YYYY-MM-DD'), 2);
INSERT INTO ProfileWrite_3(id, name, height, gender, dob, did) VALUES (3, 'Justin Zhao', 180, 'male', TO_DATE('2002-09-26','YYYY-MM-DD'), 3);
INSERT INTO ProfileWrite_3(id, name, height, gender, dob, did) VALUES (4, 'Aaron Zhou', 179, 'female', TO_DATE('2001-01-01','YYYY-MM-DD'), 4);
INSERT INTO ProfileWrite_3(id, name, height, gender, dob, did) VALUES (5, 'John Smith', 20, 'other', TO_DATE('2002-07-07','YYYY-MM-DD'), 5);

INSERT INTO Match(mid) VALUES (1);
INSERT INTO Match(mid) VALUES (2);
INSERT INTO Match(mid) VALUES (3);
INSERT INTO Match(mid) VALUES (4);
INSERT INTO Match(mid) VALUES (5);

INSERT INTO ChatStart(first_msg, mid, last_msg) VALUES ('heyyyy', 1, 'k bye');
INSERT INTO ChatStart(first_msg, mid, last_msg) VALUES ('hi', 2, 'bye lol');
INSERT INTO ChatStart(first_msg, mid, last_msg) VALUES ('you sexi', 3, 'ur gross');
INSERT INTO ChatStart(first_msg, mid, last_msg) VALUES ('lemme lick you', 4, 'aight pce');
INSERT INTO ChatStart(first_msg, mid, last_msg) VALUES ('damn you fine as hell', 5, 'goodbye.');

INSERT INTO Receive(mid, id, recDate) VALUES (1, 1, TO_DATE('2022-07-20','YYYY-MM-DD'));
INSERT INTO Receive(mid, id, recDate) VALUES (2, 1, TO_DATE('2022-07-20','YYYY-MM-DD'));
INSERT INTO Receive(mid, id, recDate) VALUES (3, 1, TO_DATE('2022-07-20','YYYY-MM-DD'));
INSERT INTO Receive(mid, id, recDate) VALUES (4, 1, TO_DATE('2022-07-20','YYYY-MM-DD'));
INSERT INTO Receive(mid, id, recDate) VALUES (5, 1, TO_DATE('2022-07-20','YYYY-MM-DD'));

INSERT INTO Receive(mid, id, recDate) VALUES (1, 2, TO_DATE('2022-06-21','YYYY-MM-DD'));
INSERT INTO Receive(mid, id, recDate) VALUES (2, 2, TO_DATE('2022-06-21','YYYY-MM-DD'));
INSERT INTO Receive(mid, id, recDate) VALUES (3, 2, TO_DATE('2022-06-21','YYYY-MM-DD'));
INSERT INTO Receive(mid, id, recDate) VALUES (4, 2, TO_DATE('2022-06-21','YYYY-MM-DD'));
INSERT INTO Receive(mid, id, recDate) VALUES (5, 2, TO_DATE('2022-06-21','YYYY-MM-DD'));

INSERT INTO Receive(mid, id, recDate) VALUES (3, 3, TO_DATE('2022-07-22','YYYY-MM-DD'));
INSERT INTO Receive(mid, id, recDate) VALUES (4, 4, TO_DATE('2022-10-23','YYYY-MM-DD'));
INSERT INTO Receive(mid, id, recDate) VALUES (5, 5, TO_DATE('2022-07-01','YYYY-MM-DD'));

INSERT INTO ProfileCreate_1(dob, age) VALUES (TO_DATE('2002-10-25','YYYY-MM-DD'), 19);
INSERT INTO ProfileCreate_1(dob, age) VALUES (TO_DATE('2002-10-20','YYYY-MM-DD'), 19);
INSERT INTO ProfileCreate_1(dob, age) VALUES (TO_DATE('2002-09-26','YYYY-MM-DD'), 19);
INSERT INTO ProfileCreate_1(dob, age) VALUES (TO_DATE('2001-01-01','YYYY-MM-DD'), 20);
INSERT INTO ProfileCreate_1(dob, age) VALUES (TO_DATE('2022-07-07','YYYY-MM-DD'), 0);

INSERT INTO ProfileCreate_2(dob, horoscope) VALUES (TO_DATE('2002-10-25','YYYY-MM-DD'), 'Scorpio');
INSERT INTO ProfileCreate_2(dob, horoscope) VALUES (TO_DATE('2002-10-20','YYYY-MM-DD'), 'Libra');
INSERT INTO ProfileCreate_2(dob, horoscope) VALUES (TO_DATE('2002-09-26','YYYY-MM-DD'), 'Libra');
INSERT INTO ProfileCreate_2(dob, horoscope) VALUES (TO_DATE('2001-01-01','YYYY-MM-DD'), 'Capricorn');
INSERT INTO ProfileCreate_2(dob, horoscope) VALUES (TO_DATE('2022-07-07','YYYY-MM-DD'), 'Cancer');

INSERT INTO ProfileCreate_3(id, name, height, gender, dob) VALUES (1, 'Sam Zhao', 182, 'male', TO_DATE('2002-10-25','YYYY-MM-DD'));
INSERT INTO ProfileCreate_3(id, name, height, gender, dob) VALUES (2, 'Alvin Chao', 181, 'female', TO_DATE('2002-10-20','YYYY-MM-DD'));
INSERT INTO ProfileCreate_3(id, name, height, gender, dob) VALUES (3, 'Justin Zhao', 180, 'male', TO_DATE('2002-09-26','YYYY-MM-DD'));
INSERT INTO ProfileCreate_3(id, name, height, gender, dob) VALUES (4, 'Aaron Zhou', 179, 'female', TO_DATE('2001-01-01','YYYY-MM-DD'));
INSERT INTO ProfileCreate_3(id, name, height, gender, dob) VALUES (5, 'John Smith', 20, 'other', TO_DATE('2022-07-07','YYYY-MM-DD'));

INSERT INTO UserDeactivate_1(email, password) VALUES ('samzhao273@gmail.com', 'peepeepoopoo123');
INSERT INTO UserDeactivate_1(email, password) VALUES ('alvinchao273@hotmail.com', 'ilovelife123');
INSERT INTO UserDeactivate_1(email, password) VALUES ('justinzhao273@outlook.com', 'ilovemychildren123123');
INSERT INTO UserDeactivate_1(email, password) VALUES ('calzone@gmail.com', 'kekekeke321');
INSERT INTO UserDeactivate_1(email, password) VALUES ('johnsmith@gmail.com', 'sheesh00000001');

INSERT INTO UserDeactivate_2(userid, email, id) VALUES (1, 'samzhao273@gmail.com', 1);
INSERT INTO UserDeactivate_2(userid, email, id) VALUES (2, 'alvinchao273@hotmail.com', 2);
INSERT INTO UserDeactivate_2(userid, email, id) VALUES (3, 'justinzhao273@outlook.com', 3);
INSERT INTO UserDeactivate_2(userid, email, id) VALUES (4, 'calzone@gmail.com', 4);
INSERT INTO UserDeactivate_2(userid, email, id) VALUES (5, 'johnsmith@gmail.com', 5);

INSERT INTO PhotoPost(purl, caption, id) VALUES ('www.imgur.com/1', 'me and my dogs', 1);
INSERT INTO PhotoPost(purl, caption, id) VALUES ('www.imgur.com/2', 'me and my cats', 2);
INSERT INTO PhotoPost(purl, caption, id) VALUES ('www.imgur.com/3', 'sailing', 3);
INSERT INTO PhotoPost(purl, caption, id) VALUES ('www.imgur.com/4', 'my working on my cs homework', 4);
INSERT INTO PhotoPost(purl, caption, id) VALUES ('www.imgur.com/5', 'i love cooking', 5);

INSERT INTO Free(id, free_count) VALUES (1, 20);
INSERT INTO Free(id, free_count) VALUES (2, 21);
INSERT INTO Free(id, free_count) VALUES (3, 22);
INSERT INTO Free(id, free_count) VALUES (4, 23);
INSERT INTO Free(id, free_count) VALUES (5, 24);

INSERT INTO Preference(pid, gender, distance, location, race, age, horoscope) VALUES (1, 'male', 50, 'Richmond', 'Asian', 19, 'Scorpio');
INSERT INTO Preference(pid, gender, distance, location, race, age, horoscope) VALUES (2, 'female', 3, 'Vancouver', 'Caucasian', 50, 'Libra');
INSERT INTO Preference(pid, gender, distance, location, race, age, horoscope) VALUES (3, 'male', 40, 'Burnaby', 'Black', 18, 'Libra');
INSERT INTO Preference(pid, gender, distance, location, race, age, horoscope) VALUES (4, 'female', 60, 'Coquitlam', 'Hispanic', 80, 'Capricorn');
INSERT INTO Preference(pid, gender, distance, location, race, age, horoscope) VALUES (5, 'other', 7, 'Vancouver', 'Asian', 19, 'Cancer');

INSERT INTO PremiumSet(id, pid, voice_message, cost, premium_count) VALUES (1, 1, 'Hello everyone!', 5, 49);
INSERT INTO PremiumSet(id, pid, voice_message, cost, premium_count) VALUES (2, 2, 'Where is everyone?', 5, 50);
INSERT INTO PremiumSet(id, pid, voice_message, cost, premium_count) VALUES (3, 3, 'Hi', 5, 51);
INSERT INTO PremiumSet(id, pid, voice_message, cost, premium_count) VALUES (4, 4, 'I love long walks on the beach', 5, 52);
INSERT INTO PremiumSet(id, pid, voice_message, cost, premium_count) VALUES (5, 5, 'I love dogs', 5, 53);

INSERT INTO OtherSocialLink(surl, id) VALUES ('www.facebook.com', 1);
INSERT INTO OtherSocialLink(surl, id) VALUES ('www.instagram.com', 2);
INSERT INTO OtherSocialLink(surl, id) VALUES ('www.wechat.com', 3);
INSERT INTO OtherSocialLink(surl, id) VALUES ('www.whatsapp.com', 4);
INSERT INTO OtherSocialLink(surl, id) VALUES ('www.snapchat.com', 5);