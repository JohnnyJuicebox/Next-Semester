USE NextSemester;

CREATE TABLE IF NOT EXISTS users (
    id INT(8) NOT NULL AUTO_INCREMENT,
    fname       VARCHAR(30),
    lname       VARCHAR(30),
    username    VARCHAR(50),
    password    CHAR(60),
    email       VARCHAR(50),
    major       VARCHAR(50),
    created_at  DATETIME,
    updated_at  DATETIME,
    CONSTRAINT pk_user_id PRIMARY KEY(id),
    CONSTRAINT uk_email UNIQUE KEY(email),
    CONSTRAINT uk_username UNIQUE KEY(username)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS login_info (
    id INT(8) NOT NULL AUTO_INCREMENT,
    user_id INT(8) NOT NULL,
    login_time DATETIME NOT NULL,
    logout_time DATETIME,
    CONSTRAINT pk_login_id PRIMARY KEY(id),
    CONSTRAINT fk_logininfo_uid
        FOREIGN KEY(user_id)
        REFERENCES Users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS instructor (
    id INT(8) NOT NULL AUTO_INCREMENT,
    fname VARCHAR(30),
    lname VARCHAR(30),
    rating FLOAT,
    link VARCHAR(100),
    CONSTRAINT pk_instructor_id PRIMARY KEY(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS course (
    id INT(8) NOT NULL AUTO_INCREMENT,
    cname VARCHAR(12) NOT NULL,
    cdesc VARCHAR(40),
    CONSTRAINT pk_course_id PRIMARY KEY(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS section (
    id INT(8) NOT NULL AUTO_INCREMENT,
    sec_no CHAR(3),
    callnumber MEDIUMINT,
    status VARCHAR(20),
    maxCap SMALLINT,
    currentCap SMALLINT,
    credits FLOAT,
    instructorId INT(8),
    courseId INT(8),
    CONSTRAINT pk_section_id PRIMARY KEY(id),
    CONSTRAINT fk_sec_instructor_id
        FOREIGN KEY(instructorId)
        REFERENCES instructor(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_sec_course_id
        FOREIGN KEY(courseId)
        REFERENCES course(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS section_days (
    id INT(8) NOT NULL AUTO_INCREMENT,
    sectionId INT(8),
    day VARCHAR(6),
    startTime TIME,
    endTime TIME,
    roomInfo VARCHAR(20),
    CONSTRAINT pk_section_days_id PRIMARY KEY(id),
    CONSTRAINT fk_section_id
        FOREIGN KEY(sectionId)
        REFERENCES section(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;
