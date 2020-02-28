<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<?php include_once('head.php') ?>

<body onload="schedule(g);">
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
        <!-- SCHEDULE -->
        <div id="schedule" class="section">
            <h1>SCHEDULE</h1>
            <h5 class='currentSeasonYear'></h5>
            <h5>GAME SCHEDULE</h5>

            <!--            <a class="button" target="_blank" href="printschedule.html">Print Schedule</a>
-->
            <table name="schedule_table" class='desktop' id="deskSchedule" title='futureGames' cellpadding='0' cellspacing='0'>
                <tr>
                    <th rowspan="2">Date</th>
                    <th colspan="3">7PM</th>
                    <th colspan="3">8PM</th>
                    <th colspan="3">9PM</th>
                </tr>
                <tr>
                    <td>7home</td>
                    <td>vs</td>
                    <td>7away</td>
                    <td>8home</td>
                    <td>vs</td>
                    <td>8away</td>
                    <td>9home</td>
                    <td>vs</td>
                    <td>9away</td>
                </tr>

            </table>
            <table id='mobileSchedule' class='mobile' title="futureGames">
                <tr>
                    <th colspan='3'>Date</th>
                </tr>
                <tr>
                    <th colspan='3'>7PM</th>
                </tr>
                <tr>
                    <td>7home</td>
                    <td>vs</td>
                    <td>7away</td>
                </tr>
                <tr>
                    <th colspan='3'>8PM</th>
                </tr>
                <tr>
                    <td>8home</td>
                    <td>vs</td>
                    <td>8away</td>
                </tr>
                <tr>
                    <th colspan='3'>9PM</th>
                </tr>
                <tr>
                    <td>9home</td>
                    <td>vs</td>
                    <td>9away</td>
                </tr>
            </table>
            <div class='tablet' id='nextgame' onclick="schedule(g, true);">See Full Schedule</div>
        </div>

    </div>
</body>

