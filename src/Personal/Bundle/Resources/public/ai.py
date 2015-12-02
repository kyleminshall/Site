import smtplib
import email
import sys, json
from bs4 import BeautifulSoup
from bs4 import SoupStrainer
import urllib2

url = urllib2.Request("http://138.23.12.141/foodpro/shortmenu.asp?sName=University+of+California%2C+Riverside+Dining+Services&locationNum=03&locationName=A+-+I+Residential+Restaurant&naFlag=1")
page = urllib2.urlopen(url)
soup = BeautifulSoup(page.read())

menu = ""

container = soup.find('div', class_='shortmenutitle').find_next_sibling('table').tr
for td in container.find_all('td', recursive=False):
    title = td.find('div', class_='shortmenumeals')

    menu += title.text.strip()+"\n\n"
    for item in td.table.find_all('tr', recursive=False)[1].table.find_all('tr', recursive=False):
        menu += item.text.strip()+"\n"
    menu += "\n"

#print menu

sender = 'kilenaitor@gmail.com'
receivers = json.loads(sys.argv[1])

message = """From: A&I Menu <from@fromdomain.com>
To: Undisclosed Recipients <to@todomain.com>
Subject: A&I Menu"""

message += "\n\n"+menu


try:
    smtpserver = smtplib.SMTP("smtp.gmail.com", 587)
    smtpserver.ehlo()
    smtpserver.starttls()
    smtpserver.ehlo()
    smtpserver.login('kilenaitor@gmail.com', 'NICE TRY. NO PASSWORD FOR YOU.')
    smtpserver.sendmail(sender, receivers, message.encode('utf-8').strip())
    
except Exception as e:
    print e
    print "Error: unable to send email"
