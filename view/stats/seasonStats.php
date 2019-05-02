<table id='regularSeason' class='standings' cellspacing='0'>
    <tr>
        <th colspan="10">
            <h2>Regular Season Standings</h2>
        </th>
    </tr>
    <tr>
        <th>Pos.</th>
        <th>Team</th>
        <th>GP</th>
        <th>W</th>
        <th>L</th>
        <th>T</th>
        <th>Pts</th>
        <th>GF</th>
        <th>GA</th>
        <th>+/-</th>
    </tr>
    <?php getRegSeason($conn, $season); ?>
</table>
<table id='regularSeason' class='standings' cellspacing='0'>
    <tr>
        <th colspan="10">
            <h2>Round Robin Standings</h2>
        </th>
    </tr>
    <tr>
        <th>Pos.</th>
        <th>Team</th>
        <th>GP</th>
        <th>W</th>
        <th>L</th>
        <th>T</th>
        <th>Pts</th>
        <th>GF</th>
        <th>GA</th>
        <th>+/-</th>
    </tr>
    <?php getRRSeason($conn, $season); ?>
</table>
