//script for the display of dynamic information
//Identify what year the information belongs to
//Make these integers that are manually populated by using todays current date

var t = new Date();
var newSeason = 6; //Declare when season ends and switches over to new year (0-11 months)


var currentSeasonYear, lastSeasonYear
if (t.getMonth() > newSeason) {
    currentSeasonYear = t.getFullYear() + "/" + (t.getFullYear() + 1);
    lastSeasonYear = (t.getFullYear() - 1) + "/" + (t.getFullYear());
} else if (t.getMonth() < newSeason) {
    currentSeasonYear = (t.getFullYear() - 1) + "/" + t.getFullYear();
    lastSeasonYear = (t.getFullYear() - 2) + "/" + (t.getFullYear() - 1);
}

console.log("Current Season: " + currentSeasonYear);
console.log("Last Season: " + lastSeasonYear);

//update webpage year
//assign cy (current year) and ly (last year) array
var cy = [];
var ly = [];

//assign cy array to "currentSeasonYear" class
cy = document.getElementsByClassName("currentSeasonYear");

//for every class with "currentSeasonYear" apply current year date to innerHTML
for (var i = 0; i < cy.length; i++) {
    cy[i].innerHTML = currentSeasonYear;
}

//assign ly array to "lastSeasonYear" class
ly = document.getElementsByClassName("previousYear");

//for every tag with class "lastSeasonYear" apply last year date to innerHTML
for (var i = 0; i < ly.length; i++) {
    ly[i].innerHTML = lastSeasonYear;
}

// Season Winners
var previousYearWinners = "Belarus";
document.getElementById("seasonWinners").innerHTML = previousYearWinners;

//Supporting Picture
var champsPicture = "images/2017_winners.jpeg";
document.getElementById("featureImg").src = champsPicture;

//creates a simple drop down menu for mobile users
function displayMenu(open) {

    var menuButton = document.getElementById("menuButton");
    var navMenu = document.getElementById("nav");
    if (open == false) {
        menuButton.style = "display:none;";
        navMenu.style = "display:block;";
    }
    if (open == true) {
        menuButton.style = "display: block;";
        navMenu.style = "display:none;";
    }

}

// Determines next game day
function nextGame() {
    //get day of month from input and make it a mock day of month
    var t = new Date()
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
    g.push("<table border=1><th colspan=3>" + a + "</th>");
    g.push("<tr><td>7pm</td><td>Team 1</td><td>Team 2</td></tr>");
    g.push("<tr><td>8pm</td><td>Team 3</td><td>Team 4</td></tr>");
    g.push("<tr><td>9pm</td><td>Team 5</td><td>Team 6</td></tr></table>");
    var temp = g.join('');
    banner.innerHTML = temp;
    console.log('Next Game: ' + a);
    return a;
}


// Determines a schedule for the upcoming year
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
    g[i] = new Date(a.setHours(19, 0, 0));
    //console.log(g);
    //push to array or something
    return makeSchedule(a, ++i, g);
}



function schedule(g) {
    var x = 0;
    var regularSeason = [0, 1, 2, 3, 4, 5, 3, 5, 0, 2, 1, 4, 1, 5, 2, 4, 0, 3, 0, 4, 1, 3, 2, 5, 3, 4, 0, 5, 1, 2];
    var playoffs = [0, 5, 1, 4, 2, 3, 0, 4, 1, 3, 2, 5, 0, 3, 1, 2, 4, 5, 0, 2, 1, 5, 3, 4, 0, 1, 2, 4, 3, 5];
    mobileSchedule = document.getElementById('mobileSchedule');
    mobileTable = [];
    deskSchedule = document.getElementById('deskSchedule');
    deskTable = [];

    s = [];
    s[0] = new Date(g[i].setHours(19));
    s[1] = new Date(g[i].setHours(20));
    s[2] = new Date(g[i].setHours(21));

    var regGames = 15;
    for (var day = 0; day < regGames; day++) {

        mobileTable.push("<tr><th colspan='3'>" + g[day].toDateString() + "</th></tr>");
        deskTable.push("<tr><th rowspan='2'>" + g[day].toDateString() + "</th><th colspan='3'>7PM</th><th colspan='3'>8PM</th><th colspan='3'>9PM</th></tr><tr>");

        for (var hour = 0; hour < s.length; hour++) {
            if (x + 2 > regularSeason.length) {
                x = 0;
                console.log('reset');
            }
            mobileTable.push("<tr><th colspan='3'>" + s[hour].toLocaleTimeString() + "</th></tr>");
            if (day < 15) {
                mobileTable.push("<tr><td>" + (teamStats[regularSeason[x]].teams).toUpperCase() + "</td><td>vs</td><td>" + (teamStats[regularSeason[x + 1]].teams).toUpperCase() + "</td></tr>");
                deskTable.push("<td>" + (teamStats[regularSeason[x]].teams).toUpperCase() + "</td><td>vs</td><td>" + (teamStats[regularSeason[++x]].teams).toUpperCase() + "</td>");

            } else {
                mobileTable.push("<tr><td>" + (playoffs[x] + 1) + "</td><td>vs</td><td>" + (playoffs[x + 1] + 1) + "</td></tr>");
                deskTable.push("<td>" + (playoffs[x] + 1) + "</td><td>vs</td><td>" + (playoffs[++x] + 1) + "</td>");
            }
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
