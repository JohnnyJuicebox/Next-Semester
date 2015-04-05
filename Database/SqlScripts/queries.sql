-- USER AUTHENTICATION

-- Check if the user exists in our database

SELECT USER_ID, SALT, PASSWORD
FROM   USER
WHERE  USERNAME = 'hkajur93';

-- Get the login and logout times of a particular user

SELECT LOGIN_TIME, LOGOUT_TIME
FROM   USER U, LOGIN_INFO L
WHERE  L.USER_ID = U.USER_ID
AND    U.USERNAME = 'hkajur93';


--
    SELECT *
    FROM Course C JOIN Section S JOIN section_days D
    WHERE C.id = S.courseId
    AND D.sectionId = S.id
    AND C.cname = 'CS100';

-- Checks if there is an overlap in the schedule
-- If no overlap, it will return an empty set
-- Otherwise, it will give the sections that cause conflict

    SELECT *
    FROM schedule_secs a JOIN schedule_secs b
    WHERE a.startTime <= b.endTime
    AND a.endTime >= b.startTime
    AND a.sectionId != b.sectionId;

-- Get all the courses being taught in this semester

    SELECT DISTINCT(cname)
    FROM course JOIN section
    WHERE course.id = section.courseId;


--  Get the highest rating professor from the list of sections
SELECT a.sectionId
FROM schedule_secs a JOIN schedule_secs b JOIN instructor i
WHERE a.startTime <= b.endTime
AND a.endTime >= b.startTime
AND a.sectionId != b.sectionId
AND a.instructorId = i.id
AND i.rating NOT IN
(
    SELECT MAX(i2.rating)
    FROM instructor i2 JOIN schedule_secs s2
    WHERE s2.instructorId = i2.id
)


