<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?php 
    include('current-mysql.php');
    include('head.php'); 
    $season = $_GET['season'];
?>
</head>
<body>
<?php 

include('header.php');
include('menu.php');
?>
<div id ='root'>
<?php     
include('./view/highlights.php');

echo "<h1>Season Summary</h1>";
include('./view/stats/gamesOverview.php');
include('./view/stats/seasonStats.php');
include('./view/stats/playerStats.php');
include('./view/footer.php');
echo "Records for ".($season-1)." - ". $season ." Season.";

?>
</div>
</body>
</html>