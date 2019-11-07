
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <title>Score Sheet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        #root td{
            display: block;
        }
        tr {
            width: 100%;
        }
        input[type='text'], 
        input[type='password']{
            border-top: none;
            border-left: none;
            border-right: none;
            font-size: 14pt;
        }
        input:focus{
            font-size: 18pt;
        }
    </style>
</head>

<body>
    <form id='update' method='POST' action='events.php'>
        <table id="root" border=0>
            <thead>
                <h1>Creemore Sunday Night Hockey</h1>
            </thead>
            <tr>
                <td>
                    <input type="text" name="gameDate" placeholder='Date' onchange='updateSessionStorage();' require>
                </td>
                <td>
                    <input placeholder='Time' type='text' name='gameTime' onchange='updateSessionStorage();' require>
                </td>
                <td>
                    <input placeholder='Arena' type="text" name="playedAt" placeholder="arena"  onchange='updateSessionStorage();' value="Creemore Arena" require></td>
            </tr>
            <tr>
                <td>
                    <input type="text" name="timekeepername" placeholder="Name of TimeKeeper" onchange='updateSessionStorage();' require>
                </td>
                <td colspan="2">
                    <input type="password" name="timekeeperpwd" placeholder="Password">
                </td>
            </tr>
        </table>
        <table border=1>
            <tr>
                <th>Period</th>
                <th>Type</th>
                <th>Team</th>
                <th>Player</th>
                <th></th>
                <!-- <th></th> -->
            </tr>
            <tbody id="newRecord">
                <tr class='rows'>
                    <td>
                        <select id='period' style='width:50px; text-align:center;' type='text'>
                            <option value='1'>1</option>
                            <option value='2'>2</option>
                            <option value='3'>3</option>
                        </select>
                    </td>
                    <td>
                        <select id="pointType">
                            <option value='Goal'>Goal</option>
                            <option value='Assist'>Assist</option>
                            <option value='Penalty'>Penalty</option>
                        </select>
                    </td>
                    <td>
                        <select name='team' id="teamSelect" onchange="updatePlayers(teamSelect.value);">
                            <!-- Populate dropdown with teams -->
                        </select>
                    </td>
                    <td>
                        <!-- The player list should update whenever a new team is selected-->
                        <select name='player' id='playerSelect'>
                            <!-- Populate drop down with players names from team -->
                        </select>
                    </td>
                    <td><input type='button' value='Add' onclick='add(period.value, pointType.value, teamSelect.value, playerSelect.value);'></td>
                </tr>
            </tbody>
        </table>
        <table id="events">
            <tbody id='records'>
            </tbody>
        </table>
    </form>
    <button onclick="submit();">End Game</button>
