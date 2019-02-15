<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<?php include_once('head.php') ?>

    <style>
        table {
            display: inline;
            text-align: left;
        }


        #playerImage {
            float: left;
            margin-left: 25px;
            border: 1px solid black;
            width: 200px;
            height: 200px;
        }

        award {
            font-size: 24pt;
            padding: 10px;
            margin: 20px;
            border: 1px solid black;
        }

    </style>

<body>
    <?php include_once('header.php'); ?>
    <div id='root'>
        <div id='overview'>
            <h2>Player Overview</h2>
            <img id='playerImage'>
            <table id='playerDetails' border=1>
                <tr>
                    <td>
                        <h3 id='playerNumber'>##</h3>
                    </td>
                    <td>
                        <h3 id='playerName'>Players Name</h3>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h2 id='currentTeam'>Team</h2>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3>Year Joined: </h3>
                    </td>
                    <td>
                        <h3 id='yearJoined'>####</h3>
                    </td>
                </tr>
            </table>
            <table id='playerStats' border=1>
                <tr>
                    <td colspan='2'>
                        <h3>Overview</h3>
                    </td>
                </tr>
                <tr>
                    <td>Goals: </td>
                    <td id='tGoals'>##</td>
                </tr>
                <tr>
                    <td>Assists: </td>
                    <td id='tAssists'>##</td>
                </tr>
                <tr>
                    <td>Points: </td>
                    <td id='tPoints'>##</td>
                </tr>
                <tr>
                    <td>Penatly Minutes: </td>
                    <td id='tPIM'>##</td>
                </tr>
            </table>
        </div>
        <hr>
        <div id='history'>
            <h2>History</h2>
            <table id='year1' border=1>
                <tr>
                    <td colspan='2'>
                        <h3>Year One</h3>
                    </td>
                </tr>
                <tr>
                    <td>Goals: </td>
                    <td id='tGoals'>##</td>
                </tr>
                <tr>
                    <td>Assists: </td>
                    <td id='tAssists'>##</td>
                </tr>
                <tr>
                    <td>Points: </td>
                    <td id='tPoints'>##</td>
                </tr>
                <tr>
                    <td>Penatly Minutes: </td>
                    <td id='tPIM'>##</td>
                </tr>
            </table>
            <table id='year2' border=1>
                <tr>
                    <td colspan='2'>
                        <h3>Year Two</h3>
                    </td>
                </tr>
                <tr>
                    <td>Goals: </td>
                    <td id='tGoals'>##</td>
                </tr>
                <tr>
                    <td>Assists: </td>
                    <td id='tAssists'>##</td>
                </tr>
                <tr>
                    <td>Points: </td>
                    <td id='tPoints'>##</td>
                </tr>
                <tr>
                    <td>Penatly Minutes: </td>
                    <td id='tPIM'>##</td>
                </tr>
            </table>
            <table id='year3' border=1>
                <tr>
                    <td colspan='2'>
                        <h3>Year three</h3>
                    </td>
                </tr>
                <tr>
                    <td>Goals: </td>
                    <td id='tGoals'>##</td>
                </tr>
                <tr>
                    <td>Assists: </td>
                    <td id='tAssists'>##</td>
                </tr>
                <tr>
                    <td>Points: </td>
                    <td id='tPoints'>##</td>
                </tr>
                <tr>
                    <td>Penatly Minutes: </td>
                    <td id='tPIM'>##</td>
                </tr>
            </table>
        </div>
        <hr>
        <div id='awards'>
            <h2>Awards</h2>
            <award>A</award>
            <award>A</award>
            <award>A</award>
            <award>A</award>
        </div>
        <hr>
        <div id='trends'>
            <h2>Trends</h2>
        </div>
    </div>
</body>
