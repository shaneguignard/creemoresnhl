
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

    if($tkpwd == '1234'){
        require_once('history-mysql.php');
    }
    else {
        echo "Incorrect Password";
    }


    // Shutout Condition



    echo "<html><body>";
   
    for($i = 0; $i < count($type); $i++){
        //  Combine date and time to make a datetime object
        $gameEvent = $gameDate.' '.$gameTime[$i];
        //    insert into history.events SQL database
        $sql = "INSERT INTO Events(date, team, type, player, period, timekeeper, timekeeper_pw) VALUES('$gameEvent', '$team[$i]', '$type[$i]', '$player[$i]','$period[$i]', '$tk', '$tkpwd');";
        $result = $conn->query($sql);
        if($result === FALSE){
            echo "<h1>Error with events insert </h1>".$sql."<br>".$conn->error;
        }
        else{
            echo "<h1>Submit to Events: </h1>".$sql;
        }
    }

    //  Populate history.Games
    $updateGamesSQL = fopen("history.Games", "r") or die("Unable to retrieve players query");
    $games = fread($updateGamesSQL, filesize("history.Games"));
    fclose($updateGamesSQL);
    $setRow = "SET @rowid = 0";
    $conn->query($setRow);
    $result = $conn->query($games);
        if($result === FALSE){
            echo "<h1>Error with Games insert </h1>".$games."<br>".$conn->error;
        }
        else{
            echo "<h1>Update Games </h1>".$games;
        }


    //  Populate history.Players
    $updatePlayersSQL = fopen("history.Players", "r") or die("Unable to retrieve players query");
    $players = fread($updatePlayersSQL, filesize("history.Players"));
    // echo "<h1>Updated Players Data</h1><h2>Description</h2>Query to update history.Players with latest events:<br>".$players;
    fclose($updatePlayersSQL);
    $result = $conn->query($players);
        if($result === FALSE){
            echo "<h1>Error with Players insert </h1>".$players."<br>".$conn->error;
        }
        else{
            echo "<h1>Update Players </h1>".$players;
        }

    //  Populate history.Teams
    $updateTeamsSQL = fopen("history.Teams", "r") or die("Unable to open file!");
    $teams = fread($updateTeamsSQL ,filesize("history.Teams"));
    // echo "<h1>Updated Teams Data</h1><h2>Description</h2>Query to update history.Teams with latest events:<br>".$teams;
    fclose($updateTeamsSQL);
    $conn->query($setRow);
    $result = $conn->query($teams);
        if($result === FALSE){
            echo "<h1>Error with Teams insert </h1>".$teams."<br>".$conn->error;
        }
        else{
            echo "<h1>Update Teams</h1>".$teams;
        }
    $conn->close();
    echo "</body></html>";
    ?>
    