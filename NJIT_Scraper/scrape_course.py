import requests
import MySQLdb
from bs4 import BeautifulSoup
import time;

def attach(lst):
    desc = '';
    for x in lst:
        desc = desc + x;
    return desc;

def get_lst_urls():
    req = requests.get('http://catalog.njit.edu/courses/');
    soup = BeautifulSoup(req.text);
    spanlst = soup.find_all('span');
    lst = [];
    for span in spanlst:
        if(span.has_attr('class') and span['class'][0] == 'bodytxt'):
            liTags = span.find_all('li');
            for liTag in liTags:
                if(liTag.a.has_attr('href')):
                    lst.append(liTag.a['href'].split('#')[0]);
    req.close();
    return lst;

pages_lst = get_lst_urls();
main_url = 'http://catalog.njit.edu/';

db=MySQLdb.connect(host="localhost", user="root", passwd="welcome", db="NextSemester");
cur = db.cursor();
course_sql = "INSERT INTO course (cname, cdesc, cinfo) VALUES (\"%s\", \"%s\", \"%s\")";
index = 0;
for page in pages_lst:
    req = requests.get(main_url + page);

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
    						cdesc = attach(desc.strip().split("-")[1:]).split("(")[0].strip()[:40];
    			if(len(ptag.get_text().split(")")) >= 2):
    				cinfo = ptag.get_text().split(")")[1].strip().replace("\"", "").replace("'", "");
    				try:
    					if(cname.find('/') != -1):
    						cnameLst = cname.split("/");
    						for cn in cnameLst:
    							cur.execute(course_sql % (cn[:12], cdesc, cinfo));
    							db.commit();
    					else:
    						cur.execute(course_sql % (cname[:12], cdesc, cinfo));
    						db.commit();
    				except MySQLdb.IntegrityError as err:
    					pass;

    req.close();
    index = index + 1;
    time.sleep(5);
cur.close();
db.close();
