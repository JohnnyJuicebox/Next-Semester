from lxml import html
import requests

page = requests.get('http://www.njit.edu/registrar/schedules/courses/spring/index_list.html')

tree = html.fromstring(page.text)

url = tree.xpath('//a/@href')
text = tree.xpath('//a/text()')

print 'URLs: ', url

print 'Text: ', text