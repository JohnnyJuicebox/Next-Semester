
CREATE TABLE IF NOT EXISTS Room (
    id INT(8) NOT NULL AUTO_INCREMENT,
    building VARCHAR(10),
    rno VARCHAR(10),
    CONSTRAINT pk_room_id PRIMARY KEY(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Course (
    id INT(8) NOT NULL AUTO_INCREMENT,
    subject VARCHAR(40),
    cno SMALLINT,
    cname VARCHAR(20),
    CONSTRAINT pk_course_id PRIMARY KEY(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Section (
    id INT(8) NOT NULL AUTO_INCREMENT,
    sec_no INT(8),
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
        REFERENCES Instructor(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_sec_course_id
        FOREIGN KEY(courseId)
        ON DELETE CASCADE
) ENGINE=InnoDB;

