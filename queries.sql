/* Collection of MYSQL queries for CSNHL */

/* Generates a table of games with a unique ID, date, team, goals, assists, and penaltymins. */
/*
SET @row_number = 0;
DROP TABLE AllGames;
CREATE TABLE AllGames as
SELECT (@row_number := @row_number +1) AS id, 
date, 
team, 
goals, 
assists, 
penaltyMins, 
shots 
FROM 
(
    SELECT date, team, SUM(type = 'goal') AS goals, 
    SUM(type = 'assist') AS assists, 
    SUM(IF(type = 'penalty',2 ,0)) as penaltyMins, 
    SUM(type='shot') AS shots 
    FROM 
    (
        SELECT date_format(date, "%Y-%m-%d %H:00:00") AS date, 
        team, 
        type, 
        player 
        from events
    ) 
    as temp
    GROUP BY date, team
) 
as temp2;
*/

/* Produce a Unique primary key from id which auto increments when new rows are added */
/*
ALTER TABLE AllGames ADD PRIMARY KEY (id);
Alter TABLE AllGames CHANGE COLUMN id id int(10) AUTO_INCREMENT;
*/

/* Update AllGames Table */
INSERT INTO AllGames 
(
    date, 
    team, 
    goals, 
    assists, 
    penaltyMins, 
    shots
)
SELECT 
date, 
team, 
goals, 
assists, 
penaltyMins, 
shots 
FROM 
(
    SELECT 
    date, 
    team, 
    SUM(type = 'goal') AS goals, 
    SUM(type = 'assist') AS assists, 
    SUM(IF(type = 'penalty',2 ,0)) as penaltyMins, 
    SUM(type='shot') AS shots 
    FROM 
    (
        SELECT date_format(date, "%Y-%m-%d %H:00:00") AS date, 
        team, 
        type, 
        player 
        from Events
    ) 
    as temp 
    GROUP BY date, team
)
as temp2 
WHERE date > '2019-02-18';


/* Update history.Teams */

SET @row_number = 0;
DROP TABLE Teams;
CREATE TABLE Teams as
SELECT *, 
IF(goalsFor > goalsAgainst, 1, 0) AS win, 
IF(goalsFor < goalsAgainst, 1, 0) AS loss, 
IF(goalsFor = goalsAgainst, 1, 0) AS tie,
(goalsFor - goalsAgainst) AS diff FROM
(
    SELECT 
    MAX(CASE WHEN id % 2 = 1 THEN date END) AS date, 
    MAX(CASE WHEN id % 2 = 1 THEN team END) AS team, 
    MAX(CASE WHEN id % 2 = 0 THEN team END) AS opponent, 
    MAX(CASE WHEN id % 2 = 1 THEN goals END) AS goalsFor,
    MAX(CASE WHEN id % 2 = 0 THEN goals END) AS goalsAgainst,
    MAX(CASE WHEN id % 2 = 1 THEN assists END) AS assists,
    MAX(CASE WHEN id % 2 = 1 THEN shots END) AS shotsFor,
    MAX(CASE WHEN id % 2 = 0 THEN shots END) AS shotsAgainst,
    MAX(CASE WHEN id % 2 = 1 THEN penaltyMins END) AS penaltyMinsFor,
    MAX(CASE WHEN id % 2 = 0 THEN penaltyMins END) AS penaltyMinsAgainst
    FROM 
    (
        SELECT (@row_number := @row_number +1) AS id, 
date, 
team, 
goals, 
assists, 
penaltyMins, 
shots 
FROM 
(
    SELECT date, team, SUM(type = 'goal') AS goals, 
    SUM(type = 'assist') AS assists, 
    SUM(IF(type = 'penalty',2 ,0)) as penaltyMins, 
    SUM(type='shot') AS shots 
    FROM 
    (
        SELECT date_format(date, "%Y-%m-%d %H:00:00") AS date, 
        team, 
        type, 
        player 
        from Events
    ) 
    as temp
    GROUP BY date, team
) 
as temp2) as allgames
    GROUP BY floor((id+1)/2)
) as temp
UNION
SELECT *, 
IF(goalsFor > goalsAgainst, 1, 0) AS win, 
IF(goalsFor < goalsAgainst, 1, 0) AS loss, 
IF(goalsFor = goalsAgainst, 1, 0) AS tie,
(goalsFor - goalsAgainst) AS diff FROM
(
    SELECT
    MAX(CASE WHEN id % 2 = 0 THEN date END) AS date, 
    MAX(CASE WHEN id % 2 = 0 THEN team END) AS team,
    MAX(CASE WHEN id % 2 = 1 THEN team END) AS opponent, 
    MAX(CASE WHEN id % 2 = 0 THEN goals END) AS goalsFor,
    MAX(CASE WHEN id % 2 = 1 THEN goals END) AS goalsAgainst,
    MAX(CASE WHEN id % 2 = 0 THEN assists END) AS assists,
    MAX(CASE WHEN id % 2 = 0 THEN shots END) AS shotsFor,
    MAX(CASE WHEN id % 2 = 1 THEN shots END) AS shotsAgainst,
    MAX(CASE WHEN id % 2 = 0 THEN penaltyMins END) AS penaltyMinsFor,
    MAX(CASE WHEN id % 2 = 1 THEN penaltyMins END) AS penaltyMinsAgainst
    FROM 
    (
        SELECT (@row_number := @row_number +1) AS id, 
        date, 
        team, 
        goals, 
        assists, 
        penaltyMins, 
        shots 
        FROM 
        (
        SELECT date, 
        team, 
    SUM(type = 'goal') AS goals, 
    SUM(type = 'assist') AS assists, 
    SUM(IF(type = 'penalty',2 ,0)) as penaltyMins, 
    SUM(type='shot') AS shots 
    FROM 
    (
        SELECT date_format(date, "%Y-%m-%d %H:00:00") AS date, 
        team, 
        type, 
        player 
        from Events
    ) 
    as temp 
    GROUP BY date, team
) 
as temp2
    ) as allgames
    GROUP BY floor((id+1)/2)
) as temp2
ORDER BY date;

