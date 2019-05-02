<table id="playerStats" class='standings offset' cellspacing='0'>
    <tr>
        <th colspan='7'>
            <h2>PLAYERS STATISTICS</h2>
        </th>
    </tr>
    <tr>
        <th>Pos.</th>
        <th>Player</th>
        <th>Team</th>
        <th>G</th>
        <th>A</th>
        <th>Pts</th>
        <th>PIM</th>
    </tr>
    <?php getPlayerStats($conn, $season); ?>
</table>