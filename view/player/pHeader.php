<img id='playerImage' src='./images/newlogo.png'>
<h1>
    <?php
        include('current-mysql.php');
        echo '#'.getNumber($conn, $player).' ';
        echo $player;
    ?>

</h1>
<h3>Joined:
    <?php echo joined($conn, $player); ?>
</h3>

<table id='pHeader' cellspacing='0'>
    <tr>
        <th>Season</th>
        <th>Team</th>
        <th>Points</th>
    </tr>
    <?php echo career($conn, $player); ?>
</table>
<hr>