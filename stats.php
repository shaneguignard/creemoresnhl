<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<?php include_once('head.php') ?>
<?php include_once('current-mysql.php'); ?>

<body>
    <?php 
    include('header.php'); 
    include('menu.php');
    ?>
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


            <td>
                <?php
                
                $sql = "SELECT date FROM history.Players Order by date desc LIMIT 1";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    // output data of each row
                    $i = 0;
                    while($row = $result->fetch_assoc()) {
                        $upDate = strtotime($row['date']);
                        echo "<p class='date'>(Last Updated: ".date('d M y', $upDate).")</p>";
                    }
                }
                else {
                    echo "There was a problem with the Query: $sql";
                }
                    ?>
            </td>

            <h3>Previous Games</h3>
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
                
//                $sql = "SELECT * FROM PastGames";
                $sql = "SELECT * FROM history.Games WHERE date > '2019-09-01'";
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
                            echo "<tr><th class='gamedate'>".date('M-d', $gamedate)."</th>";
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
                // $sql = "SELECT * FROM PastGames ORDER BY date desc";
                $sql = "SELECT * FROM history.Games WHERE date > '2019-09-01'";
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
            <div id="standings" class="offset">
                <h3>STANDINGS</h3>
                <!--            Stats are only displayed for regular and roundrobin games. Playoffs are ommited -->
                <table class='standings' cellspacing='0' cellpadding='0'>
                    <tr>
                        <th colspan="10">
                            <h4>REGULAR SEASON TEAM STANDINGS</h4>
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
                    $regularSeason = "Select distinct team, sum(goalsFor) as gf, sum(goalsAgainst) as ga, sum(win) as w, sum(loss) as l, sum(tie) as t, sum(diff) as diff, sum(team='belarus') as gpbel, sum(team='cashtown') as gpcash, sum(team='new lowell Hawks') as gpnl, sum(team='herbtown') as gpherb, sum(team='coates creek') as gpcc, sum(team='stayner') as gpstay, (sum(win)*2+sum(tie)) as pts from history.Teams where date > '2019-10-10' group by team order by diff desc";
                    $alltime = "Select distinct team, sum(team) as gp, sum(goalsFor) as gf, sum(goalsAgainst) as ga, sum(win) as w, sum(loss) as l, sum(tie) as t, sum(diff) as diff from history.Teams group by team order by diff desc;"; 
                    $regularSeasonTeamStats = $conn->query($regularSeason);
                    $alltimeTeamStats = $conn->query($alltime);
                    if($regularSeasonTeamStats -> num_rows > 0)
                    {
                        $i = 1;
                        while($row = $regularSeasonTeamStats->fetch_assoc())
                        {
                            switch($row['team']){
                                case 'Belarus': $gp = $row['gpbel'];
                                break;
                            }
                            echo "<tr><td>$i</td><td class='rrteams'>{$row['team']}</td><td>{$gp}</td><td>{$row['w']}</td><td>{$row['l']}</td><td>{$row['t']}</td><td>{$row['pts']}</td><td>{$row['gf']}</td><td>{$row['ga']}</td><td>{$row['diff']}</td></tr>";
                            $i = $i + 1;
                        }
                    }
                    else if($alltimeTeamStats -> num_rows > 0)
                    {
                        echo "<tr><td colspan='10'>No stats to display</td></tr>";
                        // $i = 1;
                        // echo "<tr><td colspan='10'>History of league Overview</td></tr>";
                        // while($row = $alltimeTeamStats->fetch_assoc())
                        // {
                        //     switch($row['team']){
                        //         case 'Belarus': $gp = $row['gp-bel'];
                        //         break;
                        //     }
                        //     echo "<tr><td>$i</td><td class='rrteams'>{$row['team']}</td><td>{$gp}</td><td>{$row['w']}</td><td>{$row['l']}</td><td>{$row['t']}</td><td>{$row['pts']}</td><td>{$row['gf']}</td><td>{$row['ga']}</td><td>{$row['diff']}</td></tr>";
                        //     $i = $i + 1;
                        // }
                    }
                    else {
                        echo "<tr><td colspan='10'>There was a problem retrieving Regular Season Team Standings</td></tr>";
                    }
                    ?>
                </table>
