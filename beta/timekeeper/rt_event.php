<?php 
    
    $gameNum = $_POST["gamenum"];
    $gameDate = $_POST["gameDate"];
    $gameTime = $_POST["gameTime"];
    $playedAt = $_POST["playedAt"];
    $eventTime = $_POST["eventTime"];
    $period = $_POST["period"];
    $type = $_POST["type"];
    $team = $_POST["team"];
    $player = $_POST["player"];

   // This is for security, replace with https certificate or other modern encryption
    $tk = $_POST["timekeepername"];
    $tkpwd = $_POST["timekeeperpwd"]; 
   

    require_once('history-mysql.php');
    
    // Shutout Condition
    if ($lightGoals == 0){
        array_push($arrTime, $arrTime[0]);
        array_push($arrTeam, $lightTeam);
        array_push($arrType, '');
        array_push($arrPlayer, '');
    }
    if ($darkGoals == 0){
        array_push($arrTime, $arrTime[0]);
        array_push($arrTeam, $darkTeam);
        array_push($arrType, '');
        array_push($arrPlayer, '');
    }


    $gameEvent = $gameDate.' '.$gameTime;
    //    insert into history.events SQL database
    $sql = "INSERT INTO `Events` VALUES ('$gameEvent', '$team', '$type', '$player', '$period')";
    $result = $conn->query($sql);

    if($result === FALSE){
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // close file and connection    
    $conn->close();
        ?>