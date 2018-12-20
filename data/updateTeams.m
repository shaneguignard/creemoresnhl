% Download games history.csv
disp('Load history file');
history = readtable('history.csv');
% teamStats = readtable('teamStats.csv');


% ADD NEW GAMES TO HISTORY
% Export from scoresheet.html (php to generate file)
% Import file
% newGame = readtable('newGame.csv');
% use specific data to update Players
% use specific data to update Teams
% Merge newGame table to history table

%Upload games history
disp('Update games history');
writetable(history, 'history.csv');

%update teamStats
disp('Update teamStats')
history.team = string(history.team);
history.type = categorical(history.type);
teams = unique(history.team);

% Define array variables
teamGoals = zeros(1, length(teams));
teamBestGame = zeros(1, length(teams));
%teamBestGameDate = zeros(1, length(teams));
teamBestYear = zeros(1, length(teams));
%teamBestYearDate = zeros(1, length(teams));
teamWorstGame = zeros(1, length(teams));
%teamWorstGameDate = zeros(1, length(teams));
teamWorstYear = zeros(1, length(teams));
%teamWorstYearDate =zeros(1, length(teams));
teamGames = zeros(1, length(teams));


for i = 1: length(teams)
temp = history(history.team == teams(i), :);
teamGoals(i) = height(temp(temp.type == 'goal', 'team'));
uniqueDates = unique(temp.date);
games = zeros(1,length(uniqueDates));
uniqueYears = unique(year(temp.date));
years = zeros(1, length(uniqueYears));
for j = 1:length(uniqueDates)
    games(j) = height(temp(temp.date == uniqueDates(j) & temp.type == 'goal', 'type'));
end
for k = 1: length(uniqueYears)
    years(k) = height(temp(year(temp.date) == uniqueYears(k) & temp.type == 'goal', 'type'));
end
gameSums = table(uniqueDates, games')
yearSums = table(uniqueYears, years')

% Best Game
teamBestGame(i) = max(gameSums.Var2);
teamBestGameDate(i) = {gameSums(gameSums.Var2 == max(gameSums.Var2), 'uniqueDates')};
% Best Year
teamBestYear(i) = max(yearSums.Var2); % outputs last year played not year with most points
teamBestYearDate(i) = {yearSums(yearSums.Var2 == max(yearSums.Var2), 'uniqueYears')};

avgSeasonGoals(i) = mean(yearSums.Var2);
% Worst Game
teamWorstGame(i) = min(gameSums.Var2);
teamWorstGameDate(i) = {gameSums(gameSums.Var2 == min(gameSums.Var2), 'uniqueDates')};
% Worst Year
teamWorstYear(i) = min(yearSums.Var2); % outputs last year played not year with most points
teamWorstYearDate(i) = {yearSums(yearSums.Var2 == min(yearSums.Var2), 'uniqueYears')};

teamGames(i) = length(unique(temp.date)); % height of table produced by unique game dates played by specific team
end

% tempgame = history(history.date == date(1), :);
% gameteams = unique(tempgame.team);
% teamStats = [teamStats, table(0, 'VariableNames', {[char(gameteams(2))]})]

totalGoals = sum(teamGoals);
shutouts = height(history(history.type == 'null', 'type'));
totalGames = length(unique(history.date));

teamStats = table();
teamStats.teams = teams;
teamStats.totalGames = teamGames';
teamStats.totalGoals = teamGoals';
% Average goals per season
teamStats.avgGameGoals = (teamStats.totalGoals ./ teamStats.totalGames);
teamStats.avgSeasonGoals = avgSeasonGoals';
teamStats.bestGame = teamBestGame';
teamStats.bestGameDate = teamBestGameDate';
% teamStats.bestGameDate{1,1} to view first date in bestGameDate array
teamStats.bestYear = teamBestYear';
teamStats.bestYearDate = teamBestYearDate';
teamStats.worstGame = teamWorstGame';
teamStats.worstGameDate = teamWorstGameDate';
teamStats.worstYear = teamWorstYear';
teamStats.worstYearDate = teamWorstYearDate';

% Total assist
% Total penalty mins
% Total points
% Average points per season
% Average assists per season
% Average penalty minutes per season

disp(teamStats);

%write to teamStats.txt
writetable(teamStats, 'teamStats.csv');


disp('Team stats updated.');
disp('Export TeamStats as Js variable');
jsonTeams = jsonencode(teamStats);
jsCat = cat(2, 'var teamStats = ', jsonTeams);
fid = fopen('teamStats.js', 'w');
fwrite(fid, jsCat, 'char');
fclose(fid);
disp('Update teamStats.js');
disp('History updated');
