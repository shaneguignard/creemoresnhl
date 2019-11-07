<!-- Confirmation page -->
<!-- Deprecated after live updates are available -->
<html>
<?php 
    
    $gameTime = $_POST["gameTime"];
    $gameDate = $_POST["gameDate"];
    $arrTime = $_POST["eventTime"];
    $playedAt = $_POST["playedAt"];
    $tk = $_POST["timekeepername"];
    $tkpwd = $_POST["timekeeperpwd"]; 
    $eventTime = $_POST["eventTime"];
    $arrPeriod = $_POST["period"];
    $arrType = $_POST["type"];
    $arrTeam = $_POST["team"];
    $arrPlayer = $_POST["player"];
    if($tkpwd == 'tempPass1234'){
        require_once('history-mysql.php');
    }
    else {
        echo "Incorrect Password";
    }
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

        # header("Location: index.php");
    ?>

<body>
    <h1>Results</h1>

    <br>
    <?php
    echo "<h3>$gameDate Summary</h3>";
    echo "<h4>$lightGoals - $darkGoals</h4>";
    ?>
    <table border=1>
        <tr>
            <th>Date</th>
            <th>Period</th>
            <th>Team</th>
            <th>Type</th>
            <th>Player</th>
        </tr>
    <?php 

    for($i = 0; $i < count($arrType); $i++){
        
        $gameEvent = $gameDate.' '.$arrTime[$i];
        echo "<tr><td>$gameEvent</td>";
        echo "<td>$arrPeriod[$i]</td>";
        echo "<td>$arrTeam[$i]</td>";
        echo "<td>$arrType[$i]</td>";
        echo "<td>$arrPlayer[$i]</td></tr>";

//    insert into history.events SQL database
        $sql = "INSERT INTO Events(date, team, type, player, period) VALUES('$gameEvent', '$arrTeam[$i]', '$arrType[$i]', '$arrPlayer[$i]','$arrPeriod[$i]');";
        $result = $conn->query($sql);
    }
 
        
    include(allgames.php);  
    include(teams.php);
        
    $msg = "<html><body><h1>Summary</h1>$gameDate</body></html>";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    if($result === FALSE){
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    if ($result === TRUE){
	   mail("shaneguignard@gmail.com", "SQL Update", $msg, $headers);
	   echo "New Records Created";
    }
    
// close file and connection    
        $conn->close();
        ?>
    </table>
    
    <a href='scoresheet.html'>New Game</a>
</body>

</html>
