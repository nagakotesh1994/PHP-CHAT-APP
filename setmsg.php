<?php
  session_start();
  include 'dbconfig.php';
  
  $id = $_SESSION['id'];
  $email = $_SESSION['email'];
  
  $frdid = $_GET['frdid'];
  $message = $_GET['message'];
  
    if(empty($frdid))
        exit("<script>alert('Please select any Friend to chat')</script>");
    
    $table_name1 = $id.$_GET['frdid'];
    $query = "CREATE TABLE IF NOT EXISTS ".$table_name1."T (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        sender_msg VARCHAR(30) NOT NULL,
        reciver_msg VARCHAR(30) NOT NULL,
        typeing VARCHAR(10) NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
    mysqli_query($conn, $query) or die('Query Error:'.mysqli_error($conn));
    
    $table_name2 = strrev($table_name1);
    $query = "CREATE TABLE IF NOT EXISTS ".$table_name2."T (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            sender_msg VARCHAR(30) NOT NULL,
            reciver_msg VARCHAR(30) NOT NULL,
            typeing VARCHAR(10) NOT NULL,
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
    mysqli_query($conn, $query) or die('Query Error:'.mysqli_error($conn));
    
    
    $query = "INSERT INTO {$table_name1}T (sender_msg, reciver_msg) VALUES ('{$message}','')";
    mysqli_query($conn, $query) or die('Query Error:'.mysqli_error($conn));

    $query = "INSERT INTO {$table_name2}T (sender_msg, reciver_msg) VALUES ('','{$message}')";
    mysqli_query($conn, $query) or die('Query Error:'.mysqli_error($conn));
  ?>