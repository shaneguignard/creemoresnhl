p = readtable("allPlayers.txt")
p = sortrows(p, 'name')


sp = readtable("allPlayers_sorted.txt")

t = table()
t.name = unique(sp.name)