/* update  current.PastGames table */
DROP TABLE current.PastGames;
CREATE TABLE current.PastGames as
SELECT 
    MAX(CASE WHEN id % 2 = 1 THEN date END) AS date, 
    MAX(CASE WHEN id % 2 = 1 THEN team END) AS teamA, 
    MAX(CASE WHEN id % 2 = 0 THEN team END) AS teamB, 
    MAX(CASE WHEN id % 2 = 1 THEN goals END) AS goalsA,
    MAX(CASE WHEN id % 2 = 0 THEN goals END) AS goalsB,
    MAX(CASE WHEN id % 2 = 1 THEN shots END) AS shotsA,
    MAX(CASE WHEN id % 2 = 0 THEN shots END) AS shotsB,
    MAX(CASE WHEN id % 2 = 1 THEN penaltyMins END) AS penaltyMinsA,
    MAX(CASE WHEN id % 2 = 0 THEN penaltyMins END) AS penaltyMinsB
    FROM AllGames
    WHERE date > '2018-10-01' /* Beginning of the season */
    GROUP BY floor((id+1)/2);




/* Create current.regularStandings */ 
/* These should eventually just be an extention of the teams and players tables in history database using datelast modified as a key */
Drop table current.regularStandings;
create table current.regularStandings as 
Select 
team, 
(
    sum(team='belarus') + 
    sum(team='cashtown') + 
    sum(team='new lowell') + 
    sum(team='herbtown')+ 
    sum(team='stayner') + 
    sum(team='coates creek')
)
as gp,
sum(win =1) as w, 
sum(loss = 1) as l, 
sum(tie = 1) as t,
sum(if(win = 1, 2, 0) + if(tie = 1, 1, 0)) as pts,
sum(goalsFor) as gf,
sum(goalsAgainst) as ga,

sum(diff) as diff
from history.Teams 
where date > '2018-10-01' 
group by team;

/* Create current.roundrobinStandings */
Drop table current.roundrobinStandings;
create table current.roundrobinStandings as 
Select 
team, 
(
    sum(team='Belarus') + 
    sum(team='Cashtown') + 
    sum(team='New Lowell') + 
    sum(team='Herbtown')+ 
    sum(team='Stayner') + 
    sum(team='Coates Creek')
)
as gp,
sum(win =1) as w, 
sum(loss = 1) as l, 
sum(tie = 1) as t,
sum(if(win = 1, 2, 0) + if(tie = 1, 1, 0)) as pts,
sum(goalsFor) as gf,
sum(goalsAgainst) as ga,

