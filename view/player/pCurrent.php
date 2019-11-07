<?php include('./current-mysql.php'); ?>
<h2>Current Season</h2>
<table id='pCurrent' cellspacing='0'>
    <tr>
        <th>Game (Time)</th>
        <th>Period</th>
        <th>Goals</th>
        <th>Assists</th>
        <th>Points</th>
        <th>Penatly Minutes</th>
        <th>Against</th>
    </tr>
    <?php echo getCurrent($conn, $player, $season); ?>
</table>
<hr>
