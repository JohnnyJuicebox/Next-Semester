from bs4 import BeautifulSoup
import json
import requests
import sys
import time

def get_subject_list(url):
	req = requests.get(url);
	soup = BeautifulSoup(req.text);

	atags = soup.find_all("a");
	subjectLst = [];
	for atag in atags:
		if(atag.has_attr("href")):
			subjectLst.append(atag["href"]);

	return subjectLst;

def clean_lst(lst):
    for index in range(0, len(lst)):
        data = lst[index].get_text();
        data = data.strip();
        data = data.encode('ascii', 'ignore');
        lst[index] = data;
    return None;

def remove_white_spaces(s):
    temp = '';
    for index in range(0, len(s)):
        if(s[index] != ' '):
            temp = temp + s[index];
    return temp;

def retrieve_clean_text(lst, ind):
    data = lst[ind].get_text();
    data = data.strip();
    return data;

def twelve_to_twenty_four(s):
    if(len(s) == 0):
        return '';
    time = int(s[:len(s)-2])
    ampm = s[len(s)-2:]
    if(ampm == 'pm' and not(time >= 1200 and time <= 1259)):
        time = time + 1200
    if(time < 1000):
        time = "0" + str(time)
    else:
        time = str(time)
    realTime = time[:len(time)-2] + ":" + time[len(time)-2:] + ":" + "00";
    return realTime;

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
        cdesc = bolds[t_index].u.get_text().strip();

        # For each row from row 1 to n -1 rows not including row 0
        # Initialize the dictionary object and store the course name
        # Then store all the scraped course info for the particular page
        for index in range(1, len(trs)):

            tds = trs[index].find_all('td');
            dct = {};
            clean_lst(tds);

            dct['courseName'] 		= cname;
            dct['courseDesc']       = cdesc.capitalize();
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
                dInfo['time'] = remove_white_spaces(times);
                dInfo['roomInfo'] = rooms;
                tempTime = dInfo['time'];
                tempTimeLst = tempTime.split("-");
                if(len(tempTimeLst) == 2):
                    startTime = twelve_to_twenty_four(tempTimeLst[0]);
                    endTime = twelve_to_twenty_four(tempTimeLst[1]);
                    del dInfo['time'];
                    dInfo['startTime'] = startTime;
                    dInfo['endTime'] = endTime;
                else:
                    del dInfo['time'];


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
                dInfo['time'] = remove_white_spaces(times);
                dInfo['roomInfo'] = rooms;
                tempTime = dInfo['time'];
                tempTimeLst = tempTime.split("-");
                if(len(tempTimeLst) == 2):
                    startTime = twelve_to_twenty_four(tempTimeLst[0]);
                    endTime = twelve_to_twenty_four(tempTimeLst[1]);
                    del dInfo['time'];
                    dInfo['startTime'] = startTime;
                    dInfo['endTime'] = endTime;
                else:
                    del dInfo['time'];
                dlst.append(dInfo);

                dct['dayTimesInfo'] = dlst;

            elif(daysLen >= 2):

                times = dct['times'].split("  ");
                rooms = dct['roomNo'].split("    ");

                dlst = [];

                for d_index in range(0, len(days)):

                    dInfo['day'] = days[d_index];

                    if(daysLen == len(times)):
                        dInfo['time'] = remove_white_spaces(times[d_index]);
                    else:
                        dInfo['time'] = '';

                    if(daysLen == len(rooms)):
                        dInfo['roomInfo'] = rooms[d_index];
                    else:
                        dInfo['roomInfo'] = '';
                    tempTime = dInfo['time'];
                    tempTimeLst = tempTime.split("-");
                    if(len(tempTimeLst) == 2):
                        startTime = twelve_to_twenty_four(tempTimeLst[0]);
                        endTime = twelve_to_twenty_four(tempTimeLst[1]);
                        del dInfo['time'];
                        dInfo['startTime'] = startTime;
                        dInfo['endTime'] = endTime;
                    else:
                        del dInfo['time'];
                    dlst.append(dInfo);
                    dInfo = {};

                del dct['days'];
                del dct['times'];
                del dct['roomNo'];


                dct['dayTimesInfo'] = dlst;

            lst.append(dct);

    return lst;


def main():

    url = 'http://www.njit.edu/registrar/schedules/courses/fall/index_list.html';
    homeUrl = 'http://www.njit.edu/registrar/schedules/courses/fall/';
    subjLst = get_subject_list(url);
    #if(len(sys.argv) == 1):
    #    print 'Error: Need one command line argument';
    #    sys.exit(1);
    #subject = sys.argv[1];
    #url = url + subject + '.html';

    for subj in subjLst:
		subjUrl = homeUrl + subj;
		lst = parse_course_schedule_subpage(subjUrl);
		subject = subj.split(".")[1];
		fold = "jsonFiles/";
		fname = fold + subject + ".json";
		f = open(fname, "w");
		f.write(json.dumps(lst));
		f.close();
		time.sleep(5);

    return;

if __name__ == '__main__':
    main()
