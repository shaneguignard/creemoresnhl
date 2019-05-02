<?php 
include('current-mysql.php');
include('api.php');
 if ($season){
        $season = $_GET['season'];
    }
    else {
        $season ='2019';
    }

$pyear = $season-1;
?>

<div id="home" class="section">
    <h2>SNHL CHAMPIONS</h2>
    <h5>
        <?php echo $pyear." / ".$season; ?>
    </h5>
    <h2 id="seasonWinners">
        <?php echo getChamps($conn, $season); ?>
    </h2>
    <img id="featureImg" <?php echo 'src="' .featureImg($season).'"'; ?>/>

    <div id='awards'>
        <table class='awards'>
            <tr>
                <th id="vezinaAward" width='250'>Vezina Award</th>
            </tr>
            <?php getVezina($conn, $season); ?>
        </table>
        <table class='awards'>
            <tr>
                <th width='250'>Players Choice Award</th>
            </tr>
            <?php getPCA($conn, $season); ?>
        </table>

        <table class='awards'>
            <tr>
                <th width='250'>Points Leader</th>
            </tr>
            <?php getPLA($conn, $season); ?>
        </table>
    </div>
</div>
