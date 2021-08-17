<?php
   session_start();
   //error_reporting(0);
   include 'dbconfig.php';
   $id = $_SESSION['id'];
   $email = $_SESSION['email'];
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
    $(document).ready(function() {
        $(window).keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                setmsg();
                return false;
            }
        });
    });

    scrollstatus = 0;

    function getid(val, typeing = 0) {

        //document.getElementById('message').focus();
        if (typeof myVar !== 'undefined') {
            clearTimeout(myVar);
        }
        document.getElementById('frdid').value = val;
        val = document.getElementById('frdid').value;
        var myid = document.getElementById('myid').value;
        loadmsg(myid + val, typeing);

        myVar = setTimeout(function() {
            getid(val);
        }, 1000)

        // window.location.href = "#scroll";
        //window.location.replace("#scroll");

    }

    function setmsg() {
        var xhttp = new XMLHttpRequest();
        var frdid = document.getElementById('frdid').value;
        var message = document.getElementById('message').value;
        //alert(frdid + "  " + message);

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // document.getElementById("msg_show").innerHTML = this.responseText;
                //alert(this.responseText);

                // var elem = document.getElementById('msg_show');
                // elem.scrollTop = elem.scrollHeight;

            }
        };
        xhttp.open("GET", "setmsg.php?frdid=" + frdid + "&message=" + message, true);
        xhttp.send();
        document.getElementById('message').value = '';
        document.getElementById('message').focus();


    }

    function loadmsg(tablename, typeing) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var str = this.responseText;
                var array = str.split("||");
                document.getElementById("msg_show").innerHTML = array[0];
                document.getElementById('typeing').innerHTML = array[1];
                //document.getElementById("msg_show").innerHTML = this.responseText;

            }
        };
        xhttp.open("GET", "getmsg.php?tablename=" + tablename + "&typeing=" + typeing, true);
        xhttp.send();
    }

    // function typeing_data() {
    //     document.getElementById('typeing').innerHTML = 'typeing..';
    //     myVar = setTimeout(function() {
    //         document.getElementById('typeing').innerHTML = '&nbsp';
    //     }, 500)

    // }
    </script>

    <style>
    .s {
        margin-right: 20px;
        padding: 5px 15px;
        background: rgb(112, 98, 209);
        background: linear-gradient(90deg, rgba(112, 98, 209, 1) 0%, rgba(166, 0, 255, 1) 100%);
        color: white;
        border-radius: 20px 20px 0px 20px;
        box-shadow: 5px 5px 10px #888888;

    }

    .r {
        margin-left: 20px;
        padding: 5px 15px;
        background: rgb(112, 98, 209);
        background: linear-gradient(90deg, rgba(112, 98, 209, 1) 0%, rgba(166, 0, 255, 1) 100%);
        color: white;
        border-radius: 20px 20px 20px 0px;
        box-shadow: 5px 5px 10px #888888;
    }

    .date {
        text-align: center;
        background-color: #F1F1F1;
        border-radius: 5px;
        margin: 10px 40%;
        color: #CBCBCB;

    }

    .time_r {
        font-size: 10px;
        margin-right: 20px;
    }

    .time_l {
        font-size: 10px;
        margin-left: 20px;
    }
    </style>
</head>

<body>
    <?php include 'logins_menu.php' ?>

    <div class="container">
        <div class="row mt-5 shadow p-3 bg-body rounded">

            <div class="col-md-1">
                <img src="images/profile.jpg" alt="..." class="img-thumbnail rounded-circle" width="100">
            </div>
            <div class="col-md-11">
                <?php
                    $query = "select * from USERS where ID='{$_SESSION['id']}'";
                    $result = $conn->query($query);
                    $i=1;
                    while($row = mysqli_fetch_array($result))
                    {
                        
                        echo "<H4>".$row['EMAIL']."<br><button type='button' class='btn btn-success btn-sm'>Active: </button></H4>";
                        echo "<span id='typeing'>&nbsp;</span>";
                        
                    }
                ?>

                <p align="right">
                    <a href="logout.php" class="btn btn-outline-success ">
                        Logout
                    </a>
                </p>
            </div>

        </div>

        <div class="row mt-1 shadow p-3 bg-body rounded">
            <div class="col-md-12 ">
                <div class="row">
                    <div class="col-4" style="border-right:1px solid #D3DCE3">
                        <div class="list-group">

                            <?php
                                //$query = "select * from USERS where ID!='{$_SESSION['id']}'";
                                $query = "SELECT * FROM users WHERE ID IN (select R_RECIVER from requests where R_SENDER='{$_SESSION['id']}' AND ACCEPT_REJECT_PENDING='#' OR ACCEPT_REJECT_PENDING='1' OR ACCEPT_REJECT_PENDING='@') AND ID!={$_SESSION['id']}";
                                $result = $conn->query($query);
                                $i=1;
                                while($row = mysqli_fetch_array($result))
                                {
                                    if($row['ONLINE_OFFLINE']==1)    
                                        echo "<a onclick='getid({$row['ID']});two()' class='list-group-item list-group-item-action'>
                                        <img src='images/profile.jpg' alt='...' class='img-thumbnail rounded-circle' width='50'>&nbsp;&nbsp;{$row['EMAIL']}<br><span class='text-success'>Online</span></a>
                                        ";
                                    else
                                        echo "<a onclick='getid({$row['ID']});two()' class='list-group-item list-group-item-action'>
                                        <img src='images/profile.jpg' alt='...' class='img-thumbnail rounded-circle' width='50'>&nbsp;&nbsp;{$row['EMAIL']}</a>";
                                    $i++;
                                }
                            ?>
                            <script>
                            function two() {
                                document.getElementById('message').value = '';
                            }
                            </script>
                        </div>
                    </div>

                    <div class="col-8">
                        <div style="border:1px solid #DEDEDE; height:500px; overflow:auto; border-radius:5px;"
                            id="msg_show"></div>
                        <br>
                        <form method="post" class="row gx-3 gy-2 align-items-center">
                            <div class="col-sm-10">
                                <label class="visually-hidden" for="specificSizeInputName">Name</label>
                                <input type="text" class="form-control" id="message" name="message"
                                    placeholder="Message" autocomplete="off"
                                    onkeyup="getid(document.getElementById('frdid').value,1);">

                            </div>

                            <div class="col-sm-2">
                                <input type="hidden" name="frdid" id="frdid">
                                <input type="hidden" name="myid" id="myid" value="<?php echo $id; ?>">
                                <button type="button" onclick="setmsg();" class="btn btn-primary"><i
                                        class="fa fa-paper-plane" aria-hidden="true"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>