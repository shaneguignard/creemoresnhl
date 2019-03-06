<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <title>Score Sheet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        #root td{
            display: block;
        }
    </style>
</head>

<body>
    <form id='form' method='POST' action='scoresheet.php'>
        <table id="root" border=0>
            <thead>
                <h1>Creemore Sunday Night Hockey</h1>
            </thead>
            <tr>
                <td>Game: <input type="text" name='gamenum' read-only></td>
            </tr>
            <tr>
                <td>
                    Date: <input type="text" name="gameDate" read-only>

                </td>
                <td>
                    Time: <input type='time' name='gameTime' read-only>
                </td>
                <td>
                    Arena: <input type="text" name="playedAt" placeholder="arena" value="Creemore Arena"></td>

            </tr>
            <tr>
                <td>
                    <input type="text" name="timekeepername" placeholder="Name of TimeKeeper">
                </td>
                <td colspan="2">
                    <input type="password" name="timekeeperpwd" placeholder="Password">
                </td>
            </tr>
        </table>
        <h3>Summary</h3>

        <hr>
        <table id='summary' border=1>
            <tr>
                <th>Time (mm:ss)</th>
                <th>Period</th>
                <th>Type</th>
                <th>Team</th>
                <th>Player</th>
                <th></th>
                <th></th>
            </tr>
            <tbody id="newRecord">
                <tr class='rows'>
                    <td></td>
                    <td><select id='period' style='width:50px; text-align:center;' type='text'>
                            <option value='1'>1</option>
                            <option value='2'>2</option>
                            <option value='3'>3</option>
                        </select></td>
                    <td>
                        <select id="pointType">
                            <option value='Goal'>Goal</option>
                            <option value='Assist'>Assist</option>
                            <option value='Penalty'>Penalty</option>
                        </select>
                    </td>
                    <td>
                        <!-- The player list should update whenever a new team is selected-->
                        <select name='team' id="teams" onchange="document.getElementById('form').submit();">
                            <?php
                        include('history-mysql.php');
                        $sql = "SELECT DISTINCT team FROM history.Teams ORDER BY team ASC";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        // output data of each row
                            while($row = $result->fetch_assoc()) {
                                if($row['team'] == $_POST['team']){
                                    echo "<option selected>{$row['team']}</option>";
                                }
                                else{
                                    echo "<option>{$row['team']}</option>";
                                    
                                }
                            }  
                        }
                        else {
                            echo "<option>Problem Connecting To Team Server</option>";
                        } 
                        ?>
                        </select>
                    </td>

                    <td>
                        <select name='player' id='players'>
                            <?php
                        include_once('history-mysql.php');
                        $sql = "SELECT DISTINCT name FROM Players WHERE team = '{$_POST['team']}' ORDER BY name ASC";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        // output data of each row
                            while($row = $result->fetch_assoc()) {
                                
                                echo "<option>{$row['name']}</option>";
                            }  
                        }
                        else {
                            echo "<option>Problem Connecting To {$_POST['team']} Server</option>";
                        }  
                        ?>
                        </select>
                    </td>
                    <td><input type='button' value="Add" onclick="add(period.value, pointType.value, teams.value, players.value);"></td>
                    <td><input id='undo' type='button' onclick="myUndo();" value='Undo'></td>
                </tr>
            </tbody>
        </table>
    </form>
    <form id='summary' method='post' action='gamesheet.php'>
        <table>
<!--  

Update players onchange, but submit to server on ADD. Then display the results as query since game date;

-->
            <tbody id='records'>
                <?php 
                    if($_POST['team'].length > 1)
                    {
                        echo "<tr><td>We have an array</td></tr>";
                    }
                ?>
            </tbody>
        </table>

        <input type="submit" value="End Game" style="margin-top:10px;">
    </form>
</body>

<script>
    var row = 1; // defines row
    var d = new Date();
    var gamedate = document.getElementsByName('gameDate')[0];
    var gametime = document.getElementsByName('gameTime')[0];
    var dd = d.getDate();
    var mm = d.getMonth() + 1;
    var yyyy = d.getFullYear();
    gamedate.value = yyyy + '-' + mm + '-' + dd;
    var points = [];
    var id = 0;

    var record = document.getElementById("records");

    var players = [];
    var teams = [];
    //    var sides = ['light', 'dark'];

    //O(1)
    function add(period, type, team, player) {
        console.log(d, period, type, team, player);
        var body = document.getElementsByTagName('body')[0];
        var popup = document.getElementById('popup');
        var time = new Date();
        var point = '';
        var newRecord = document.getElementById('newRecord').innerHTML;
        //        if (type == "Shot") {
        //            if (side == "light") {
        //                lightShots++;
        //                player = '-';
        //                document.getElementById("lightShots").innerHTML = lightShots;
        //                console.log(side, type, team, player, lightShots);
        //            }
        //            if (side == "dark") {
        //                darkShots++;
        //                player = '-'
        //                document.getElementById("darkShots").innerHTML = darkShots;
        //                console.log(side, type, team, player, darkShots);
        //            }
        //        }
        //        if (type == "Goal") {
        //            if (side == "light") {
        //                lightGoals++;
        //                document.getElementById("lightScore").value = lightGoals;
        //                console.log(side, type, team, player, lightGoals);
        //            }
        //            if (side == "dark") {
        //                darkGoals++;
        //                document.getElementById("darkScore").value = darkGoals;
        //                console.log(side, type, team, player, darkGoals);
        //            }
        //        }

        if (time.getHours() < 12) {
            time = (time.toLocaleTimeString()).replace(' AM', '');
        } else {
            time = (time.toLocaleTimeString()).replace(' PM', '');
        }

        //Populate 
        var newPoint = '<tr><td><input type="time" name="eventTime[]" value="' + time + '"></td><td><input style="width:50px;" type="text" name="period[]" value="' + period + '"></td><td><input style="width:50px;" type="text" name="type[]" value="' + type + '" readonly></td><td><input type="text" name="team[]" value="' + team + '"></td><td><input type="text" name="player[]" value="' + player + '"></td><td colspan ="2"><input type="button" onclick="del(' + row + ');" value="Delete"></td></tr>';
        row++;

        // Edits made in summary are not perminent after new point is added to list.

        points.push(newPoint);
        var temp = points.join('');
        record.innerHTML = temp;
        id++;
        return

    }

    function del(currow) {
        //        console.log("delete row: " + currow)
        //        points.splice(currow, 1);
        //        document.getElementById('summary').deleteRow(currow);
        //        row = row - 1;
        alert("delete row # " + currow);
    }

    function myUndo() {
        if (row > 0) {
            points.pop();
            document.getElementById('summary').deleteRow(row);
            row = row - 1;

            //            lightShots = 0;
            //            lightGoals = 0;
            //            darkShots = 0;
            //            darkGoals = 0;
        }
    }

</script>

</html>
