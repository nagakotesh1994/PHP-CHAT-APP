<?php
    session_start();
    include 'dbconfig.php';
    $sql = "UPDATE `users` SET `ONLINE_OFFLINE`=0 WHERE `ID`='{$_SESSION['id']}'";
    $conn->query($sql);
    session_destroy();
    header('Location: index.php');
?>