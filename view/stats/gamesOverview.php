<h2>Season Game Summary</h2>
<table name="gameStats_table" class='desktop' id="deskGamesPast" title='PastGames' cellpadding='0' cellspacing='0'>
                <tr>
                    <th rowspan="2">Date</th>
                    <th colspan='5'>7PM</th>
                    <th colspan='5'>8PM</th>
                    <th colspan='5'>9PM</th>
                </tr>
                <tr>
                    <th colspan='2'>Home</th>
                    <th></th>
                    <th colspan='2'>Away</th>
                    <th colspan='2'>Home</th>
                    <th></th>
                    <th colspan='2'>Away</th>
                    <th colspan='2'>Home</th>
                    <th></th>
                    <th colspan='2'>Away</th>
                </tr>
                <?php echo getPastGamesDesk($conn, $season);
                
//                $sql = "SELECT * FROM history.Games";
//                $result = $conn->query($sql);
//                if ($result->num_rows > 0) {
//                    // output data of each row
//                    $i = 0;
//                    while($row = $result->fetch_assoc()) {
//                        $gamedate = strtotime($row['date']);
//                        if ($i%3 == 0 && $i != 0){
//                            echo "</tr>";
//                        }
//                        if ($i%3 == 0){
//                            echo "<tr><th class='gamedate'>".date('d F Y', $gamedate)."</th>";
//                        }
//                        echo "<td>{$row['teamA']}</td><td>{$row['goalsA']}</td><td>vs</td><td>{$row['goalsB']}</td><td>{$row['teamB']}</td>";
//                        
//                    $i = $i + 1;
//                    }
//                }
//                else {
//                    echo "There was a problem connecting to the server";
//                }              
                    ?>
            </table>

            <table class='mobile' id='mobileGamesPast' title="PastGames" cellspacing='0' cellpadding='0'>
                <?php echo getPastGamesMobile($conn, $season); ?>
            </table>