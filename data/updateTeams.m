%Download games history.csv
disp('Load games file');
%games = readtable('newGames.csv');
history = readtable('history.csv');
teamStats = readtable('teamStats.csv');


% ADD NEW GAMES TO HISTORY



%Upload games history
disp('Update games history');
writetable(history, 'history.csv');

%update teamStats
disp('Update teamStats')
history.team = string(history.team);
history.type = categorical(history.type);
teams = unique(history.team);
for i = 1: length(teams)
teamGoals(i) = height(history(history.team == teams(i) & history.type == 'goal', 'team'));
temp = history(history.team == teams(i), :);
teamGames(i) = length(unique(temp.date));%height of table produced by unique game dates played by specific team
end

% tempgame = history(history.date == date(1), :);
% gameteams = unique(tempgame.team);
% teamStats = [teamStats, table(0, 'VariableNames', {[char(gameteams(2))]})]



totalGoals = sum(teamGoals);
shutouts = height(history(history.type == 'null', 'type'));
totalGames = length(unique(history.date));

teamStats.teams = teams;
teamStats.totalGoals = teamGoals';
teamStats.totalGames = teamGames';
% Total assist
% Total penalty mins
% Total points
% Average points per season
% Average goals per season
% Average assists per season
% Average penalty minutes per season

disp(teamStats);

%write to teamStats.txt
writetable(teamStats, 'teamStats.csv');
disp('Team stats updated.') 
disp('History updated')
