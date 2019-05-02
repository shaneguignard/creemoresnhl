<?php

require_once('history-mysql.php');
echo "Execute Teams.php<br>";
$update_Teams = "DROP TABLE Teams_bak;
CREATE TABLE Teams_bak AS SELECT * FROM Teams;
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
        SELECT date_format(date, '%Y-%m-%d %H:00:00') AS date, 
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
        SELECT date_format(date, '%Y-%m-%d %H:00:00') AS date, 
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
ORDER BY date";

echo "Update history.Teams<BR>";
$result = $conn -> query($update_Teams);
if($result === FALSE){
            echo "Error:<br>" . $conn->error;
        }
?>