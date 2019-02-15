<html>
<?php 
    
    $ref = $_POST["ref"];
    $refpwd = $_POST["refpwd"];
    $tk = $_POST["timekeeper"];
    $tkpwd = $_POST["timekeeperpwd"];
    $lightGoals = $_POST["lightGoals"];
    $lightTeam = $_POST["lightTeam"];
    $darkGoals = $_POST["darkGoals"];
    $darkTeam = $_POST["darkTeam"];
    $gameDate = $_POST["gameDate"];
    $playedAt = $_POST["playedAt"];
    $arrType = $_POST["type"];
    $arrTeam = $_POST["team"];
    $arrPeriod = $_POST["period"];
    $arrTime = $_POST["time"];
    $arrPlayer = $_POST["player"];

    if($tkpwd === '1234'){
        require_once('history-mysql.php');
    }
    else 
    {
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
    ?>
<style>
    table {
        width: auto;
    }

</style>
<body>
    <h1>Results</h1>

    <br>
    <?php
    echo "<h3>$gameDate Summary</h3>";
    echo "<h4>$lightGoals - $darkGoals</h4>";
    ?>
    <table border=1>
        <tr>
            <th>date</th>
            <th>team</th>
            <th>type</th>
            <th>player</th>
        </tr>
    <?php 

    for($i = 0; $i < count($arrType); $i++){
        
        $gameEvent = $gameDate.' '.$arrTime[$i];
        echo "<tr><td>$gameEvent</td>";
        echo "<td>$arrTeam[$i]</td>";
        echo "<td>$arrType[$i]</td>";
        echo "<td>$arrPlayer[$i]</td></tr>";

//    insert into history.events SQL database
        $sql = "INSERT INTO `events` VALUES ('$gameEvent', '$arrTeam[$i]', '$arrType[$i]', '$arrPlayer[$i]')";

            $result = $conn->query($sql);
    }
 
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
