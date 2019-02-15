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


try {
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
    var previousYearWinners = "Stayner";
    document.getElementById("seasonWinners").innerHTML = previousYearWinners;

    //Supporting Picture

    var champsPicture = "images/2018_winners.jpeg";
    document.getElementById("featureImg").src = champsPicture;
} catch (err) {
    console.log("No class for current season year found: ", err);
}


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

// collapsing nav header
var MB = document.getElementById('menuButton');
var logo = document.getElementById('logo');
var csnhl = document.getElementById('headerName');
var h = document.getElementById('header');
window.onscroll = function () {
    if (window.pageYOffset > 100 && window.innerWidth < 450 ) {
        MB.style = 'width: 50px; position:fixed; top:0px; right: 5px;font-size: 10pt;';
        logo.style = 'height: 50px;';
        csnhl.style = 'font-size: 12pt; width:210px;';
        h.style = 'border-bottom: 1px solid black;';
    } else if(window.innerWidth < 450) {
        MB.style = 'width: 100%;';
        csnhl.style = 'font-size: 18pt;';
        logo.style = 'height: 75px;';
        h.style = 'border: none;'
    }
}
