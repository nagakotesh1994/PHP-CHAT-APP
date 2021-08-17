<?php
    session_start();
    
    include 'dbconfig.php';
    //$rowid = $_GET['rowid'];

    $senderid = $_GET['senderid'];
    $requestid = $_GET['requestid'];
    $reqestcode = $_GET['reqestcode'];
    
    
    
    //echo $query;
    if($reqestcode==1)
    {
        $query="UPDATE `requests` SET `ACCEPT_REJECT_PENDING`='{$reqestcode}' WHERE `R_SENDER`='{$senderid}' AND `R_RECIVER`='{$requestid}'";
        mysqli_query($conn, $query) or die('Query Error:'.mysqli_error($conn));
        
        $query="UPDATE `requests` SET `ACCEPT_REJECT_PENDING`='@' WHERE `R_SENDER`='{$requestid}' AND `R_RECIVER`='{$senderid}'";
        mysqli_query($conn, $query) or die('Query Error:'.mysqli_error($conn));
    }
    else
    {
        $query="DELETE FROM `requests` WHERE `R_SENDER`='{$senderid}' AND `R_RECIVER`='{$requestid}'";
        mysqli_query($conn, $query) or die('Query Error:'.mysqli_error($conn));
        
        $query="DELETE FROM `requests` WHERE `R_SENDER`='{$requestid}' AND `R_RECIVER`='{$senderid}'";
        mysqli_query($conn, $query) or die('Query Error:'.mysqli_error($conn));
    } 
       

    //$query = "select * from users where id not in( select id from requests where R_SENDER!={$_SESSION['id']} and ACCEPT_REJECT_PENDING!='#') and id!={$_SESSION['id']}";
    //$query="select * from users where id in( select id from requests where R_RECIVER={$_SESSION['id']} and ACCEPT_REJECT_PENDING='#')";
    //$query = "select * from users where ID in (select R_SENDER from requests where R_RECIVER={$_SESSION['id']} and ACCEPT_REJECT_PENDING='#');";
    $query = "select t1.ID,t1.NAME,t1.EMAIL,t2.R_SENDER,t2.R_RECIVER from users t1 INNER JOIN requests t2 on( t2.R_RECIVER={$_SESSION['id']} AND t2.ACCEPT_REJECT_PENDING='#' ) where t1.ID=t2 .R_sender";
    //echo $query;
    $result = $conn->query($query);
    while($row = mysqli_fetch_array($result))
    {
        echo "<div class='col-6'>
        <div class='card mb-3' style='max-width: 540px;'>
            <div class='row g-0'>
                <div class='col-md-4'>
                    <img src='images/profile.jpg' class='img-fluid rounded-start' alt='...'>
                </div>
                <div class='col-md-8'>
                    <div class='card-body'>
                        <h5 class='card-title'>{$row['ID']}.{$row['NAME']}</h5>
                        <p class='card-text'>This is a wider card with supporting text below as a natural</p>
                        <a  onclick='accept_reject({$row['R_SENDER']},{$row['R_RECIVER']},1)' class='btn btn-primary'>Accept</a>
                        <a  onclick='accept_reject({$row['R_SENDER']},{$row['R_RECIVER']},0)' class='btn btn-secondary'>Reject</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
        ";
    } 
?>