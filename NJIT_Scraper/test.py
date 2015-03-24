import MySQLdb;
import json;

with open('jsonFiles/CS.json') as data_file:
	data = json.load(data_file);

db=MySQLdb.connect(host="localhost", user="root", passwd="welcome", db="NextSemester");
cur = db.cursor();

insSql = "INSERT INTO instructor(fname, lname) VALUES(\"%s\", \"%s\")";
courseSql = "INSERT INTO course(cname, cdesc) VALUES(\"%s\", \"%s\")";

course_id = -1;
ins_id = -1;

for d in data:
	instructorName = d["instructorName"];
	if(instructorName != "See Department"):
		lname = instructorName.split()[0];
		fname = instructorName.split()[1];
		sql = "SELECT id FROM instructor WHERE lname = '%s' AND fname REGEXP '^%s' LIMIT 1";
		numRows = cur.execute(sql % (lname, fname));
		if(numRows == 0):
			cur.execute(insSql % (fname, lname));
			db.commit();
			ins_id = db.insert_id();
		else:
			results = cur.fetchall();
			for row in results:
				ins_id = row[0];

	cname = str(d["courseName"].strip());
	cdesc = d["courseDesc"].strip();

	try:
		cur.execute(courseSql % (cname, cdesc));
		db.commit();
		nrows = cur.execute("SELECT id FROM course WHERE cname = \"%s\" LIMIT 1" % (cname));
		if(nrows != 0):
			results = cur.fetchall();
			for row in results:
				course_id = row[0];
	except MySQLdb.IntegrityError as err:
		nrows = cur.execute("SELECT id FROM course WHERE cname = \"%s\" LIMIT 1" % (cname));
        if(nrows != 0):
			results = cur.fetchall();
			for row in results:
				course_id = row[0];

#	print course_id;
	status = d["status"].strip();
	credits = float(d["credits"].strip());
	secNum = d["sectionNum"].strip();
	callNumber = int(d["callNumber"].strip());
	curCap = int(d["now"].strip());
	maxCap = int(d["max"].strip());

	cur.execute("INSERT INTO section (sec_no, credits, callnumber, status, maxCap, currentCap, instructorId, courseId) VALUES (\"%s\", '%d', '%d', \"%s\", '%d', '%d', '%d','%d')" % (secNum, credits, callNumber, status, maxCap, curCap, ins_id, course_id));
	db.commit();

cur.close();
db.close();
data_file.close();
