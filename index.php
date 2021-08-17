<?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        include 'dbconfig.php';
        $query = "CREATE TABLE IF NOT EXISTS `USERS` (
            ID int(11) AUTO_INCREMENT,
            EMAIL varchar(255) NOT NULL,
            PASSWORD varchar(255) NOT NULL,
            PRIMARY KEY  (ID)
            )";
        
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $query = "select * from USERS where EMAIL='{$email}' AND PASSWORD='{$password}'";
        $result = $conn->query($query);

        if( mysqli_num_rows($result) > 0)
        {
            $row=mysqli_fetch_array($result) or die(mysql_error());
            $_SESSION['id'] = $row['ID'];
            $_SESSION['email'] = $row['EMAIL'];

            $sql = "UPDATE `users` SET `ONLINE_OFFLINE`=1 WHERE `EMAIL`='{$email}'";
            $conn->query($sql);
            header('Location: logins.php');
        }
        else
        {
            echo "<script>alert('Please check your Email and Password')</script>";
        }
    
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">

        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-6 mt-5 shadow p-3 bg-body rounded">

                <h1>New Live Chat Rooms</h1>

                <form method="post">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="register.php">Register</a>
                </form>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</body>

</html>