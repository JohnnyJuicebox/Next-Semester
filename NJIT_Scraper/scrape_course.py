import requests
import MySQLdb
from bs4 import BeautifulSoup

db=MySQLdb.connect(host="localhost", user="root", passwd="welcome", db="NextSemester");
cur = db.cursor();
course_sql = "INSERT INTO course (cname, cdesc, cinfo) VALUES (\"%s\", \"%s\", \"%s\")";
req = requests.get("http://catalog.njit.edu/courses/cs.php");
soup = BeautifulSoup(req.text);

tds = soup.find_all("td");

for td in tds:
	cname = '';
	cdesc = '';
	cinfo = '';

	if(td.has_attr("class") and td["class"][0] == "bodytxt"):

		ptags = td.find_all("p");
		for ptag in ptags:
			atags = ptag.find_all("a");
			for atag in atags:
				if(atag.has_attr("name")):
					cname = atag["name"].upper();
					boldTags = atag.find_all("b");
					cdesc = '';
					for boldTag in boldTags:
						desc = boldTag.get_text();
						cdesc = desc.strip().split("-")[1].split("(")[0].strip();
			cinfo = ptag.get_text().split(")")[1].strip();
			print cname + "\t" + cdesc + "\t" + cinfo;
			try:
				cur.execute(course_sql % (cname, cdesc, cinfo));
				db.commit();
			except MySQLdb.IntegrityError as err:
				pass;

cur.close();
db.close();