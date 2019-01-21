// Script for the display of dynamic information
// Identify what year the information belongs to
// Make these integers that are manually populated by using todays current date

// Define Date of page instance
var t = new Date();
// Declare when season ends and switches over to new year (0-11 months)
var newSeason = 6;

// Create variables for the current year and previous year to dynamically update with the changing seasons based on the date of the page instance
var currentSeasonYear, lastSeasonYear
if (t.getMonth() > newSeason) {
    currentSeasonYear = t.getFullYear() + "/" + (t.getFullYear() + 1);
    lastSeasonYear = (t.getFullYear() - 1) + "/" + (t.getFullYear());
} else if (t.getMonth() < newSeason) {
    currentSeasonYear = (t.getFullYear() - 1) + "/" + t.getFullYear();
    lastSeasonYear = (t.getFullYear() - 2) + "/" + (t.getFullYear() - 1);
}

// Double check
console.log("Current Season: " + currentSeasonYear);
console.log("Last Season: " + lastSeasonYear);

// Update webpage year
// Assign cy (current year) and ly (last year) array
var cy = [];
var ly = [];

// Assign cy array to "currentSeasonYear" class
cy = document.getElementsByClassName("currentSeasonYear");

// For every class with "currentSeasonYear" apply current year date to innerHTML
for (var i = 0; i < cy.length; i++) {
    cy[i].innerHTML = currentSeasonYear;
}

// Assign ly array to "lastSeasonYear" class
ly = document.getElementsByClassName("previousYear");

// For every tag with class "lastSeasonYear" apply last year date to innerHTML
for (var i = 0; i < ly.length; i++) {
    ly[i].innerHTML = lastSeasonYear;
}

// Season Winners
var previousYearWinners = "Belarus";
document.getElementById("seasonWinners").innerHTML = previousYearWinners;

//Supporting Picture
var champsPicture = "images/2017_winners.jpeg";
document.getElementById("featureImg").src = champsPicture;

// End season instance update 

// Drop down menu for mobile users
function displayMenu(open) {
    // Define button content and menu content
    var menuButton = document.getElementById("menuButton");
    var navMenu = document.getElementById("nav");

    // If menu is closed, dispay menu and hide button
    if (open == false) {
        menuButton.style = "display:none;";
        navMenu.style = "display:block;";
    }

    // If menu is already open, hide menu and display button
    if (open == true) {
        menuButton.style = "display: block;";
        navMenu.style = "display:none;";
    }

}

// Determines next game day
function nextGame() {
    // Get day of the month of page instance
    t.getDate()
    //use input "mock Day" to set todays date
    var a = new Date(t);
    //determine the number of days till next sunday
    var b = 7 - a.getDay();
    //determine what day of the month it is
    var c = a.getDate();
    //add difference till next sunday to day of the month
    a.setDate(b + c);
    a.setHours(19, 0, 0);
    //Use new day of month to print date of next sunday
    var banner = document.getElementById('nextGame');
    var g = [];

    g.push("<table border='0'><th colspan=3>" + a.toDateString() + "</th>");
    g.push("<tr><td>7pm</td><td>Team 1 vs.</td><td>Team 2</td></tr>");
    g.push("<tr><td>8pm</td><td>Team 3 vs.</td><td>Team 4</td></tr>");
    g.push("<tr><td>9pm</td><td>Team 5 vs.</td><td>Team 6</td></tr></table>");
    var temp = g.join('');
    banner.innerHTML = temp;
    console.log('Next Game: ' + a);
    return a;
}


// Recursive function to determine schedule for the upcoming year skipping christmas/ new years and super bowl sunday (first sunday of february)
var a = new Date();
var i = 0;
a.setFullYear(currentSeasonYear.split('/')[0], 9, 10);
g = [];

function makeSchedule(a, i, g) {

    var b = 7 - a.getDay();
    var c = a.getDate();
    a.setDate(b + c);

    if ((a.getMonth() == 11 && a.getDate() > 23) || (a.getMonth() == 0 && a.getDate() < 2)) {
        console.log("Happy Holidays");
        return makeSchedule(a, i, g);
    } else if (a.getMonth() == 1 && a.getDate() < 7) {
        console.log("Superbowl Sunday");
        return makeSchedule(a, i, g);
    }
    if (i == 22) {
        console.log('Done');
        return;
    }
    console.log(i);
    g[i] = new Date(a.setHours(19, 0, 0));
    //console.log(g);
    //push to array or something
    return makeSchedule(a, ++i, g);
}

