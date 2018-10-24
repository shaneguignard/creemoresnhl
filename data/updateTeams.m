%Download games history.csv
disp('Load games file');
%games = readtable('newGames.csv');
history = readtable('history.csv');
teamStats = readtable('teamStats.txt');
% ADD NEW GAMES TO HISTORY


games.team = string(games.team);
games.type = categorical(games.type);
games(games.team == "", :) = [];
games(games.team == "coatscreek", 'team') = {"coatescreek"};
disp(games)

%Upload games history
disp('Update games history');
writetable(games, 'games.csv');
writetable(history, 'history.csv');

%update teamStats
disp('Update teamStats')
teams = unique(games.team);
for i = 1: length(teams)
teamGoals(i) = height(games(games.team == teams(i) & games.type == 'goal', 'team'));
temp = games(games.team == teams(i), :);
teamGames(i) = length(unique(temp.date));%height of table produced by unique game dates played by specific team
end

tempgame = history(history.date == gameDate(1), :);
gameteams = unique(tempgame.team);
teamStats = [teamStats, table(0, 'VariableNames', {[char(gameteams(2))]})]



totalGoals = sum(teamGoals);
shutouts = height(games(games.type == 'null', 'type'));
totalGames = length(unique(games.date));

teamStats.teams = teams;
teamStats.teamGoals = teamGoals';
teamStats.teamGames = teamGames';


disp(teamStats);

%write to teamStats.txt
writetable(teamStats, 'teamStats.txt');
disp('Team stats updated.') 
