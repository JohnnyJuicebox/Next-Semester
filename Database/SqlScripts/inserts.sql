
-- INSERTION FOR USER TABLE when the user registers to our site

INSERT INTO USER (USER_ID, FNAME, LNAME, USERNAME, PASSWORD, SALT, EMAIL, DEGREE)
    VALUES(1, 'Harish', 'Kajur', 'hkajur93', 'oj239jija329jwjffu93jjfiajsoj', '3iiojjejfoajf', 'hkajur93@gmail.com', 'BS in Computer Science');

    -- NOTE: Since user_id is auto increments we don't need to worry about that column and it can't be null

-- INSERTION FOR LOGIN_INFO TABLE when the user logins

INSERT INTO LOGIN_INFO (LOGIN_ID, USER_ID, LOGIN_TIME, LOGOUT_TIME)
    VALUES(1, 1, '2015-03-18 07:26:27', '2015-03-18 07:26:29');

    -- NOTE: LOGIN_ID auto increments and USER_ID must be a value from USER TABLE
    -- Also, logout information is inside the updates.sql because we need to update table

