<?php
      session_start();
      error_reporting(0);
      include 'dbconfig.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="vendor/components/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="vendor/components/font-awesome/css/all.css">
    <script>
    function accept_reject(senderid, requestid, reqestcode) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("show_frd_req").innerHTML = this.responseText;
                //alert(url);
            }
        };
        var url = "accept_reject.php?senderid=" + senderid + "&requestid=" + requestid + "&reqestcode=" + reqestcode;
        xhttp.open("GET", url, true);
        xhttp.send();
    }
    </script>
</head>

<body>
    <?php include 'logins_menu.php'; ?>
    <br><br>
    <div class="container">
        <div class="row" id='show_frd_req'>
            <?php
                //FRIDEND REQ
                //$query = "select t1.ID,t1.NAME from users t1 inner join requests t2 on (t2.R_SENDER={$_SESSION['id']} AND t1.ID=t2.R_RECIVER AND t2.ACCEPT_REJECT_PENDING='#');";

                //$query = "SELECT * FROM `USERS` WHERE ID!=".$_SESSION['id'];
                //$query = "select * from users where id in( select id from requests where R_SENDER!={$_SESSION['id']} and ACCEPT_REJECT_PENDING!='#')";


                //$query = "select * from users where id not in( select id from requests where R_SENDER!={$_SESSION['id']} and ACCEPT_REJECT_PENDING!='#') and id!={$_SESSION['id']}";
                //$query="select * from users where id in( select id from requests where R_RECIVER={$_SESSION['id']} and ACCEPT_REJECT_PENDING='#')";
                //$query = "select * from users where ID in (select R_SENDER from requests where R_RECIVER={$_SESSION['id']} and ACCEPT_REJECT_PENDING='#')";
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
        </div>
    </div>
</body>

</html>