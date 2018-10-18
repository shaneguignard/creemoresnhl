

games.team = string(games.team);
games.type = categorical(games.type);
games(games.team == "", :) = [];
games(games.team == "coatscreek", 'team') = {"coatescreek"};

totalGoals = height(games(games.type == 'goal', 'type'));
shutouts = height(games(games.type == 'null', 'type'));
totalGames = length(unique(games.date));


games = readtable('games.csv');
teams = unique(games.team)
for i = 1: length(teams)
teamGoals(i) = height(games(games.team == teams(i) & games.type == 'goal', 'team'));
end