sum(diff) as diff
from history.Teams 
where date > '2019-02-05' 
group by team;

/* Create league.Teams */
Select
team,  
(     
    sum(team='belarus') +
    sum(team='cashtown') +      
    sum(team='new lowell') +      
    sum(team='herbtown')+      
    sum(team='stayner')+
    sum(team='coates creek') 
) as gp, 
sum(win =1) as w,  
sum(loss = 1) as l,  
sum(tie = 1) as t, 
sum(if(win = 1, 2, 0) + if(tie = 1, 1, 0)) as pts, 
sum(goalsFor) as gf, 
sum(goalsAgainst) as ga,  
sum(diff) as diff from history.Games  
group by team;


/* Create history.tempPlayers */
DROP TABLE tempPlayers;
CREATE TABLE tempPlayers AS
select distinct 
date, 
player, 
sum(type='goal') as goals, 
sum(type='assist') as assists, 
sum(if(type='penalty', 2, 0)) as penaltyMin,
sum(if(type='goal', 1, 0)+ if(type='assist', 1, 0)) as points
from Events
where date > '2019-02-24'
group by date, player;


/* Update history.Players */
INSERT INTO Players
select distinct 
date,
player, 
team,
goals, 
assists, 
penaltyMin,
points
from 
(
    select distinct 
    date, 
    player,
    team,
    sum(type='goal') as goals, 
    sum(type='assist') as assists, 
    sum(if(type='penalty', 2, 0)) as penaltyMin,
    sum(if(type='goal', 1, 0)+ if(type='assist', 1, 0)) as points
    from Events
    where date > '2019-02-24'
    group by date, player, team
) 
as tempPlayers
where player <> 'null' AND player <> ""
group by date, player, team;

/* Merge existing player stats with new player stats and export as new table current.Players */
DROP TABLE Players_bak;
CREATE TABLE Players_bak as SELECT * FROM Players;
DROP TABLE Players;
CREATE TABLE nPlayers as SELECT * from Players;

CREATE TABLE Players AS
SELECT nPlayers.name, nPlayers.team, 
COALESCE(nPlayers.goals + history.tempPlayers.goals, nPlayers.goals) as goals, 
COALESCE(nPlayers.assists + history.tempPlayers.assists, nPlayers.assists) as assists,
COALESCE(nPlayers.penaltyMin + history.tempPlayers.penaltyMin, nPlayers.penaltyMin) as penaltyMin,
COALESCE(nPlayers.points + history.tempPlayers.points, nPlayers.points) as points
FROM nPlayers
LEFT OUTER JOIN history.tempPlayers ON history.tempPlayers.player = nPlayers.name
UNION
SELECT nPlayers.name, nPlayers.team, 
COALESCE(nPlayers.goals + history.tempPlayers.goals, nPlayers.goals) as goals, 
COALESCE(nPlayers.assists + history.tempPlayers.assists, nPlayers.assists) as assists,
COALESCE(nPlayers.penaltyMin + history.tempPlayers.penaltyMin, nPlayers.penaltyMin) as penaltyMin,
COALESCE(nPlayers.points + history.tempPlayers.points, nPlayers.points) as points
FROM nPlayers
RIGHT OUTER JOIN history.tempPlayers ON history.tempPlayers.player = nPlayers.name;
DROP TABLE nPlayers;


/* create a procedure to execute later */
CREATE PROCEDURE myProcedure
CREATE TABLE allGames AS (select statement)
GO;

EXEC myProcedure;

/* Update league Players with most recent points data */
update Seasons 
inner join history.Players on (Seasons.name = history.Players.name) 
set 
Seasons.date = history.Players.date,
Seasons.goals = history.Players.goals,
Seasons.assists = history.Players.assists,
Seasons.points = history.Players.points,
Seasons.penaltyMins = history.Players.penaltyMin
where Seasons.date > '2018-01-01%';


/* fast way to update teams names */
update events set team = "Belarus" where team = 'belarus';
update events set team = "New Lowell" where team = 'newlowell';
update events set team = "Coates Creek" where team = 'coatescreek';
update events set team = "Cashtown" where team = 'cashtown';
update events set team = "Herbtown" where team = 'herbtown';
update events set team = "Stayner" where team = 'stayner';


/* Retrieve the numnber of registered players on each team */
select sum(if(name is not null, 1, 0)) as players, team from seasons where season > '2018' Group by team;