#Add-PSSnapIn SMCmdletSnapIn

#global array of seasons

$seasons = 2010, 2011, 2012#, 2013, 2014, 2015, 2016, 2017
$allPlayers = ""

function log($date, $t1, $t2, $p1, $p2, $t3, $t4, $p3, $p4, $t5, $t6, $p5, $p6){

$early = $date+"-7.csv"
$mid = $date+"-8.csv"
$late = $date+"-9.csv"
$header = "type, player, team, period, time, assist"
Set-Content -path $early -value $header
Set-Content -path $mid -value $header
Set-Content -path $late -value $header

    if($p1 -gt 0){
    
        for($i = 0; $i -lt $p1; $i++)
        {
            Add-Content $early "goal, null, $t1, null, null, null"
        } 
    }
    else{
        Add-Content $early "null, null, $t1, null, null, null"
    }

    if($p2 -gt 0){
        for($i = 0; $i -lt $p2; $i++)
        {
            Add-Content $early "goal, null, $t2, null, null, null"
        }
    }
    else{
        Add-Content $early "null, null, $t2, null, null, null"
    }

    if($p3 -gt 0){
        for($i = 0; $i -lt $p3; $i++)
        {
             Add-Content $mid "goal, null, $t3, null, null, null"
        } 
    }
    else
    {
        Add-Content $mid "null, null, $t3, null, null, null"
    }

    if($p4 -gt 0){
        for($i = 0; $i -lt $p4; $i++)
        {
            Add-Content $mid "goal, null, $t4, null, null, null"
        }
    }
    else
    {
        Add-Content $mid "null, null, $t4, null, null, null"
    }

    if($p5 -gt 0){
        for($i = 0; $i -lt $p5; $i++)
        {
            Add-Content $late "goal, null, $t5, null, null, null"
        }
    }
    else
    {
        Add-Content $late "null, null, $t5, null, null, null"
    }

    if($p6 -gt 0){
        for($i = 0; $i -lt $p6; $i++)
        {
            Add-Content $late "goal, null, $t6, null, null, null"
        }
    }
    else
    {
         Add-Content $late "null, null, $t6, null, null, null"
    }
}

function open($file){
    $text = Get-Content -Path $file
    return $text

}

function updateMasterDb(){
   $seasons = dir | where extension -eq "" | select basename
   cd $seasons[0].basename
   $games = ls | where basename -ne "players" | select basename
   $dates = $games[0].basename -split "-"
   $year = $dates[0]
   Write-Host "Year: " $year
   $month = $dates[1]
   write-host "Month: " $month
   $day = $dates[2]
   write-host "Day: " $day
   $hour = $dates[3]
   write-host "time: " $hour
   $games[0] = $games[0].BaseName +".csv"
   $data = Get-Content $games[0]
   write-host "Data: " $data[0]
   $point = $data[1] -split ","
   $type = $point[0]
   $player = $point[1]
   $team = $point[2]
   $period = $point[3]
   $time = $point[4]
   $assist = $point[5]
   $output[0] = [System.Collections.Generic.List[System.Object]]"year, month, day, hour, period, time, team, type, player, assist"
   $output[1] = $year, $month, $day, $hour, $period, $time, $type, $player, $assist
   echo $output


}

function addPlayer($player){
   $player += @(1)
   $global:allPlayers += @($player)
   Write-Host "new: " $player
}

function updatePlayer($player){
        $leaguePlayers += @(importLeague)
        for($i = 0; $i -le $leaguePlayers.Length; $i++){
        
        if($leaguePlayers[$i] -contains $player[0]){
            write-host "Current: " $leaguePlayers[$i] 
            Write-Host "Updated: " $player
        }
        else{
            
            addPlayer($player)
            break
        }
        }
}

function importLeague(){
$global:allPlayers = open "allPlayers.csv"
}

function league(){

    for($y = 0; $y -lt $global:seasons.length; $y++){
        $currentSeason = $global:seasons[$y]
        Write-Host $currentSeason
        $players = open $currentSeason"\players.csv"
        

        for($i = 1; $i -lt $players.length; $i++){

            updatePlayer($players[$i])
        }
    }   
    Set-Content -Path "allPlayers.csv" -Value $global:allPlayers  
    echo "Players Summary" $global:allPlayers 
}

function cloud(){
    #defines local documents path
    $local = "c:\users\guignardsh\gCloud\"

    #defines remote drive path
    $remote = "p:\"

    #copies items from local to remote
    Copy-Item $remote c:\users\guignardsh\gCloud\ -force


    #copy if newer only

    #how can I make sure that documents added to folder by another local machine can
    #be updated on the current local machine as well? 
}

function pro(){
notepad $profile
}

function hello(){
    $h = Get-Date
    if($h.Hour -lt 12){
        echo "Good Morning" 
    }else
    {
        echo "Good Afternoon"
    }
}
