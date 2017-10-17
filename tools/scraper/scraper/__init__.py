from lxml import html
import requests

__author__ = "Rohan"
__date__ = "$May 14, 2015 12:04:05 AM$"

page = requests.get('http://econpy.pythonanywhere.com/ex/001.html')
tree = html.fromstring(page.text)
