from bs4 import BeautifulSoup
from bs4 import element
import json
import requests
import sys

url = 'http://catalog.njit.edu/undergraduate/programs/computerscience.php';
req = requests.get(url);

soup = BeautifulSoup(req.text);
spanlst = soup.find_all('span');

for span in spanlst:
	if(span.has_attr('class')):
		if(span['class'][0] == 'degreeTitle'):
			if(span.contents):
				for sp in span.contents:
					if(type(sp) is element.NavigableString):
						print sp
		elif(span['class'][0] == 'noDisplay'):
			if(span.contents):
				if(type(span.contents[0]) is element.NavigableString):
					print span.contents[0]
