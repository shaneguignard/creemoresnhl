//script for the display of dynamic information


//Identify what year the information belongs to

//Make these integers that are manually populated by using todays current date

var t = new Date();
var newSeason = 6 //Declare when season ends and switches over to new year (0-11 months)

var currentSeasonYear, lastSeasonYear
if (t.getMonth()>newSeason){
	currentSeasonYear = t.getFullYear() + "/" + (t.getFullYear() + 1);
	lastSeasonYear = (t.getFullYear() - 1) + "/" + (t.getFullYear());
}
else if(t.getMonth() <newSeason) {
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



//Schedule.js 





//Define months of the year. 

var month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];



var deskSchedule = [];

var mobileSchedule = [];

var game = [];

var gd = [];

var gameDay = [];

var gameMon = [];

var gameYear = [];

var gameDate = [];



var foundgame = 0;


function schedule_desk() {

    $.ajax({

        type: "GET",

        // Call Json file
		// find a way to load text file
        url: t.getFullYear() + "/schedule.csv",

        //Declare Json data type

        dataType: "json",

        cache: false,

        contentType: "application/json",

        //Function launched if data is loaded successfully from JSON file specified above

        success: function (data) {
			console.log("schedule: " + data)
            if (data) {

                deskSchedule.push("<tr><th></th><th colspan='3'>7:00PM</th><th colspan='3'>8:00PM</th><th colspan='3'>9:00PM</th></tr> <tr><th>Date</th><th>Home</th><th></th><th>Away</th><th >Home</th><th></th><th>Away</th><th>Home</th><th></th><th>Away</th></tr>");



                for (i = 2; i < data.length; i++) {



                    gd[i] = data[i][0] - 25568;

                    gd[i] = gd[i] * 24 * 60 * 60 * 1000;

                    gameDay[i] = new Date(gd[i]).getDate();

                    gameMon[i] = new Date(gd[i]).getMonth();

                    gameYear[i] = new Date(gd[i]).getFullYear();

                    gameDate[i] = month[gameMon[i]] + ' ' + gameDay[i] + ', ' + gameYear[i];



                    if (data[i][1] == '') {

                        break;

                    }

                    deskSchedule.push("<tr><th>" + gameDate[i] + "</th><td class='" + data[i][1] + "'>" + data[i][1] + "</td><td>vs</td><td class='" + data[i][3] + "'>" + data[i][3] + "</td><td class='" + data[i][5] + "'>" + data[i][5] + "</td><td>vs</td><td class='" + data[i][7] + "'>" + data[i][7] + "</td><td class='" + data[i][9] + "'>" + data[i][9] + "</td><td>vs</td><td class='" + data[i][11] + "'>" + data[i][11] + "</td></tr>");



                    mobileSchedule.push("<tr><th colspan='3'>" + gameDate[i] + "</th></tr><tr><th colspan='3'>7PM</th></tr><tr><td>" + data[i][1] + "</td><td>vs</td><td>" + data[i][3] + "</td></tr><tr><th colspan='3'>8PM</th></tr><tr><td>" + data[i][5] + "</td><td>vs</td><td>" + data[i][7] + "</td></tr><tr><th colspan='3'>9PM</th></tr><tr><td>" + data[i][9] + "</td><td>vs</td><td>" + data[i][11] + "</td></tr>");

                }

            }

            var mobileResults = mobileSchedule.join('');

            var results = deskSchedule.join('');

            document.getElementById('schedule_table').innerHTML = results;

            document.getElementById('mobileSchedule').innerHTML = mobileResults;

            return

        },



        //Function launched if data  loaded from JSON file contains errors

        error: function (jqXHR, textStatus, errorThrown) {

            //Outputs Error Status information in console

            console.log('ERROR', textStatus, errorThrown);

        }

    });

}



var nextGameArray = [];

function loadNextGame() {

    //perform Json parse using Jquery

    $.ajax({

        type: "GET",

        // Call Json file

        url: "data/gamestats.json",

        //Declare Json data type

        dataType: "json",

        cache: false,

        contentType: "application/json",

        //Function launched if data is loaded successfully from JSON file specified above

        success: function (data) {

            for (i = 0; i < data.length; i++) {

                gd[i] = data[i][0] - 25568;

                gd[i] = gd[i] * 24 * 60 * 60 * 1000;

                gameDay[i] = new Date(gd[i]).getDate();

                gameMon[i] = new Date(gd[i]).getMonth();

                gameYear[i] = new Date(gd[i]).getFullYear();

                gameDate[i] = month[gameMon[i]] + ' ' + gameDay[i] + ', ' + gameYear[i];



                var today = new Date().getTime();

                if (gd[i] >= today) {

                    nextGameArray.push('Next Game <br>' + gameDate[i], data[i][1] + " vs " + data[i][3], data[i][5] + " vs " + data[i][7], data[i][9] + " vs " + data[i][11])

                    foundgame = 1;
					console.log(nextGameArray, found)
                    break;

                }



            }

            if (nextGameArray.length > 0) {

                var result = nextGameArray.join('');

                document.getElementById('nextGame').innerHTML = result;

                console.log(nextGameArray);

            } else {

                document.getElementById('nextGame').innerHTML = "No Upcoming Games";

                console.log('no games');

            }

            return

            //            document.getElementById('buttonArea').innerHTML = "<a class='button' onclick='fullSchedule()'>Load The Full Schedule</a>";

        },

        //Function launched if data  loaded from JSON file contains errors

        error: function (jqXHR, textStatus, errorThrown) {

            //Outputs Error Status information in console

            console.log('ERROR', textStatus, errorThrown);



        }

    });

}







