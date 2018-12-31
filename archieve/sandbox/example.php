<html>
<?php 
    $ref = $_POST["ref"];
    $tk = $_POST["timekeeper"];
    $gameDate = $_POST["gameDate"];
    $playedAt = $_POST["playedAt"];
    $arrType = $_POST["type"];
    $arrTeam = $_POST["team"];
    $arrPeriod = $_POST["period"];
    $arrTime = $_POST["time"];
    $arrPlayer = $_POST["player"];
    $arrAssist = $_POST["assist"];

    ?>
<style>
    table {
        width: auto;
    }

</style>
<!--Email Body-->
<!--$msg = "-->

<body>
    <h1>Results</h1>
    <br>
    <h3>Game Summary</h3>
    <?php echo $gameDate; ?>
    <table border=1>
        <tr>
            <th>Type</th>
            <th>Team</th>
            <th>Period</th>
            <th>Time</th>
            <th>Player</th>
        </tr>
        <?php 
        
        //open file
        $fid = fopen('newGame.csv', 'w');
        $list = array('date', 'period', 'team','type','player');
        fputcsv($fid, $list);
    for($i = 0; $i < count($arrType); $i++)
    {
        echo "<tr><td>$arrType[$i]</td>";
        echo "<td>$arrTeam[$i]</td>";
        echo "<td>$arrPeriod[$i]</td>";
        echo "<td>$arrTime[$i]</td>";
        echo "<td>$arrPlayer[$i]</td></tr>";
        //echo "<td>$arrAssist[$i]</td></tr>";
        
//end of message variable
       
        $list = array($gameDate.' '.$arrTime[$i], $arrPeriod[$i], $arrTeam[$i], $arrType[$i], $arrPlayer[$i]);
        
        //write to newGame.csv
        fputcsv($fid, $list);
        
    }
     
       
        //close file
        fclose($fid);
    
        // Email example
    $msg = "<html><body><h1>Summary</h1>$gameDate</body></html>";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        
    // Send email
    //mail("shaneguignard@gmail.com", "Test Email", $msg, $headers);
    ?>
    </table>
</body>

</html>
