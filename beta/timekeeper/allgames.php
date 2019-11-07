<?php 
$destroy = "DROP TABLE AllGames_bak;";
$create = "CREATE TABLE AllGames_bak AS SELECT * FROM AllGames;";
$rebuild = "INSERT INTO AllGames (date, team, goals, assists, penaltyMins, shots) SELECT date, team, goals,assists,penaltyMins, shots FROM (SELECT date, team, SUM(type = 'goal') AS goals, SUM(type = 'assist') AS assists, SUM(IF(type = 'penalty',2 ,0)) as penaltyMins, SUM(type='shot') AS shots FROM ( SELECT date_format(date, '%Y-%m-%d %H:00:00') AS date, team, type, player FROM Events ) AS temp GROUP BY date, team) as temp2 WHERE date > '2019-02-18';";

// $result = $conn->query($destroy);
// $result = $conn->query($create);
// $result = $conn->query($rebuild);

if($result === FALSE){
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
?>