<!--  Commented out for regular season
                <table class='standings' cellspacing='0' cellpadding='0'>
                    <tr>
                        <th colspan="10">
                            <h4>ROUND ROBIN TEAM STANDINGS</h4>
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
-->
                    <?php
                    $rrSeason = "Select distinct team, sum(team) as gp, sum(goalsFor) as gf, sum(goalsAgainst) as ga, sum(win) as w, sum(loss) as l, sum(tie) as t, sum(diff) as diff from history.Teams where date > '2020-02-05' group by team order by diff desc;"; 
                    $alltime = "Select distinct team, sum(team) as gp, sum(goalsFor) as gf, sum(goalsAgainst) as ga, sum(win) as w, sum(loss) as l, sum(tie) as t, sum(diff) as diff from history.Teams group by team order by diff desc;"; 
                    $rrSeasonTeamStats = $conn->query($rrSeason);
                    $alltimeTeamStats = $conn->query($alltime);
                    if($regularSeasonTeamStats -> num_rows > 0)
                    {
                        $i = 1;
                        while($row = $rrSeasonTeamStats->fetch_assoc())
                        {
                            switch($row['team']){
                                case 'Belarus': $row['gp'] = $row['gp-bel'];
                                break;
                            }
                            echo "<tr><td>$i</td><td class='rrteams'>{$row['team']}</td><td>{$row['gp']}</td><td>{$row['w']}</td><td>{$row['l']}</td><td>{$row['t']}</td><td>{$row['pts']}</td><td>{$row['gf']}</td><td>{$row['ga']}</td><td>{$row['diff']}</td></tr>";
                            $i = $i + 1;
                        }
                    }
                    else if($alltimeTeamStats -> num_rows > 0)
                    {
                        echo "<tr><td colspan='10'>No stats to display</td></tr>";
                        // $i = 1;
                        // echo "<tr><td colspan='10'>History of league Overview</td></tr>";
                        // while($row = $alltimeTeamStats->fetch_assoc())
                        // {
                        //     switch($row['team']){
                        //         case 'Belarus': $gp = $row['gp-bel'];
                        //         break;
                        //     }
                        //     echo "<tr><td>$i</td><td class='rrteams'>{$row['team']}</td><td>{$gp}</td><td>{$row['w']}</td><td>{$row['l']}</td><td>{$row['t']}</td><td>{$row['pts']}</td><td>{$row['gf']}</td><td>{$row['ga']}</td><td>{$row['diff']}</td></tr>";
                        //     $i = $i + 1;
                        // }
                    }
                    else {
                        echo "<tr><td colspan='10'>There was a problem retrieving Regular Season Team Standings</td></tr>";
                    }
                    ?>
                </table>

                <table id="playerStats" class='standings offset' cellspacing='0'>
                    <tr>
                        <th colspan='8'>
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
                        <th>Prev. Game</th>
                    </tr>
                    <?php
                        $currentSeasonPlayers = "Select distinct name, team, sum(goals) as goals, sum(assists) as assists, sum(points) as points, sum(penaltyMin) as penaltyMin  from history.Players where date > '2019-9-1' group by name, team order by points desc, goals desc, assists desc;"; 
                        // $alltime_players = "SELECT * FROM Players ORDER BY points desc, goals desc, assists desc, penaltyMin asc";
                        $playersStats = $conn->query($currentSeasonPlayers);
                        if($playersStats -> num_rows > 0)
                        {
                            $i = 1;
                            while($row = $playersStats->fetch_assoc())
                            {
                                echo "<tr><td width='10px'>$i</td><td class='players'><a href='./players.php?name={$row['name']}'>{$row['name']}</a></td><td>{$row['team']}</td><td class='pPoints'>{$row['goals']}</td><td class='pPoints'>{$row['assists']}</td><td class='pPoints'>{$row['points']}</td><td class='pPoints'>{$row['penaltyMin']}</td><td class='pPoints' width='40px'>{$row['newPoints']}</td></tr>";
                            $i = $i +1;
                            }
                        }
                        
                        else {
                            echo "<tr><td colspan='8'>No stats to display</td></tr>";
                            // echo "<tr><td colspan='8'>There was a problem retrieving Player Stats</td></tr>";
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
                    <a href="season.php?season=2019" target="_parent">
                        <img class='historyLinkImg' src="images/logo.png">
                        <historyYear>2018/2019</historyYear>
                        <historyTeam>Stayner</historyTeam>
                    </a>
                </div>
                <div class="pageLinks">
<!--                    <a href="history/2018winners.html" target="_page">-->
                    <a href="season.php?season=2018" target="_parent">
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
