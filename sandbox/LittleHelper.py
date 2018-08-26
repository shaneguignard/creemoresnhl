from html.parser import HTMLParser
#Defines an array which can be used to store tag and content information
htmlArray = []
#Class that makes use of the HTMLParser scripts
class htmlParser(HTMLParser):
    #function that handles opening tags
    def handle_starttag(self, tag, attrs):
        #Append tag name to htmlArray
        htmlArray.append(tag)

    #Function which handles the content between tags  
    def handle_data(self, data):
        #Append contents to htmlArray
        htmlArray.append("My Content: "+data+"End Content")

    #function that handles closing tags 
    def handle_endtag(self, tag):
        tag = '/'+tag
        #Append contents to htmlArray
        htmlArray.append(tag)
    
#define parser as new variable "p"
p = htmlParser()

#open file from folder (File of interest)
f = open("htmlparsertest.html")
#take file contents (text) and assign them to a variable
html = f.read()
#Close the connection to the file
f.close()

#Read Html File
p.feed(html)
a = ""
b = "','"
def writeDatabase():
    i = 0
    j = 0
    while i <len(htmlArray):
        ca = list(htmlArray[i])

        while j < len(ca):
            if ca[j] == '\n' or ca[j] == '\n\t' or ca[j]=='\t':
                print("removed new line character at", i,j)
                ca.remove(ca[j])
            else:
               j += 1
        
        ca = a.join(ca)

        f = open('outputtest.json', 'a')
        f.write(ca)
        i += 1
 
    f.close()
    
writeDatabase()
#htmlArray = b.join(htmlArray)
testoutput = open('outputtest.json', 'r').read()
erase = open('outputtest.json','w').write('')

    
