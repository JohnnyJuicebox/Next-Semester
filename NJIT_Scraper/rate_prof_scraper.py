import requests
import json
import time

# NJIT SCHOOL PAGE
#http://www.ratemyprofessors.com/campusRatings.jsp?sid=668
#
# LIST ALL PROFESSORS
#http://www.ratemyprofessors.com/search.jsp?queryBy=schoolId&schoolName=New+Jersey+Institute+of+Technology&sid=668&queryoption=TEACHER&dept=
#
# GET REQUEST FOR MORE PROFESSORS IN JSON FORM WHERE &page is the iterator
#http://www.ratemyprofessors.com/find/professor/?department=&institution=New+Jersey+Institute+of+Technology&page=2&query=*%3A*&queryoption=TEACHER&queryBy=schoolId&sid=668&sortBy=
#http://www.ratemyprofessors.com/find/professor/?queryoption=TEACHER&page=1&sortBy=&sid=668&department=&query=%2A%253A%2A&queryBy=schoolId&institution=New%2BJersey%2BInstitute%2Bof%2BTechnology


pageNum = 53

professorList = []
url = "http://www.ratemyprofessors.com/find/professor/?department=&"
url += "institution=New+Jersey+Institute+of+Technology&query=*%3A*"
url += "&queryoption=TEACHER&queryBy=schoolId&sid=668&sortBy=";

#Loops through all the pages of professors
while True:
	payload = {'page': pageNum} #Inserts page parameter for get request

	#Requests page texts into object
	r = requests.get(url, params=payload)

	#Decodes object into json data
	j = r.json()

	for entry in j['professors']:
		professorDict = {}
		professorDict['tDept'] = entry['tDept']
		professorDict['tFname'] = entry['tFname']
		professorDict['tLname'] = entry['tLname']
		professorDict['tid'] = entry['tid']
		professorDict['overall_rating'] = entry['overall_rating']
		professorList.append(professorDict)

	#Finds end of entries
	if j['remaining'] == 0:
	#	print(" No more entries left ")
		break

	#Delay to give the ratemyprofessor servers a break
	time.sleep(5)
#	print (" sleeping for 5 seconds ")

	pageNum += 1 #Increment page number
profList = json.dumps(professorList)
print json.dumps(professorList, indent=2);
