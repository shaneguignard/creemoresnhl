<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<?php include('head.php'); ?>
<body>
   <?php 
    include_once('header.php');
    ?>
    <noscript>
        For full functionality of this site it is necessary to enable JavaScript.
        Here are the <a href="https://www.enable-javascript.com/" style='text-decoration: underline;'>
            instructions how to enable JavaScript in your web browser</a>.
    </noscript>
    <div id="root">
        <!-- LANDING VIEW -->
        <?php 
        
        include('./view/highlights.php'); 
        include('sponsors.php');
        
        ?>
    </div>
</body>
<!--<script src="functions.js"></script>-->
<!--    <script>season();</script>-->
</html>