</body>
<script>
   
    // Define Page variables
    var d = new Date(); 
    var dd = d.getDate();
    var mm = d.getMonth() + 1;
    var yyyy = d.getFullYear();
    sessionDate = yyyy + '-' + mm + '-' + dd;
    // var record = document.getElementById("records");
    var points = [];
    var row = 0;

    // Update Session Storage
    function updateSessionStorage(){
        // Set Session Variables
        sessionStorage.setItem("row", row);
        sessionStorage.setItem("gameDate", sessionDate);
        sessionStorage.setItem("gameTime", document.getElementsByName('gameTime')[0].value);
        sessionStorage.setItem("points", points);
        sessionStorage.setItem("arena", document.getElementsByName('playedAt')[0].value);
        sessionStorage.setItem("timekeeper", document.getElementsByName('timekeepername')[0].value);
        console.log(
            sessionStorage.getItem("row"), 
            sessionStorage.getItem("gameDate"), 
            sessionStorage.getItem("gameTime"), 
            sessionStorage.getItem("arena"),
            sessionStorage.getItem("timekeeper")
        );
        document.getElementsByName('gameDate')[0].value = sessionStorage.getItem("gameDate");
    }
    window.onload = function(){    
        sessionStorage.clear();
        // Initialization of first teams players
        updatePlayers(teams[0].team);
        // Initialization of Session Storage
        updateSessionStorage();
        var tm = [];
        for(var i =0; i<teams.length;i++){
            tm.push("<option>"+teams[i].team+"</option>");
        }
        var temp = tm.join('');
        document.getElementById('teamSelect').innerHTML = temp;
    
    }

    function updatePlayers(currTeam){
        var player = [];
        for (var i = 0; i < players.length; i++){
            if (players[i].team == currTeam){
                player.push("<option>"+players[i].number+" - "+players[i].name+"</option>");
            }
        }
        var temp = player.join('');
        document.getElementById('playerSelect').innerHTML = temp;
        
    }

    function updatePoints(RowID){
        console.log("Before: ", points[RowID]);
        points[RowID] = document.getElementsByTagName('tr')[RowID+4];
        console.log("After: ", (points[RowID].innerHTML).toString());
        sessionStorage.setItem(RowID, points[RowID].toString());

    }
    
    //O(1)
    function add(period, type, team, player) {
        player = player.split(' - ')[1];
        console.log(d, period, type, team, player);

        // LocalStorage or session storage will save client side variables in the browser.
        var body = document.getElementsByTagName('body')[0];
        var popup = document.getElementById('popup');
        var time = new Date();
        var point = '';
        var newRecord = document.getElementById('newRecord').innerHTML;
        if (time.getHours() < 12) {
            time = (time.toLocaleTimeString()).replace(' AM', '');
        } else {
            time = (time.toLocaleTimeString()).replace(' PM', '');
        }

        // If a text field is ever changed, promote those changes to session memory so that they are persistent across other form changes.
        //Populate 
        var newPoint = '<tr><td><input type="time" name="eventTime[]" value="' + time + '" onchange="updatePoints('+row+');"></td><td><input style="width:50px;" type="text" name="period[]" value="' + period + '" onchange="updatePoints('+row+');"></td><td><input style="width:50px;" type="text" name="type[]" value="' + type + '" readonly></td><td><input type="text" name="team[]" value="' + team + '" onchange="updatePoints('+row+');"></td><td><input type="text" name="player[]" value="' + player + '" onchange="updatePoints('+row+');"></td><td colspan ="2"><input type="button" onclick="del(' + row + ');" value="Delete"></td></tr>';
        
        sessionStorage.setItem(row, newPoint);
        points.push(newPoint);

        var temp = points.join('');
        document.getElementById("records").innerHTML = temp;
        row++;
        return

    }

    function del(RowID) {
        console.log("delete row: " + RowID)
        document.getElementById('events').deleteRow(RowID);
        points.splice(RowID, 1);
        sessionStorage.removeItem(RowID)
        updateSessionStorage();
    }

    function myUndo() {
        if (row > 0) {
            points.pop();
            document.getElementById('events').deleteRow(row);
            row = row - 1;
        }
    }

    // Submits both forms to include all fields
    function submit(){
        // Perform Form validation

        // What about if the other team doesn't get any points?
        document.getElementById('update').submit();
    }
    // Create team and player arrays from sql query
    <?php
    include('history-mysql.php');
    $sql = "SELECT DISTINCT team FROM history.Teams WHERE date > '2019-10-10' ORDER BY team ASC";
    $result = $conn->query($sql);

    $dbdata = [];
    if ($result->num_rows > 0) {
    // output data of each row
        while($row = $result->fetch_assoc()) {
            $teams[] = $row;
        }  
        echo "var teams = ".json_encode($teams).";";
    }
    else {
        echo "alert('problem loading teams');";
    }
    // Pull out any players that were registered since 2019 (auto populate on registration)
    $sql = "SELECT DISTINCT name, team, number FROM Players WHERE date > '2019' group by name, team, number ORDER BY name ASC";
    $result = $conn->query($sql);
    $players = [];
    if ($result->num_rows > 0) {
    // output data of each row
        while($row = $result->fetch_assoc()) {
            $players[] = $row; 
        }  
        echo "var players = ".json_encode($players).";";
    }
    else {
        echo "alert('problem loading players');";
    }  
    ?>

</script>

</html>
