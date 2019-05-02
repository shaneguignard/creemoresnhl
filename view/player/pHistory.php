<h2>History</h2>
        <table id='pHistory' cellspacing='0'>
            <tr>
                <th>Season</th>
                <th>Goals</th>
                <th>Assists</th>
                <th>Points</th>
                <th>Penatly Minutes</th>
<!--                <th>Avg pts/game</th>-->
            </tr>
            <?php echo getHistory($conn, $player); ?>
        </table>
<hr>