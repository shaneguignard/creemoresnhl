<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <?php
    include('head.php');  
    include('api.php');
    ?>

</head>

<body>
    
    <?php 
    include('header.php');     
    // Get player name from anchor
    $player = $_GET['name'];
    echo '<div id="root">';
    // Include Player Head information (name, number, Picture, year joined, Years played with wich teams, and the points gained made with that team)
    include('./view/player/pHeader.php'); 
    
    // Include current seasons stats (game-date, opponent, goals, assists, points, etc...)
    include('./view/player/pCurrent.php');
    
    // Include players historry (Season, total goals, total assists, total points, etc...)
    include('./view/player/pHistory.php');
    
    // Include all awards received by the player and the year they were received
    include('./view/player/pAwards.php'); 
    
    // Include trending insights for future applications
    
    include('./view/footer.php');
    echo "</div>"
    ?>
</body>
</html>