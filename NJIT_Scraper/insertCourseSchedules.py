from os import listdir;
from os.path import isfile, join;
import MySQLdb;
import json;

mypath="jsonFiles/";
onlyfiles = [ f for f in listdir(mypath) if isfile(join(mypath, f))];
db=MySQLdb.connect(host="localhost", user="root", passwd="welcome", db="NextSemester");
cur = db.cursor();
lname = "";
fname = "";

for f in onlyfiles:

    with open(mypath + f) as data_file:
    	data = json.load(data_file);

    insSql = "INSERT INTO instructor(fname, lname) VALUES(\"%s\", \"%s\")";
    courseSql = "INSERT INTO course(cname, cdesc) VALUES(\"%s\", \"%s\")";

    course_id = -1;
    ins_id = -1;

    for d in data:
    	instructorName = d["instructorName"].strip();
    	if( (instructorName) and instructorName != "See Department"):
    		#print instructorName;
    		instructorSplit = instructorName.split();
    		if( len(instructorSplit) == 1):
    			lname = instructorSplit[0];
    		elif(len(instructorSplit) == 2):
    			lname = instructorSplit[0];
    			fname = instructorSplit[1];
    		elif(len(instructorSplit) == 3):
    			lname = instructorSplit[0];
    			fname = instructorSplit[2];

    		sql = "SELECT id FROM instructor WHERE lname = \"%s\" AND fname REGEXP \"^%s\" LIMIT 1";
    		numRows = -1;
    		if(fname):
    			numRows = cur.execute(sql % (lname, fname));
    		else:
    			sql = "SELECT id FROM instructor WHERE lname = \"%s\" AND fname = \"\" LIMIT 1";
    			numRows = cur.execute(sql % (lname));
    		if(numRows == 0):
    			cur.execute(insSql % (fname, lname));
    			db.commit();
    			nrows = cur.execute("SELECT id FROM instructor WHERE lname = \"%s\" AND fname = \"%s\" LIMIT 1" % (lname, fname));
    			if(nrows != 0):
    				results = cur.fetchall();
    				for row in results:
    					ins_id = row[0];
    		else:
    			results = cur.fetchall();
    			for row in results:
    				ins_id = row[0];

    	#print ins_id;
    	cname = str(d["courseName"].strip());
    	cdesc = d["courseDesc"].strip();

    	try:
    		cur.execute(courseSql % (cname, cdesc));
    		db.commit();
    	except MySQLdb.IntegrityError as err:
    		pass;

    	nrows = cur.execute("SELECT id FROM course WHERE cname = \"%s\" LIMIT 1" % (cname));
    	if(nrows != 0):
    		results = cur.fetchall();
    		for row in results:
    			course_id = row[0];
    	#print course_id;
    	status = d["status"].strip();
    	credits = float(d["credits"].strip());
    	secNum = d["sectionNum"].strip();
    	callNumber = int(d["callNumber"].strip());
    	curCap = int(d["now"].strip());
    	maxCap = int(d["max"].strip());

    	secId = -1;

        try:
            if( (instructorName) and (instructorName != 'See Department') ):
        		cur.execute("INSERT INTO section (sec_no, credits, callnumber, status, maxCap, currentCap, instructorId, courseId) VALUES (\"%s\", '%d', '%d', \"%s\", '%d', '%d', '%d','%d')" % (secNum, credits, callNumber, status, maxCap, curCap, ins_id, course_id));
        		db.commit();
            else:
        		cur.execute("INSERT INTO section (sec_no, credits, callnumber, status, maxCap, currentCap, courseId) VALUES (\"%s\", '%d', '%d', \"%s\", '%d', '%d', '%d')" % (secNum, credits, callNumber, status, maxCap, curCap, course_id));
        		db.commit();
        except MySQLdb.IntegrityError as err:
        	print "Call Number: " + str(callNumber);

        print "Call Number: " + str(callNumber);
        nrows = cur.execute("SELECT id FROM section WHERE callnumber = '%d'" % (callNumber));
        if(nrows != 0):
        	results = cur.fetchall();
        	for row in results:
        		secId = row[0];

        dayInfo = d["dayTimesInfo"];

        schoolDays = '';
        startTime = '';
        endTime = '';
        roomInfo = '';

        for day in dayInfo:

            if(day.has_key("day")):
                schoolDays= day["day"];
            if(day.has_key("startTime")):
                startTime = day["startTime"];
            if(day.has_key("endTime")):
                endTime = day["endTime"];
            if(day.has_key("roomInfo")):
                roomInfo = day["roomInfo"].strip();

            for ind in range(0, len(schoolDays)):
                try:
                    cur.execute("INSERT INTO section_days (day, startTime, endTime, roomInfo, sectionId) VALUES ('%s', '%s', '%s', '%s', '%d')" % (schoolDays[ind], startTime, endTime, roomInfo, secId));
                    db.commit();
                except MySQLdb.IntegrityError as err:
                    print(str(callNumber) + "\t" + str(secId) + "\t" + schoolDays[ind] + "\t" + str(startTime) + "\t" + str(endTime));
    data_file.close();
cur.close();
db.close();
