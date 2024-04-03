<?php
    session_start();
    $_SESSION['title'] = 'Admin Page';
    include '../dashboard/header.php';
?>
<?php 
    include '../dashboard/nav.php';
?>
<?php 
    include '../dashboard/footer.php';
?>