#import necessary libraries
#!/usr/bin/python
import xlrd
import time

#Establish a connection with Excel File
book = xlrd.open_workbook('StatsMaster.xlsx')

#Create variables for worksheets withing workbook
playerStats = book.sheet_by_index(0)
teamStats = book.sheet_by_index(1)
rrteamStats = book.sheet_by_index(2)
gameStats = book.sheet_by_index(3)

#Create Variables for Cells within Worksheets
pcell = playerStats.cell_value  #Player Stats
tcell = teamStats.cell_value    #Team Standings
rcell = rrteamStats.cell_value  #Round Robin Standings
gcell = gameStats.cell_value    #Game Stats


#######PLAYER STATISTICS###########

#Declair variables as arrays
statsR = []

#Increment through playerStats workSheet and Create array of values
for rx in range(playerStats.nrows):
    statsC = []
    for cx in range(playerStats.ncols): 
        statsC.append(cx)
        try:
            statsC[cx]=('"'+str(pcell(rowx=0, colx=cx))+'":"'+str(int(pcell(rowx=rx, colx=cx)))+'"')
        except:
            statsC[cx]=('"'+str(pcell(rowx=0, colx=cx))+'":"'+str(pcell(rowx=rx, colx=cx))+'"')
            
    statsC = ','.join(statsC)
    statsR.append(rx)
    statsR[rx] = '{'+statsC+'}'
    
stats = ',\n'.join(statsR)
stats = '['+stats+']'

#Write Json Database to a file
f = open('data/stats.json','w')
f.write(stats)
f.close()

#Notify User
print('Stats database Updated')


#######TEAM STATISTICS###########


#Declair Team Stats Array
teamstatsR = []

#Increment through teamStats worksheet and create array of values
for rx in range(teamStats.nrows):
    teamstatsC = []
    for cx in range(teamStats.ncols):
        teamstatsC.append(cx)
        try:
            teamstatsC[cx]=('"'+str(tcell(rowx=0, colx=cx))+'":"'+str(int(tcell(rowx=rx, colx=cx)))+'"')
        except:
            teamstatsC[cx]=('"'+str(tcell(rowx=0, colx=cx))+'":"'+str(tcell(rowx=rx, colx=cx))+'"')
            
    teamstatsC = ','.join(teamstatsC)
    teamstatsR.append(rx)
    teamstatsR[rx] = '{'+teamstatsC+'}'
    
#Format Array to look like Json Database file
teamstats = ',\n'.join(teamstatsR)
teamstats = '['+teamstats+']'

#Write Json Database to a file
f = open('data/teamstats.json','w')
f.write(teamstats)
f.close()

#Notify User
print('Team Stats Database updated')



#######ROUND ROBIN TEAM STATISTICS###########

#Declair Team Stats Array
rrteamstatsR = []

#Increment through rrteamStats worksheet and create array of values
for rx in range(rrteamStats.nrows):
    rrteamstatsC = []
    for cx in range(rrteamStats.ncols):
        rrteamstatsC.append(cx)
        try:
            rrteamstatsC[cx]=('"'+str(rcell(rowx=0, colx=cx))+'":"'+str(int(rcell(rowx=rx, colx=cx)))+'"')
        except:
            rrteamstatsC[cx]=('"'+str(rcell(rowx=0, colx=cx))+'":"'+str(rcell(rowx=rx, colx=cx))+'"')
            
    rrteamstatsC = ','.join(rrteamstatsC)
    rrteamstatsR.append(rx)
    rrteamstatsR[rx] = '{'+rrteamstatsC+'}'
    
#Format Array to look like Json Database file
rrteamstats = ',\n'.join(rrteamstatsR)
rrteamstats = '['+rrteamstats+']'

#Write Json Database to a file
f = open('data/rrteamstats.json','w')
f.write(rrteamstats)
f.close()

#Notify User
print('Round Robin Team Stats Database updated')



#######GAME STATISTICS###########

#declair row array
gstatsR=[]
#Increment through gameStats worksheet and create array of values
for rx in range(gameStats.nrows):
    gstatsC=[]
    for cx in range(gameStats.ncols):
        gstatsC.append(cx)
        try:
            gstatsC[cx]=('"'+str(int(gcell(rowx=rx, colx=cx)))+'"')
        except:
            gstatsC[cx]=('"'+str(gcell(rowx=rx, colx=cx))+'"')

    gstatsC = ','.join(gstatsC)
    gstatsR.append(rx)
    gstatsR[rx] = '['+gstatsC+']'

#Formate Array to look like Json Database file
gstats = ',\n'.join(gstatsR)
gstats = '['+gstats+']'

#Write Json Database to a file
f = open('data/gamestats.json','w')
f.write(gstats)
f.close()

#Notify User
print('Game Stats Database updated')
    
            


#######STATS LOG###########

#Set Date
today = time.strftime('%d-%m-%y')

logStatsR = []
#Increment through playerStats workSheet and Create array of values

for rx in range(playerStats.nrows):
    
    logStatsC = []
    for cx in range(playerStats.ncols): 
        logStatsC.append(cx)
        try:
            logStatsC[cx]=(str(pcell(rowx=0, colx=cx))+':'+str(int(pcell(rowx=rx, colx=cx))))
        except:
            logStatsC[cx]=(str(pcell(rowx=0, colx=cx))+':'+str(pcell(rowx=rx, colx=cx)))
       
    logStatsC = '\n'.join(logStatsC)
    logStatsR.append(rx)
    logStatsR[rx] = logStatsC

del logStatsR[0]
logStats = '\n\n'.join(logStatsR)


#Declair Team Stats Array
logteamstatsR = []
#Increment through teamStats worksheet and create array of values
for rx in range(teamStats.nrows):
    logteamstatsC = []
    for cx in range(teamStats.ncols):
        logteamstatsC.append(cx)
        try:
            logteamstatsC[cx]=(str(int(tcell(rowx=rx, colx=cx))))
        except:
            logteamstatsC[cx]=(str(tcell(rowx=rx, colx=cx)))
            
    logteamstatsC = '\t'.join(logteamstatsC)
    logteamstatsR.append(rx)
    logteamstatsR[rx] = logteamstatsC
    
#Format Array to look like Json Database file
logteamstats = '\n'.join(logteamstatsR)




f = open('logs/'+today+'.txt','w')
f.write(logStats+'\n\n'+logteamstats)
f.close()

print('Update Log Created')




