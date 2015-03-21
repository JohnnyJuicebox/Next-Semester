from bs4 import BeautifulSoup;
from bs4 import element;
import requests
import json
#import sys

url = 'http://catalog.njit.edu/undergraduate/programs/computerscience.php';
req = requests.get(url);

soup = BeautifulSoup(req.text);

courselst = []
mainlst = []

spanlst = soup.find_all('span');

for span in spanlst:
	if(span.has_attr('class')):
		if(span['class'][0] == 'degreeTitle'):
			dct = {};
			courselst = []
			if(span.contents):
				for sp in span.contents:
					if(type(sp) is element.NavigableString):
						dct['degreeTitle'] = sp;
						dct['degreeCourses'] = courselst;
				mainlst.append(dct);
		elif(span['class'][0] == 'noDisplay'):
			if(span.contents):
				if(type(span.contents[0]) is element.NavigableString):
					courselst.append(span.contents[0]);


print json.dumps(mainlst, indent=2)

