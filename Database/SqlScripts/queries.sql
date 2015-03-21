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
