disp('Import Players');
p = readtable('allPlayers.csv');
p.team = string(p.team).lower();
p(isnan(p.num), 'num') = {0.999};
p(isnan(p.g), 'g') = {0};
p(isnan(p.a), 'a') = {0};
p(isnan(p.pts), 'pts') = {0};
p(isnan(p.pim), 'pim') = {0};
p.name = strtrim(p.name);
p = table2timetable(p);

% date, number, name, team, goals, assists, points, penalty Mins

np = table();
np.date = newGame.date;
np.num = double(string(b(:,1)));
np.name = b(:,2);
np.team = newGame.team;
np.g = single(newGame.type == 'goal');
np.a = single(newGame.type == 'assist');
np.pts = single((newGame.type == 'goal')*2 + (newGame.type == 'assist'));
np.pim = single(newGame.type == 'penalty');
np = table2timetable(np);


% Merge p and newGame timetables
p = [p;np];
sortrows(p, 'date');

t = table();
t.name = unique(p.name);
[t.first,t.last] = strtok(t.name);  % Splits name string into first name and last name
t.name = string(t.name);
t.first = string(t.first);
t.last = string(t.last);
t.last = strtrim(t.last);

p = timetable2table(p);
i = 1;
while(i <= length(t.name))
    % Names
    temp = p(p.name == t.name(i), :);
    temp.team = string(temp.team);
    temp = sortrows(temp, 'date');
    cteam = temp.team(end);
    cteam = strrep(cteam, ' ','');
    t.currentTeam(i) = cteam.lower();
    t.num(i) = max(temp.num);
    t.lastModified(i) = year(temp.date(end));
    % Goals
    t.totalGoals(i) = sum(temp.g);
    t.bestYearGoals(i) = {temp(temp.g == max(temp.g), 'date')}; 
    t.mostGoals(i) = max(temp.g);
    t.worstYearGoals(i) = {temp(temp.g == min(temp.g), 'date')};
    t.leastGoals(i) = min(temp.g);
    t.avgGoals(i) = mean(temp.g);
    % Assists
    t.totalAssists(i) = sum(temp.a);
    t.bestYearAssists(i) = {temp(temp.a == max(temp.a), 'date')};
    t.mostAssists(i) = max(temp.a);
    t.worstYearAssists(i) = {temp(temp.a == min(temp.a), 'date')};
    t.leastAssists(i) = min(temp.a);
    t.avgAssists(i) = mean(temp.a);
    % Points
    t.totalPoints(i) = sum(temp.pts);
    t.bestYearPoints(i) = {temp(temp.pts == max(temp.pts), 'date')};
    t.mostPoints(i) = max(temp.pts);
    t.worstYearPoints(i) = {temp(temp.pts == min(temp.pts), 'date')};
    t.leastPoints(i) = min(temp.pts);
    t.avgPoints(i) = mean(temp.pts);
    % Penalties in Mins
    t.totalPenaltyMins(i) = sum(temp.pim);
    t.mostAggressiveYear(i) = {temp(temp.pim == max(temp.pim), 'date')};
    t.mostPIM(i) = max(temp.pim);
    t.leastAggressiveYear(i) = {temp(temp.pim == min(temp.pim), 'date')};
    t.leastPIM(i) = min(temp.pim);
    t.avgPIM(i) = sum(temp.pim)/length(temp.pim);
    % Membership
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
disp('Complete');

disp('Export Js');
jsonPlayers = jsonencode(t);
jsCat = cat(2, 'var league = ', jsonPlayers);
fid = fopen('leagueSummary.js', 'w');
fwrite(fid, jsCat, 'char');
fclose(fid);
disp('Complete');


% CREATE INDIVIDUAL PLAYERS TABLES BY YEAR


% CREATE AWARDS TABLE