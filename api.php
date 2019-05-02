<?php

// APIs

// HIGHLIGHT AND AWARDS INFO
function getChamps($year){ return "Stayner"; }

function featureImg($year){ 
    return "images/".$year."_winners.jpeg";
   
}

function getVezina($conn, $year){ 
    $result = $conn->query("SELECT * FROM history.Awards WHERE year(year) = {$year} and name = 'Vezina Award'");
    if ($result -> num_rows > 0){
        $row = $result->fetch_assoc();
        echo "<tr><td>".$row['player']."</td></tr>";
        echo "<tr><td>".$row['gaa']." GAA</td></tr>";
    }
    else{
        echo "error";
    }
}

//function getVezinaPoints($year){ return "2.25 GAA"; }

function getPCA($conn, $year) { 
    $result = $conn->query("SELECT * FROM history.Awards WHERE year(year) = {$year} and name = 'Players Choice Award'");
    if ($result -> num_rows > 0){
        $row = $result->fetch_assoc();
        echo "<tr><td rowspan='2'>".$row['player']."</td></tr>";
    }
    else{
        echo "error";
    }
}

function getPLA($conn, $year) {
   $result = $conn->query("SELECT * FROM history.Awards WHERE year(year) = {$year} and name = 'Points Leader Award'");
    if ($result -> num_rows > 0){
        $row = $result->fetch_assoc();
        echo "<tr><td>".$row['player']."</td></tr>";
        echo "<tr><td>".$row['goals']."G ".$row['assists']."A ".$row['points']."PTS</td></tr>";
    }
    else{
        echo "error";
    }
}



//function getPointsLeaderPoints($year) { return "15G 22A 37pts"; }


// PLAYER INFO

function getNumber($conn, $player){
    $result = $conn->query("SELECT number FROM league.Players Where name='$player'");
    if ($result->num_rows > 0) {
        return $result->fetch_array()[0];
    }
    else {
        return "There was a problem with getNumber";
    }
}
function joined($conn, $player){

    $result = $conn->query("select YEAR(date) as year from history.Players where name='$player' order by year asc");
    if ($result->num_rows > 0) {
        return $result->fetch_array()[0];
    }
    else {
        return "There was a problem with the getJoined";
    }
  
}

function career($conn, $player){

    $result = $conn->query("select YEAR(date) as year, team, sum(points) as points from history.Players WHERE name ='$player' group by year, team order by points desc");
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()){
            echo "<tr><td>".($row['year']-1)." - ".$row['year']."</td><td>".$row['team']."</td><td>".$row['points']."</td></tr>";
        }
    }
    else {
        return "There was a problem with the getCareer";
    }
}

// Return only the player information for that year, by default return all information when $season is null
function getCurrent($conn, $player, $season){
    $season = date('Y');
    $result = $conn->query("Select *, (select team from history.AllGames as AG where date = PE.date and team <> PE.team limit 1) as opponent from history.Players as PE where name = '$player'  and date > '".($season-1)."-09-01' and date < '".$season."-04-01'");
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()){
            echo "<tr><td>".date("M-d H",strtotime($row['date']))."</td><td>".$row['period']."</td><td>".$row['goals']."</td><td>".$row['assists']."</td><td>".$row['points']."</td><td>".$row['penaltyMin']."</td><td>".$row['opponent']."</td></tr>";
        }
    }
    else {
        return "Player is not registered for current season";
    }
}


// return summary of players history by specific season.
function getHistory($conn, $player){
    $history = $conn->query("select * from history.Players where name = '$player' order by date desc");
     if ($history->num_rows > 0) {
        while($row = $history->fetch_assoc()){
            echo "<tr><td>".(date('Y', strtotime($row['date']))-1)." - ".date('Y', strtotime($row['date']))."</td><td>".$row['goals']."</td><td>".$row['assists']."</td><td>".$row['points']."</td><td>".$row['penaltyMin']."</td></tr>";
        }
    }
    else {
        return "There was a problem retrieving information from History";
    }
}

function getAwards($conn, $player){
    $awards = $conn->query("SELECT * FROM history.Awards WHERE player = '$player'");
    if ($awards -> num_rows > 0){
        while($award = $awards->fetch_assoc()){
            echo "<tr><td>".(date('Y', strtotime($award['year']))-1)." - ".date('Y', strtotime($award['year']))."</td><td>".$award['name']."</td><td>".$award['goals']."</td><td>".$award['assists']."</td><td>".$award['points']."</td><td>".$award['gaa']."</td></tr>";
        }
    }
    else{
        echo "No awards yet";
    }
}

// PAST GAMES

