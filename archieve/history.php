<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<?php include_once('head.php') ?>

<body>
<?php include_once('header.php'); ?>
    <noscript>
        For full functionality of this site it is necessary to enable JavaScript.
        Here are the <a href="https://www.enable-javascript.com/" style='text-decoration: underline;'>
            instructions how to enable JavaScript in your web browser</a>.
    </noscript>
    <div id="root">
        
    </div>
    <div id="master" align="center">Designed for the Creemore Sunday Night Hockey League by Shane Guignard 2017.</div>
</body>
<script src="functions.js"></script>
<!--Import teamStats and Player databases-->
<script src='data/leagueSummary.js'></script>
<script src='data/teamStats.js'></script>

<script>
    nextGame();
    makeSchedule(a, i, g);
    schedule(g);
</script>

</html>