function highlight(team) {



    /*MAKE SWITCH CASE STATEMENT SO THAT IF TEAM = CASE THEN CHANGE COLOURS TO SPECIFIC TEAMS COLOURS*/

    var elements = document.getElementsByClassName(team);

    for (var i = 0; i < elements.length; i++) {

        elements[i].style = "background:black; color: gold;"

    }

}



function dehighlight(team) {

    /*MAKE SWITCH CASE STATEMENT SO THAT IF TEAM = CASE THEN CHANGE COLOURS TO SPECIFIC TEAMS COLOURS*/

    var elements = document.getElementsByClassName(team);

    for (var i = 0; i < elements.length; i++) {

        elements[i].style = ""

    }

}

deskGameStats = [];

function gamestats() {



    $.ajax({

        type: "GET",

        // Call Json file

        url: "data/gamestats.json",

        //Declare Json data type

        dataType: "json",

        cache: false,

        contentType: "application/json",

        //Function launched if data is loaded successfully from JSON file specified above

        success: function (data) {

            if (data) {



                deskGameStats.push("<tr><th></th><th colspan='4'>7:00PM</th><th colspan='4'>8:00PM</th><th colspan='4'>9:00PM</th></tr> <tr><th>Date</th><th colspan='2'>Home</th><th colspan ='2'>Away</th><th colspan='2'>Home</th><th colspan ='2'>Away</th><th colspan='2'>Home</th><th colspan ='2'>Away</th></tr>");



                for (i = 2; i < data.length; i++) {



                    gd[i] = data[i][0] - 25568;

                    gd[i] = gd[i] * 24 * 60 * 60 * 1000;

                    gameDay[i] = new Date(gd[i]).getDate();

                    gameMon[i] = new Date(gd[i]).getMonth();

                    gameYear[i] = new Date(gd[i]).getFullYear();

                    gameDate[i] = month[gameMon[i]] + ' ' + gameDay[i] + ', ' + gameYear[i];

                    if (data[i][2] != '') {

                        deskGameStats.push("<tr><td><b>" + gameDate[i] + "</b></td><td>" + data[i][1] + "</td><td>" + data[i][2] + "</td><td>" + data[i][4] + "</td><td>" + data[i][3] + "</td><td>" + data[i][5] + "</td><td>" + data[i][6] + "</td><td>" + data[i][8] + "</td><td>" + data[i][7] + "</td><td>" + data[i][9] + "</td><td>" + data[i][10] + "</td><td>" + data[i][12] + "</td><td>" + data[i][11] + "</td></tr>");

                    }

                }

            }



            var results = deskGameStats.join('');

            document.getElementById('deskGamesPast').innerHTML = results;

            return

        },



        //Function launched if data  loaded from JSON file contains errors

        error: function (jqXHR, textStatus, errorThrown) {

            //Outputs Error Status information in console

            console.log('ERROR', textStatus, errorThrown);

        }

    });

}



/*

days between 1900 and 1970 is 25569

Calculating date is done by subtracting 25569 from the value provided by excel and then putting it into milliseconds for date('valueinmillisec').getTime()

this will give us the games date.

gd = 

d = 15998.1666666

*/









//Stats.js



var statsArray = [];

var teamStatsArray = [];

var rrteamStatsArray = [];

var player, goals, assits, points, pim, team = [];

date = new Date();



