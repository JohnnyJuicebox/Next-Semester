from bs4 import BeautifulSoup
import json
import requests
import sys

def clean_lst(lst):
	for index in range(0, len(lst)):
		data = lst[index].get_text();
		data = data.strip();
		data = data.encode('ascii', 'ignore');
		lst[index] = data;
	return None;
	
def retrieve_clean_text(lst, ind):
	data = lst[ind].get_text();	
	data = data.strip();
	return data;
	
def parse_course_schedule_subpage(url):

	# Make a request to the url and get the text of webpage
	# Turn that webpage into a BeautifulSoup object
	page = requests.get(url)
	soup = BeautifulSoup(page.text);
	
	tables = soup.find_all('table');	# Find all the table tags underneath the root dom object
	bolds = soup.find_all('b');			# Find all the bold tags underneath the root dom object
	
	lst = []; # Initialize an empty list

	# For each table in the tables array, find all trs in that table
	# As well as get the coursename for that table by getting a tag of bolds tag
	# Another for loop to go through rows 1 to length - 1 to get the tds for that row
	# Retrieve the relevant course information
	for t_index in range(0, len(tables)):
		
		trs = tables[t_index].find_all('tr');
		cname = bolds[t_index].a['name'];
		
		# For each row from row 1 to n -1 rows not including row 0
		# Initialize the dictionary object and store the course name
		# Then store all the scraped course info for the particular page	
		for index in range(1, len(trs)):
			
			tds = trs[index].find_all('td');
			cinfo = cname;
			dct = {};
			clean_lst(tds);
				
			dct['courseName'] 		= cname;
			dct['sectionNum'] 		= tds[0];
			dct['callNumber'] 		= tds[1];
			dct['days'] 	  		= tds[2];
			dct['times'] 	  		= tds[3];
			dct['roomNo'] 	  		= tds[4];
			dct['status']     		= tds[5];
			dct['max'] 				= tds[6];
			dct['now'] 				= tds[7];
			dct['instructorName'] 	= tds[8];
			dct['credits'] 			= tds[10];

			days = dct['days'].split();	
			daysLen = len(days);
			
			dInfo = {};	

			if(daysLen == 0):
				daysInfo = '';
				times = dct['times'];
				rooms = dct['roomNo'];
				
				del dct['days'];			
				del dct['times'];			
				del dct['roomNo'];

				dlst = [];

				dInfo['day'] = daysInfo;
				dInfo['time'] = times;
				dInfo['roomNo'] = rooms;
		
				dlst.append(dInfo);	
				dct['dayTimesInfo'] = dlst;
				
			elif(daysLen == 1):
				
				daysInfo = days[0];
				times = dct['times'];
				rooms = dct['roomNo'];
				
				del dct['days'];			
				del dct['times'];			
				del dct['roomNo'];
		
				dlst = [];

				dInfo['day'] = daysInfo;
				dInfo['time'] = times;
				dInfo['roomNo'] = rooms;
				
				dlst.append(dInfo);	
				
				dct['dayTimesInfo'] = dlst;

			elif(daysLen >= 2):
				
				times = dct['times'].split("  ");
				rooms = dct['roomNo'].split("    ");
				
				dlst = [];
				
				for d_index in range(0, len(days)):
						
					dInfo['day'] = days[d_index];
					
					if(daysLen == len(times)):
						dInfo['time'] = times[d_index];
					else:
						dInfo['time'] = '';

					if(daysLen == len(rooms)):
						dInfo['roomInfo'] = rooms[d_index];
					else:
						dInfo['roomInfo'] = '';
		
					dlst.append(dInfo);
					dInfo = {};

				del dct['days'];
				del dct['times'];
				del dct['roomNo'];
				

				dct['dayTimesInfo'] = dlst;
			
			lst.append(dct);

	return lst;


def main():
	
	url = 'http://www.njit.edu/registrar/schedules/courses/spring/2015S.';

	if(len(sys.argv) == 1):
		print 'Error: Need one command line argument';
		sys.exit(1);
	subject = sys.argv[1];
	url = url + subject + '.html';
	lst = parse_course_schedule_subpage(url);
	dct = { 'Info' : lst , 'Subject' : 'CS'};
	print json.dumps(dct, indent = 2);
	return;

if __name__ == '__main__':
	main()
