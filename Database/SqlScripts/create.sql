USE NextSemester;

CREATE TABLE IF NOT EXISTS users (
    id INT(11) NOT NULL AUTO_INCREMENT,
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
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    login_time DATETIME NOT NULL,
    logout_time DATETIME,
    CONSTRAINT pk_login_id PRIMARY KEY(id),
    CONSTRAINT fk_logininfo_uid
        FOREIGN KEY(user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS instructor (
    id INT(11) NOT NULL AUTO_INCREMENT,
    fname VARCHAR(30),
    lname VARCHAR(30),
    rating FLOAT DEFAULT -1.0,
    dept VARCHAR(30),
    link VARCHAR(100),
    CONSTRAINT pk_instructor_id PRIMARY KEY(id),
    CONSTRAINT uk_instructor_link UNIQUE KEY(link)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS course (
    id INT(11) NOT NULL AUTO_INCREMENT,
    cname VARCHAR(12) NOT NULL,
    cdesc VARCHAR(40),
    cinfo BLOB,
    CONSTRAINT pk_course_id PRIMARY KEY(id),
    CONSTRAINT uk_course_name UNIQUE KEY(cname)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS section (
    id INT(11) NOT NULL AUTO_INCREMENT,
    sec_no CHAR(3),
    callnumber MEDIUMINT NOT NULL,
    status VARCHAR(20),
    maxCap SMALLINT,
    currentCap SMALLINT,
    credits FLOAT,
    instructorId INT(11),
    courseId INT(11),
    CONSTRAINT pk_section_id PRIMARY KEY(id),
    CONSTRAINT uk_section_cnum UNIQUE KEY(callnumber),
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
    sectionId INT(11),
    day VARCHAR(6),
    startTime TIME,
    endTime TIME,
    roomInfo VARCHAR(20),
    CONSTRAINT pk_section_days_id PRIMARY KEY(sectionId, day, startTime, endTime),
    CONSTRAINT fk_section_id
        FOREIGN KEY(sectionId)
        REFERENCES section(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS schedule (
	id int(11) NOT NULL AUTO_INCREMENT,
	Name varchar(25) NOT NULL,
	user_id int(11) NOT NULL,
	PRIMARY KEY (id),
	CONSTRAINT fk_UserSchedule
		FOREIGN KEY (user_id)
		REFERENCES users (id)
		ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS sche_sec_rel (
	schedule_id int(11) NOT NULL,
	section_id int(11) NOT NULL,
	time_added timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT fk_schedule_section_sch_id FOREIGN KEY (schedule_id)
		REFERENCES schedule(id)
		ON DELETE CASCADE,
  	CONSTRAINT fk_schedule_section_sec_id FOREIGN KEY (section_id)
		REFERENCES section(id)
		ON DELETE CASCADE,
	PRIMARY KEY (schedule_id, section_id)
) ENGINE=InnoDB;
