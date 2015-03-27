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


SELECT *
FROM Course C JOIN Section S JOIN section_days D
WHERE C.id = S.courseId
AND D.sectionId = S.id
AND C.cname = 'CS100';
