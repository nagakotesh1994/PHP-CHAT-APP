<?php
      session_start();
      include 'dbconfig.php';
      $query = "CREATE TABLE IF NOT EXISTS `REQUESTS` (
        ID int(11) AUTO_INCREMENT,
        R_SENDER varchar(10) NOT NULL,
        R_RECIVER varchar(10) NOT NULL,
        ACCEPT_REJECT_PENDING varchar(10) DEFAULT '#',
        REQUEST_TIMESTAMP TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY  (ID)
        )";
    mysqli_query($conn, $query) or die('Query Error:'.$conn -> error);
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
    function send_request(myid, frdid) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("show_friends").innerHTML = this.responseText;
                alert('Request is sent.');
            }
        };
        xhttp.open("GET", "set_friend_request.php?myid=" + myid + "&frdid=" + frdid, true);
        xhttp.send();
    }
    </script>
</head>

<body>
    <?php include 'logins_menu.php'; ?>
    <br><br>
    <div class="container">
        <div class="row" id="show_friends">

            <?php
                //FRIDEND REQ
                //$query = "select t1.ID,t1.NAME from users t1 inner join requests t2 on (t2.R_SENDER={$_SESSION['id']} AND t1.ID=t2.R_RECIVER AND t2.ACCEPT_REJECT_PENDING='#');";

                //$query = "SELECT * FROM `USERS` WHERE ID!=".$_SESSION['id'];
                //$query = "select * from users where id in( select id from requests where R_SENDER!={$_SESSION['id']} and ACCEPT_REJECT_PENDING!='#')";


                //$query = "select * from users where id not in( select id from requests where R_SENDER!={$_SESSION['id']} and ACCEPT_REJECT_PENDING!='#') and id!={$_SESSION['id']}";
                //$query="select * from users where id not in( select R_RECIVER from requests where ACCEPT_REJECT_PENDING='#') and id!={$_SESSION['id']}";
                $query = "SELECT * FROM users WHERE ID NOT IN (select R_RECIVER from requests where R_SENDER='{$_SESSION['id']}' AND  ACCEPT_REJECT_PENDING='#' OR ACCEPT_REJECT_PENDING='1' OR ACCEPT_REJECT_PENDING='@') AND ID!={$_SESSION['id']}";
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
                                    <a href='#' onclick='send_request({$_SESSION['id']},{$row['ID']})' class='btn btn-primary'>Send Request</a>
                                    <!--<a href='#' onclick='send_request({$_SESSION['id']},{$row['ID']})' class='btn btn-secondary'>Reject</a> -->
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