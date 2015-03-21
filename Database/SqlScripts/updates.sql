-- Update the LOGIN_INFO Table when user logs out

    UPDATE LOGIN_INFO
    SET LOGOUT_TIME = '2015-03-20 08:30:39'
    WHERE LOGIN_ID = 1;

    -- NOTE: LOGOUT time is the datetime stamp, and LOGIN_ID is procured
    -- from when uesr logins using the mysql_last_insert which will give login id of last insertion


-- Update the first name of the user
    UPDATE User
    SET FNAME = 'firstname'
    WHERE USER_ID = 1;

-- Update the last name of the user
    UPDATE User
    SET LNAME = 'lastname'
    WHERE USER_ID = 1;
