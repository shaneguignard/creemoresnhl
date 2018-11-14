disp('Import Players');
p = readtable('allPlayers.csv');
p.name = strtrim(p.name);
t = table();
t.name = unique(p.name);
[t.first,t.last] = strtok(t.name);  %splits name string into first name and last name
t.name = string(t.name);
t.first = string(t.first);
t.last = string(t.last);
t.last = strtrim(t.last);

i = 1;
while(i <= length(t.name))
    temp = p(p.name == t.name(i), :);
    temp.team = string(temp.team);
    temp = sortrows(temp, 'date');
    t.totalGoals(i) = sum(temp.g);
    t.totalAssists(i) = sum(temp.a);
    t.totalPoints(i) = sum(temp.pts);
    t.totalPenaltyMins(i) = sum(temp.pim);
    t.avgPoints(i) = sum(temp.pts)/length(temp.pts);
    t.avgPIM(i) = sum(temp.pim)/length(temp.pim);
    t.joined(i) = temp.date(1) - 1;
    t.yearsPlayed(i) = length(temp.name);
    t.belarus(i) = height(temp(temp.team == "Belarus", :));
    t.stayner(i) = height(temp(temp.team == "Stayner", :));
    t.garner(i) = height(temp(temp.team == "Garner", :));
    t.herbtown(i) = height(temp(temp.team == "Herbtown", :));
    t.newlowell(i) = height(temp(temp.team == "New Lowell", :));
    t.cashtown(i) = height(temp(temp.team == "Cashtown", :));
    t.coatescreek(i) = height(temp(temp.team == "Coates Creek", :));
    i = i + 1;
end

disp(t);
disp('Export Players');
writetable(t, 'LeagueSummary.csv');

% CREATE INDIVIDUAL PLAYERS TABLES BY YEAR


% CREATE AWARDS TABLE