use NextSemester;
SELECT * 
FROM   instructor
WHERE lname IN
	(SELECT lname 
	 FROM instructor
	 GROUP BY lname
	 HAVING COUNT(lname) >= 2);