function playerStats() {

    $.ajax({

        type: "GET",

        // Call Json file

        url: "data/stats.json",

        //Declare Json data type

        dataType: "json",

        cache: false,

        contentType: "application/json",

        //Function launched if data is loaded successfully from JSON file specified above

        success: function (data) {



            for (i = 0; i < data.length; i++) {

                player[i] = data[i]["Player Name"];

                goals[i] = data[i]["G"];

                assists[i] = data[i]["A"];

                points[i] = data[i]["Pts"];

                pim[i] = data[i]["PIM"];

                team[i] = data[i]["Team"];

                switch (team[i]) {

                    case "Belarus":

                        team[i] = 'Belarus';

                        break;

                    case "Cash":

                        team[i] = 'Cashtown';

                        break;

                    case "Stayner":

                        team[i] = 'Stayner';

                        break;

                    case "NL":

                        team[i] = 'New Lowell';

                        break;

                    case "CC":

                        team[i] = 'Coates Creek';

                        break;

                    case "Garner":

                        team[i] = 'Garner';

                        break;

                }

                if (i == 0) {

                    statsArray.push("<tr><th>" + player[i] + "</th><th>" + team[i] + "</th><th>" + goals[i] + "</th><th>" + assists[i] + "</th><th>" + points[i] + "</th><th>" + pim[i] + "</th></tr>");

                } else {

                    statsArray.push("<tr><td>" + i + ". <b>" + player[i] + "</b></td><td>" + team[i] + "</td><td>" + goals[i] + "</td><td>" + assists[i] + "</td><td>" + points[i] + "</td><td>" + pim[i] + "</td></tr>");

                }

            }

            var stats = statsArray.join('');

            return document.getElementById('stats_table').innerHTML = stats;

        },

        //Function launched if data  loaded from JSON file contains errors

        error: function (jqXHR, textStatus, errorThrown) {

            //Outputs Error Status information in console

            console.log('ERROR', textStatus, errorThrown);

        }

    });

}



function teamStats() {

    $.ajax({

        type: "GET",

        // Call Json file

        url: "data/teamstats.json",

        //Declare Json data type

        dataType: "json",

        cache: false,

        contentType: "application/json",

        //Function launched if data is loaded successfully from JSON file specified above

        success: function (data) {



            for (i = 0; i < data.length; i++) {

                if (i == 0) {

                    teamStatsArray.push("<tr><th><b>" + data[i]["Team"] + "</b></th><th>" + data[i]["GP"] + "</th><th>" + data[i]["W"] + "</th><th>" + data[i]["L"] + "</th><th>" + data[i]["T"] + "</th><th>" + data[i]["PTS"] + "</th><th>" + data[i]["GF"] + "</th><th>" + data[i]["GA"] + "</th><th>" + data[i]["+/-"] + "</th></tr>");

                } else {

                    teamStatsArray.push("<tr><td><b>" + data[i]["Team"] + "</b></td><td>" + data[i]["GP"] + "</td><td>" + data[i]["W"] + "</td><td>" + data[i]["L"] + "</td><td>" + data[i]["T"] + "</td><td>" + data[i]["PTS"] + "</td><td>" + data[i]["GF"] + "</td><td>" + data[i]["GA"] + "</td><td>" + data[i]["+/-"] + "</td></tr>");

                }

            }

            var teamstats = teamStatsArray.join('');

            return document.getElementById('teamstats_table').innerHTML = teamstats;

        },

        //Function launched if data  loaded from JSON file contains errors

        error: function (jqXHR, textStatus, errorThrown) {

            //Outputs Error Status information in console

            console.log('ERROR', textStatus, errorThrown);



        }

    });

}



function rrteamStats() {

    $.ajax({

        type: "GET",

        // Call Json file

        url: "data/rrteamstats.json",

        //Declare Json data type

        dataType: "json",

        cache: false,

        contentType: "application/json",

        //Function launched if data is loaded successfully from JSON file specified above

        success: function (data) {



            for (i = 0; i < data.length; i++) {

                if (i == 0) {

                    rrteamStatsArray.push("<tr><th><b>" + data[i]["Team"] + "</b></th><th>" + data[i]["GP"] + "</th><th>" + data[i]["W"] + "</th><th>" + data[i]["L"] + "</th><th>" + data[i]["T"] + "</th><th>" + data[i]["PTS"] + "</th><th>" + data[i]["GF"] + "</th><th>" + data[i]["GA"] + "</th><th>" + data[i]["+/-"] + "</th></tr>");

                } else {

                    rrteamStatsArray.push("<tr><td><b>" + data[i]["Team"] + "</b></td><td>" + data[i]["GP"] + "</td><td>" + data[i]["W"] + "</td><td>" + data[i]["L"] + "</td><td>" + data[i]["T"] + "</td><td>" + data[i]["PTS"] + "</td><td>" + data[i]["GF"] + "</td><td>" + data[i]["GA"] + "</td><td>" + data[i]["+/-"] + "</td></tr>");

                }

            }

            var rrteamstats = rrteamStatsArray.join('');

            return document.getElementById('rrteamstats_table').innerHTML = rrteamstats;

        },

        //Function launched if data  loaded from JSON file contains errors

        error: function (jqXHR, textStatus, errorThrown) {

            //Outputs Error Status information in console

            console.log('ERROR', textStatus, errorThrown);



        }

    });

}