from bs4 import BeautifulSoup
from bs4 import SoupStrainer
import requests
import urllib

url = 'https://pixeljumpstudios.com'
base = 'pixeljumpstudios.com'

urls = [url]
visited = []

response = requests.get(url)

soup = BeautifulSoup(response.content)

# Lets go crawl
while len(urls) > 0:
    
    print('Visiting ' + urls[0] + '\n')
    
    if urls[0] in visited:
        print('Been here done that \n')
        urls.pop(0)
    else:
        page = requests.get(urls[0])
        visited.append(urls[0])

        #find out if this is a listing page
        print('Finding out if this is a product/listing page \n')
        
        #It is so!
        #Listing Finds
		
        #Product ID
        #Listing ID
        #Store ID
        #Listing Condition
        #        Brand New, Second Hand
        #Listing In Stock
        #Listing Stock Out Date
        #        The Date The Item Was Listed Out of Stock
        #Listing Product URL
        #Listing Image URL
        #Listing Region
        #Listing City
        #Listing Address
        #Listing Contact Number
        #Listing Contact
        #Listing Date
        #Listing Expiry Date
        #Listing Price
        #Listing Description
        #Listing Shipping Methods
        #Listing Payment Methods
        
        #It isn't
        print('It is not \n')
                
        
        print('Now finding all links within this domain \n')

        tomato_soup = BeautifulSoup(page.content)

        tomato_links = tomato_soup.find_all('a')
        # Iterate over all links
        for link in tomato_links:
            if base in link['href']:
                if (link['href'] in visited) | (link['href'] in urls):
                    print('Been here done that \n')
                else:
                    urls.append(link['href'])

        print('URLS Visted: \n')
        print(len(visited))
        print('URLS Queued: \n')
        print(len(urls))
        print('------------------------------------------------- \n\n')

        urls.pop(0)

    
print("We are all done here")    
# Functions


def determineIfListing(url, listingMarker):
    isListing = false
    return isListing
