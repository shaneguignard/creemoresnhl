 <div id="header">
        <table width="100%">
            <tr>
                <td rowspan='3'>
                    <img id='logo' src="images/logo.png" />
                </td>
                <td rowspan="2">
                    <h1 id='headerName'>Creemore Sunday Night Hockey League</h1>
                </td>
            </tr>
        </table>

        <div id="menuButton" class="mobile" onclick="displayMenu(false);">Menu</div>
        <nav id='desknav' class="desktop">
            <div class="links"><a href='index.php'>HOME</a></div>
            <div class="links"><a href='schedule.php'>SCHEDULE</a></div>
            <div class="links"><a href='stats.php'>STATISTICS</a></div>
            <div class="links"><a href='stats.php#historyMain'>HISTORY</a></div>
            <div class="links"><a href='about.php'>ABOUT</a></div>
            <div class="links"><a href='about.php#contacts'>CONTACTS</a></div>
            <div class="links"><a id='registration' href='2012-2013 Regristration.pdf' target='_page'>REGISTRATION</a></div>
        </nav>
        <nav id='nav' class="mobile">
            <ul>
                <a href='index.php'>
                    <li>Home</li>
                </a>
                <a href='schedule.php' onclick="displayMenu(true);">
                    <li>Schedule</li>
                </a>
                <a href='stats.php'>
                    <li>Statistics</li>
                </a>
                <ul>
                    <a href='stats.php#historyMain' onclick="displayMenu(true)">
                        <li>History</li>
                    </a>
                </ul>
                <!--
                <a href='league.php'>
                    <li>League</li>
                </a>
                <ul>
                    <a href='teams.php'>
                        <li>Teams</li>
                    </a>
                    <a href='players.php'>
                        <li>Players</li>
                    </a>
                </ul>
-->
                <a href='about.php'>
                    <li>About</li>
                </a>
                <ul>
                    <a href='about.php#contacts' onclick="displayMenu(true)">
                        <li>Contacts</li>
                    </a>
                </ul>
            </ul>

        </nav>
    </div>
<hr>