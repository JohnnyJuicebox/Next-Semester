#!/usr/bin/python

import MySQLdb;
import json;
from pprint import pprint;

with open('njitProfessorRatings.json') as data_file:
	data = json.load(data_file);

db=MySQLdb.connect(host="localhost", user="root", passwd="welcome", db="NextSemester");
cur = db.cursor();

for d in data:
	
	fname = d["tFname"].strip().capitalize();	
	lname = d["tLname"].strip().capitalize();	
	dept = d["tDept"].strip();
	rating = d["overall_rating"];
	link = d["tid"];

	if(rating == "N/A"):
		rating = -1.0;

	sql = "INSERT INTO instructor(fname, lname, dept, rating, link) VALUES (";
	sql = sql + "\"" + fname + "\"" +  ",";
	sql = sql + "\"" + lname + "\"" + ",";
	sql = sql + "\"" + dept + "\"" + ",";
	sql = sql + str(rating) + ",";
	sql = sql + "\"" + str(link) + "\"" + ")";

	print sql;	
	cur.execute(sql);
	db.commit();

cur.close();
db.close();
data_file.close();
