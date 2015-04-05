CREATE VIEW schedule_secs AS
SELECT *
FROM section_days JOIN sche_sec_rel JOIN section
WHERE section_days.sectionId = sche_sec_rel.section_id
AND section_days.sectionId = section.id;

CREATE VIEW conflict AS
SELECT a.section_id, a.courseId, a.sec_no, a.callnumber, a.startTime, a.endTime, a.instructorId, a.schedule_id
FROM schedule_secs a JOIN schedule_secs b
WHERE a.startTime <= b.endTime
AND a.endTime >= b.startTime
AND a.sectionId != b.sectionId
AND a.schedule_id = b.schedule_id

-- Get all the course section joined with days
CREATE VIEW course_sec_info AS
SELECT  section.id AS sec_id,
        section.sec_no,
        section_days.startTime,
        section_days.endTime,
        section_days.day,
        course.cname,
        course.cdesc
FROM course JOIN section JOIN section_days
WHERE section.id = section_days.sectionId
AND course.id = section.courseId;

CREATE VIEW current_courses AS
SELECT DISTINCT(cname), cdesc
FROM course JOIN section
WHERE course.id = section.courseId;

CREATE VIEW course_sections AS
select course.cname, section.id, section.sec_no, instructor.fname, instructor.lname, instructor.rating, instructor.link
from course JOIN section JOIN instructor
WHERE section.courseId = course.id
and instructor.id = section.instructorId;