function schedule(g) {
    var x = 0;
    var regularSeason = [0,1,2,3,4,5,3,5,0,2,1,4,1,5,2,4,0,3,0,4,1,3,2,5,3,4,0,5,1,2,2,3,4,5,0,1, 0,2,1,4,3,5,2,4,0,3,1,5,1,3,2,5,0,4,0,5,1,2,3,4,4,5,0,1,2,3,1,4,3,5,0,2,0,3,1,5,2,4,2,5,0,4,1,3,1,2,3,4,0,5];
    var roundRobin = [0, 5, 1, 4, 2, 3, 0, 4, 1, 3, 2, 5, 0, 3, 1, 2, 4, 5, 0, 2, 1, 5, 3, 4, 0, 1, 2, 4, 3, 5];
    var playoffs = [];
    mobileSchedule = document.getElementById('mobileSchedule');
    mobileTable = [];
    deskSchedule = document.getElementById('deskSchedule');
    deskTable = [];

    s = [];
    s[0] = new Date(g[i].setHours(19));
    s[1] = new Date(g[i].setHours(20));
    s[2] = new Date(g[i].setHours(21));

    var games = 22;

    for (var day = 0; day < games; day++) {
        switch (day) {
            case 0:
                deskTable.push("<tr><th colspan='10'>Regular Season</th></tr>");
                deskTable.push("<tr><th>Date</th><th colspan='3'>7PM</th><th colspan='3'>8PM</th><th colspan='3'>9PM</th></tr>");
                mobileTable.push("<tr><th colspan='3'>Regular Season</th></tr>");
                break;
            case 11:
                deskTable.push("<tr><th colspan='10'>Happy Holidays</th></tr>");
                mobileTable.push("<tr><th colspan='3'>Happy Holidays</th></tr>");
                break;

            case 15:
                deskTable.push("<tr><th  colspan='10'>Round Robin</th></tr>");
                mobileTable.push("<tr><th colspan='3'><h3>Round Robin</h3></th></tr>");
                break;
            case 20:
                deskTable.push("<tr><th  colspan='10'>Playoffs</th></tr>");
                mobileTable.push("<tr><th colspan='3'><h3>Playoffs</h3></th></tr>");
                break;


        }
        mobileTable.push("<tr><th colspan='3'>" + g[day].toDateString() + "</th></tr>");
        deskTable.push("<tr class='regSeason'><th rowspan='1'>" + g[day].toDateString() + "</th>");

        for (var hour = 0; hour < s.length; hour++) {
            if (x + 2 > regularSeason.length) {
                x = 0;
                console.log('reset');
            }

            if (day < 15) {
                mobileTable.push("<tr class='regSeason'><th colspan='3'>" + s[hour].toLocaleTimeString() + "</th></tr>");
                mobileTable.push("<tr class='roundRobin'><td>" + (teamStats[regularSeason[x]].teams).toUpperCase() + "</td><td>vs</td><td>" + (teamStats[regularSeason[x + 1]].teams).toUpperCase() + "</td></tr>");
                deskTable.push("<td>" + (teamStats[regularSeason[x]].teams).toUpperCase() + "</td><td>vs</td><td>" + (teamStats[regularSeason[++x]].teams).toUpperCase() + "</td>");
            } else {
                mobileTable.push("<tr class='roundRobin'><th colspan='3'>" + s[hour].toLocaleTimeString() + "</th></tr>");
                mobileTable.push("<tr class='roundRobin'><td>" + (roundRobin[x] + 1) + "</td><td>vs</td><td>" + (roundRobin[x + 1] + 1) + "</td></tr>");
                deskTable.push("<td>" + (roundRobin[x] + 1) + "</td><td>vs</td><td>" + (roundRobin[++x] + 1) + "</td>");
            }
            
            // Code in playoffs based on results of round robin
            
            ++x;

        }
        deskTable.push("</tr>");


    }
    var mobiletemp = mobileTable.join('');
    var desktemp = deskTable.join('');
    mobileSchedule.innerHTML = mobiletemp;
    deskSchedule.innerHTML = desktemp;
    return;
}
