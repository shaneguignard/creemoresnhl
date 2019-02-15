<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<?php include_once('head.php') ?>

<body>
    <?php include_once('header.php'); ?>
    <noscript>
        For full functionality of this site it is necessary to enable JavaScript.
        Here are the <a href="https://www.enable-javascript.com/" style='text-decoration: underline;'>
            instructions how to enable JavaScript in your web browser</a>.
    </noscript>
    <div id="root">
        <!-- STATISTICS -->
        <div id="stats" class="section">
            <h1>STATISTICS</h1>
            <h4>SUNDAY NIGHT HOCKEY LEAGUE <div class='currentSeasonYear'></div> GAME OVERVIEW</h4>
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
                <?php
                include_once('current-mysql.php');
                $sql = "SELECT * FROM PastGames";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    // output data of each row
                    $i = 0;
                    while($row = $result->fetch_assoc()) {
                        $gamedate = strtotime($row['date']);
                        if ($i%3 == 0 && $i != 0){
                            echo "</tr>";
                        }
                        if ($i%3 == 0){
                            echo "<tr><th class='gamedate'>".date('d F Y', $gamedate)."</th>";
                        }
                        echo "<td>{$row['teamA']}</td><td>{$row['goalsA']}</td><td>vs</td><td>{$row['goalsB']}</td><td>{$row['teamB']}</td>";
                        
                    $i = $i + 1;
                    }
                }
                else {
                    echo "There was a problem connecting to the server";
                }
                    ?>
            </table>
            <table class='mobile' id='mobileGamesPast' title="PastGames" cellspacing='0' cellpadding='0'>
                <?php
                $sql = "SELECT * FROM PastGames";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        $gamedate = strtotime($row['date']);
                        echo "<tr><th colspan='5'>".date('d F Y - H:i', $gamedate)."</th></tr><tr><td colspan='1' class='teamA'>{$row['teamA']}</td><td rowspan='2' class='teamA'>{$row['goalsA']}</td><td rowspan='2'>vs</td><td rowspan='2' class='teamB'>{$row['goalsB']}</td><td colspan='1' class='teamB'>{$row['teamB']}</td></tr><tr><td>Goals</td><td>Goals</td></tr>";
                    }
                }
                else {
                    echo "There was a problem connecting to the server";
                }
                
                ?>
            </table>
            <div id="standings">
                <h3>STANDINGS</h3>
                <table class='standings' cellspacing='0' cellpadding='0'>
                    <tr>
                        <th colspan="10">
                            <h4>REGULAR STANDINGS</h4>
                        </th>
                    </tr>
                    <tr>
                        <th>Pos.</th>
                        <th>Team</th>
                        <th>GP</th>
                        <th>W</th>
                        <th>L</th>
                        <th>T</th>
                        <th>Pts</th>
                        <th>GF</th>
                        <th>GA</th>
                        <th>+/-</th>
                    </tr>
                    <?php
                    $mysql = "SELECT * FROM regularStandings ORDER BY pts desc, w desc, diff desc";
                    $result = $conn->query($mysql);
                    if($result -> num_rows > 0)
                    {
                        $i = 1;
                        while($row = $result->fetch_assoc())
                        {
                            echo "<tr><td>$i</td><td class='rrteams'>{$row['team']}</td><td>{$row['gp']}</td><td>{$row['w']}</td><td>{$row['l']}</td><td>{$row['t']}</td><td>{$row['pts']}</td><td>{$row['gf']}</td><td>{$row['ga']}</td><td>{$row['diff']}</td></tr>";
                            $i = $i + 1;
                        }
                    }
                    else {
                        echo "There was a problem retrieving Regular Season Standings";
                    }
                    ?>
                </table>

                <table class='standings' cellspacing='0' cellpadding='0'>
                    <tr>
                        <th colspan="10">
                            <h4>ROUND ROBIN STANDINGS</h4>
                        </th>
                    </tr>
                    <tr>
                        <th>Pos.</th>
                        <th>Team</th>
                        <th>GP</th>
                        <th>W</th>
                        <th>L</th>
                        <th>T</th>
                        <th>Pts</th>
                        <th>GF</th>
                        <th>GA</th>
                        <th>+/-</th>
                    </tr>
                    <?php
                    $mysql = "SELECT * FROM roundrobinStandings ORDER BY pts desc, w desc, diff desc";
                    $result = $conn->query($mysql);
                    if($result -> num_rows > 0)
                    {
                        $i = 1;
                        while($row = $result->fetch_assoc())
                        {
                            echo "<tr><td>$i</td><td class='rrteams'>{$row['team']}</td><td>{$row['gp']}</td><td>{$row['w']}</td><td>{$row['l']}</td><td>{$row['t']}</td><td>{$row['pts']}</td><td>{$row['gf']}</td><td>{$row['ga']}</td><td>{$row['diff']}</td></tr>";
                            $i = $i + 1;
                        }
                    }
                    else {
                        echo "There was a problem retrieving RoundRobin Season Standings.";
                    }
                    ?>
                </table>

                <table id="playerStats" class='standings' cellspacing='0' cellpadding='0'>
                    <tr>
                        <th colspan='7'>
                            <h4>PLAYERS STATISTICS</h4>
                        </th>
                    </tr>
                    <tr>
                        <th>Pos.</th>
                        <th>Player</th>
                        <th>Team</th>
                        <th>G</th>
                        <th>A</th>
                        <th>Pts</th>
                        <th>PIM</th>
                    </tr>
                    <?php
        $mysql = "SELECT * FROM Players ORDER BY points desc, goals desc, assists desc, penaltyMin asc";
                    $result = $conn->query($mysql);
        if($result -> num_rows > 0)
        {
            $i = 1;
            while($row = $result->fetch_assoc())
            {
                echo "<tr><td>$i</td><td>{$row['name']}</td><td>{$row['team']}</td><td>{$row['goals']}</td><td>{$row['assists']}</td><td>{$row['points']}</td><td>{$row['penaltyMin']}</td></tr>";
            $i = $i +1;
            }
        }
        else {
            echo "There was a problem retrieving Player Stats";
        }
        $conn->close();
        ?>
                </table>
            </div>
        </div>
        <!-- HISTORY -->
        <hr>
        <div id="historyMain" class="section">
            <h1 class="offset">HISTORY</h1>
            <div id="historylinks">
                <div class="pageLinks">
                    <a href="history/2018winners.html" target="_page">
                        <img class='historyLinkImg' src="images/logo.png">
                        <historyYear>2017/2018</historyYear>
                        <historyTeam>Stayner</historyTeam>
                    </a>
                </div>
                <div class="pageLinks">
                    <a href="history/2017winners.html" target="_page">
                        <img class='historyLinkImg' src="images/logo.png">
                        <historyYear>2016/2017</historyYear>
                        <historyTeam>Stayner</historyTeam>
                    </a>
                </div>
                <div class="pageLinks">
                    <a href="history/2016winners.html" target="_page">
                        <img class='historyLinkImg' src="images/logo.png">
                        <historyYear>2015/2016</historyYear>
                        <historyTeam>New Lowell</historyTeam>
                    </a>
                </div>
                <div class="pageLinks">
                    <a href="history/2015winners.html" target="_page">
                        <img class='historyLinkImg' src="images/logo.png">
                        <historyYear>2014/2015</historyYear>
                        <historyTeam>Coates Creek</historyTeam>
                    </a>
                </div>
                <div class="pageLinks">
                    <a href="history/2014winners.html">
                        <img class='historyLinkImg' src="images/logo.png">
                        <historyYear>2013/2014</historyYear>
                        <historyTeam>Belarus</historyTeam>
                    </a>
                </div>
                <div class="pageLinks">
                    <a href="history/2013winners.html" target="_page">
                        <img src="images/logo.png">
                        <historyYear>2012/2013</historyYear>
                        <historyTeam>Belarus</historyTeam>
                    </a>
                </div>
                <div class="pageLinks">
                    <a href="history/2012winners.html" target="_page">
                        <img src="images/logo.png">
                        <historyYear>2011/2012</historyYear>
                        <historyTeam>Garner</historyTeam>
                    </a>
                </div>
                <div class="pageLinks">
                    <a href="history/2011winners.html" target="_page">
                        <img src="images/logo.png">
                        <historyYear>2010/2011</historyYear>
                        <historyTeam>Cashtown Whiskey Jacks</historyTeam>
                    </a>
                </div>


            </div>
        </div>
    </div>
</body>
<script src="functions.js"></script>

</html>