<!--Import teamStats and Player databases-->
<script src='leagueSummary.js'></script>
<script src='teamStats.js'></script>
<script src="functions.js"></script>
<script>
    // Recursive function to determine schedule for the upcoming year skipping christmas/ new years and super bowl sunday (first sunday of february)
    var a = new Date();

    // Every season starts the week after thanksgiving
    // Is there a source that would provide a date for thanksgiving every year?
    a.setFullYear(currentSeasonYear.split('/')[0], 9, 14);

    var i = 0;
    g = [];

    function makeSchedule(a, i, g) {

        var b = 7 - a.getDay();
        var c = a.getDate();
        a.setDate(b + c);

        if ((a.getMonth() == 11 && a.getDate() > 23) || (a.getMonth() == 0 && a.getDate() < 2)) {
            // Skip week for Christmas (Could be improved)
            return makeSchedule(a, i, g);
        } else if (a.getMonth() == 1 && a.getDate() < 7) {
            // Skip week for Super Bowl Sunday
            return makeSchedule(a, i, g);
        }
        // Stop after 22 weeks of games have been generated
        if (i == 22) {
            console.log('Schedule Generated');
            return;
        }
        // define next game date as 7pm
        g[i] = new Date(a.setHours(19, 0, 0));
        
        return makeSchedule(a, ++i, g);
    }


    function schedule(g, fold = false) {
        var x = 0;
        var games = 22;
        var curr = false;
        
        // Game Patterns
        var regularSeason = [0, 1, 2, 3, 4, 5, 3, 5, 0, 2, 1, 4, 1, 5, 2, 4, 0, 3, 0, 4, 1, 3, 2, 5, 3, 4, 0, 5, 1, 2, 2, 3, 4, 5, 0, 1, 0, 2, 1, 4, 3, 5, 2, 4, 0, 3, 1, 5, 1, 3, 2, 5, 0, 4, 0, 5, 1, 2, 3, 4, 4, 5, 0, 1, 2, 3, 1, 4, 3, 5, 0, 2, 0, 3, 1, 5, 2, 4, 2, 5, 0, 4, 1, 3, 1, 2, 3, 4, 0, 5];
        
        var roundRobin = [0, 5, 1, 4, 2, 3, 0, 4, 1, 3, 2, 5, 0, 3, 1, 2, 4, 5, 0, 2, 1, 5, 3, 4, 0, 1, 2, 4, 3, 5];
        
        var playoffs = [0, 3, 1, 2];

        //update via php from last seasons finals
        var teams = ['Stayner', 'Coates Creek', 'Herbtown', 'Belarus', 'New Lowell', 'Cashtown'];
        <?php
        

        ?>
        // update via php from seasons regular seasons standings
        var rrteams = ['New Lowell Hawks', 'Belarus', 'Coates Creek', 'Stayner', 'Cashtown', 'Herbtown'];
        
        // update via php from seasons roundrobin standings
        var playoffteams = ['1st', '2nd', '3rd', '4th'];

        // Update via php from seasons playoffs
        var championshipteams = ['1st', '2nd'];

        var mobileSchedule = document.getElementById('mobileSchedule');
        var mobileTable = [];
        var deskSchedule = document.getElementById('deskSchedule');
        var deskTable = [];
        var s = [];

        s[0] = new Date(g[i].setHours(19));
        s[1] = new Date(g[i].setHours(20));
        s[2] = new Date(g[i].setHours(21));

        for (var day = 0; day < games; day++) {
            if (g[day] > t) {
                fold = true;
            }
            switch (day) {
                case 0:
                    deskTable.push("<tr><th colspan='10'>Regular Season</th></tr>");
                    deskTable.push("<tr><th>Date</th><th colspan='3'>7PM</th><th colspan='3'>8PM</th><th colspan='3'>9PM</th></tr>");
                    if (fold) {
                        mobileTable.push("<tr><th colspan='3'><h3>Regular Season</h3></th></tr>");
                    }
                    break;
                case 10:
                    // This is for christmas and could vary from one year to the next between week 10 and 11
                    deskTable.push("<tr><th colspan='10'>Happy Holidays</th></tr>");
                    if (fold) {
                        mobileTable.push("<tr><th colspan='3'>Happy Holidays</th></tr>");
                    }
                    break;

                case 15:
                    deskTable.push("<tr><th  colspan='10'>Round Robin</th></tr>");

                    if (fold) {
                        mobileTable.push("<tr><th colspan='3'><h3>Round Robin</h3></th></tr>");
                    }
                    break;
                case 20:
                    deskTable.push("<tr><th  colspan='10'>Playoffs</th></tr>");
                    if (fold) {
                        mobileTable.push("<tr><th colspan='3'><h3>Playoffs</h3></th></tr>");

                    }
                    break;
            }

            if (fold) {
                if (g[day] > t && !curr && fold) {
                    console.log('Next: ' + g[day]);
                    mobileTable.push("<tr><td id='mtoday' colspan='3'><h3>Next Game</h3></td></tr>");
                    deskTable.push("<tr><td id='dtoday' colspan='10'>Next Game</td></tr>");
                    curr = true;
                }
            }
            if (fold) {
                mobileTable.push("<tr><th colspan='3'>" + g[day].toDateString() + "</th></tr>");
            }
            deskTable.push("<tr class='regSeason'><th rowspan='1'>" + g[day].toDateString() + "</th>");
            j = 0;
            for (var hour = 0; hour < s.length; hour++) {
                if (x + 2 > regularSeason.length) {
                    x = 0;
                    console.log('reset');
                }
                if (day <= 14) {
                    if (fold) {
                        mobileTable.push("<tr class='regSeason'><th colspan='3'>" + s[hour].toLocaleTimeString() + "</th></tr>");
                        mobileTable.push("<tr class='regSeason'><td>" + (teams[regularSeason[x]]).toUpperCase() + "</td><td>vs</td><td>" + (teams[regularSeason[x + 1]]).toUpperCase() + "</td></tr>");
                    }
                    deskTable.push("<td>" + (teams[regularSeason[x]]).toUpperCase() + "</td><td>vs</td><td>" + (teams[regularSeason[++x]]).toUpperCase() + "</td>");
                } else if (day > 14 && day < 20) {
                    if (fold) {
                        mobileTable.push("<tr class='roundRobin'><th colspan='3'>" + s[hour].toLocaleTimeString() + "</th></tr>");
                        mobileTable.push("<tr class='roundRobin'><td>" + (rrteams[roundRobin[x]]) + "</td><td>vs</td><td>" + (rrteams[roundRobin[x + 1]]) + "</td></tr>");
                    }
                    deskTable.push("<td>" + (rrteams[roundRobin[x]]) + "</td><td>vs</td><td>" + (rrteams[roundRobin[++x]]) + "</td>");
                } else {
                    if (fold) {
                        // SEMI-FINALS
                        if (hour < 2 && day != 21) {

                            mobileTable.push("<tr class='playoff'><th colspan='3'>" + s[hour].toLocaleTimeString() + "</th></tr>");
                            mobileTable.push("<tr class='playoff'><td>" + playoffteams[playoffs[j]] + "</td><td>vs</td><td>" + playoffteams[playoffs[j+1]] + "</td></tr>");
                            
                        }

                        // CHAMPIONSHIP GAME Mobile
                        else if (hour < 1) {
                            mobileTable.push("<tr class='semifinals'><th colspan='3'><h3>Finals</h3></th></tr>");
                            mobileTable.push("<tr class='playoff'><th colspan='3'>" + s[hour].toLocaleTimeString() + "</th></tr>");
                            mobileTable.push("<tr class='playoff'><td><h4>"+championshipteams[j]+"</h4></td><td>vs</td><td><h4>"+championshipteams[j+1]+"</h4></td></tr>");
                        }

                    }
                    // SEMI-FINALS
                    if (hour < 2 && day != 21) {
                        deskTable.push("<td>" + playoffteams[playoffs[j]] + "</td><td>vs</td><td>" + playoffteams[playoffs[++j]] + "</td>");
                    }
                    
                    // CHAMPIONSHIP Desktop
                    else if (hour < 1){
                        deskTable.push("<td>"+championshipteams[j]+"</td><td>vs</td><td>"+championshipteams[++j]+"</td>")
                    }
                }

                // Code in playoffs based on results of round robin
                ++x;
                ++j;
            }
            deskTable.push("</tr>");

        }
        var mobiletemp = mobileTable.join('');
        var desktemp = deskTable.join('');
        mobileSchedule.innerHTML = mobiletemp;
        deskSchedule.innerHTML = desktemp;
        return;
    }
    
//    Create a calendar form that will create a list of all the games for that season. 
    
   makeSchedule(a, i, g);
//    schedule(g);


    function nextgame() {
        var ng = document.getElementById('mtoday');
        ng.scrollIntoView();
        window.scrollBy(0, -100);
    }

</script>
</html>
