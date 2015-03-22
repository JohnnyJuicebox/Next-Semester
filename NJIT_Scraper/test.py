import MySQLdb;
import json;

with open('jsonFiles/CS.json') as data_file:
	data = json.load(data_file);


db=MySQLdb.connect(host="localhost", user="root", passwd="welcome", db="NextSemester");
cur = db.cursor();
insSql = "INSERT INTO instructor(fname, lname) VALUES(\"%s\", \"%s\")";
courseSql = "INSERT INTO course(cname, cdesc) VALUES(\"%s\", \"%s\")";

for d in data:
	
	instructorName = d["instructorName"];

	#if(instructorName != "See Department"):
		
#		lname = instructorName.split()[0];
#		fname = instructorName.split()[1];
#		print fname + " " + lname;
#		
#		sql = "SELECT * FROM instructor WHERE lname = '%s' AND fname REGEXP '^%s'";
#			
#		numRows = cur.execute(sql % (lname, fname));
#		
#		if(numRows == 0):
#			cur.execute(insSql % (fname, lname));
#			db.commit();
#		else:
#			print numRows;

	cname = d["courseName"].strip();
	cdesc = d["courseDesc"].strip();
	
	print (courseSql % (cname, cdesc));	
	try:
		cur.execute(courseSql % (cname, cdesc));
		db.commit();	
	except MySQLdb.IntegrityError as err:
		print();	
cur.close();
db.close();
data_file.close();