function getPastGamesMobile($conn, $season){
    $sql = "SELECT * FROM history.Games where date > '".($season -1)."-09-00' and date < '".$season."-05-00' ORDER BY date asc";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $gamedate = strtotime($row['date']);
            echo "<tr><th colspan='5'>".date('Y M d - H:i', $gamedate)."</th></tr><tr><td colspan='1' class='teamA'>{$row['teamA']}</td><td rowspan='1' class='teamA'>{$row['goalsA']}</td><td rowspan='1'>vs</td><td rowspan='1' class='teamB'>{$row['goalsB']}</td><td colspan='1' class='teamB'>{$row['teamB']}</td></tr>";
        }
    }
    else {
        echo "There was a problem connecting to the server";
    }
}

function getPastGamesDesk($conn, $season){
    $sql = "SELECT * FROM history.Games where date > '".($season -1)."-09-00' and date < '".$season."-05-00' ORDER BY date asc";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $gamedate = date('Y-M-d', strtotime($row['date']));
            if ($i%3 == 0 && $i != 0){
                echo "</tr>";
            }
            if ($i%3 == 0){
                echo "<tr><th class='gamedate'>".$gamedate."</th>";
            }
            echo "<td>{$row['teamA']}</td><td>{$row['goalsA']}</td><td>vs</td><td>{$row['goalsB']}</td><td>{$row['teamB']}</td>";
            $i = $i + 1;
        }
    }
    else {
        echo "There was a problem connecting to the server";
    }             
}

function getRegSeason($conn, $season){
    $regSeason = "Select team, 
(
    sum(team='belarus') + 
    sum(team='cashtown') + 
    sum(team='new lowell') + 
    sum(team='herbtown')+ 
    sum(team='stayner') + 
    sum(team='coates creek')
)
as gp,
sum(win =1) as w, 
sum(loss = 1) as l, 
sum(tie = 1) as t,
sum(if(win = 1, 2, 0) + if(tie = 1, 1, 0)) as pts,
sum(goalsFor) as gf,
sum(goalsAgainst) as ga,

sum(diff) as diff
from history.Teams 
where date > '".($season -1)."-09-00' and date < '".$season."-02-15' 
group by team order by pts desc, gf desc";
    $result = $conn->query($regSeason);
    if($result -> num_rows > 0) {
        $i = 1;
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>$i</td><td class='rrteams'>{$row['team']}</td><td>{$row['gp']}</td><td>{$row['w']}</td><td>{$row['l']}</td><td>{$row['t']}</td><td>{$row['pts']}</td><td>{$row['gf']}</td><td>{$row['ga']}</td><td>{$row['diff']}</td></tr>";
            $i = $i + 1;
        }
    }
    else {
        echo "<tr><td colspan='10'>There was a problem retrieving Regular Season Team Standings</td></tr>";
    }
}

function getRRSeason($conn, $season){
    $regSeason = "Select team, 
(
    sum(team='belarus') + 
    sum(team='cashtown') + 
    sum(team='new lowell') + 
    sum(team='herbtown')+ 
    sum(team='stayner') + 
    sum(team='coates creek')
)
as gp,
sum(win =1) as w, 
sum(loss = 1) as l, 
sum(tie = 1) as t,
sum(if(win = 1, 2, 0) + if(tie = 1, 1, 0)) as pts,
sum(goalsFor) as gf,
sum(goalsAgainst) as ga,

sum(diff) as diff
from history.Teams 
where date > '".($season)."-02-10' and date < '".$season."-03-15' 
group by team order by pts desc, gf desc";
    $result = $conn->query($regSeason);
    if($result -> num_rows > 0) {
        $i = 1;
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>$i</td><td class='rrteams'>{$row['team']}</td><td>{$row['gp']}</td><td>{$row['w']}</td><td>{$row['l']}</td><td>{$row['t']}</td><td>{$row['pts']}</td><td>{$row['gf']}</td><td>{$row['ga']}</td><td>{$row['diff']}</td></tr>";
            $i = $i + 1;
        }
    }
    else {
        echo "<tr><td colspan='10'>There was a problem retrieving Regular Season Team Standings</td></tr>";
    }
}

function getPlayerStats($conn, $season){
    $sql = "SELECT * FROM history.Players
    where date > '".($season-1)."-09-01' and date < '".$season."-05-00'
    ORDER BY points desc";
    
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
            $i = 1;
            while($row = $result->fetch_assoc())
            {
                echo "<tr><td width='10px'>$i</td><td class='players'><a href='./players.php?name={$row['name']}'>{$row['name']}</a></td><td>{$row['team']}</td><td>{$row['goals']}</td><td>{$row['assists']}</td><td>{$row['points']}</td><td>{$row['penaltyMin']}</td></tr>";
                $i = $i +1;
            }
        }
    else {
        echo "<tr><td colspan='8'>There was a problem retrieving Player Stats</td></tr>";
    }
}
?>
