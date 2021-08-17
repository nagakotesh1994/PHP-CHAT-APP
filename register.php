<?php
    
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        include 'dbconfig.php';
        $query = "CREATE TABLE IF NOT EXISTS `USERS` (
            ID int(11) AUTO_INCREMENT,
            NAME varchar(255) NOT NULL,
            EMAIL varchar(255) NOT NULL,
            PASSWORD varchar(255) NOT NULL,
            ONLINE_OFFLINE varchar(5) DEFAULT '0',
            LAST_LOGIN TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY  (ID)
            )";
            
        mysqli_query($conn, $query) or die('Query Error:'.$conn -> error);
        
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $query = "INSERT INTO USERS (NAME, EMAIL, PASSWORD) VALUES ('{$name}', '{$email}', '{$password}')";
        if( $conn->query($query) === TRUE)
        {
            echo "<script>alert('You account has been successfully created.');</script>";
        }
        else
        {
            echo "Error: " . $query . "<br>" . $conn->error;
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
            <div class="col-md-4"></div>
            <div class="col-md-4 mt-5 shadow p-3 bg-body rounded">
                <h1>Register</h1>

                <form method="post">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name">

                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Re-Password</label>
                        <input type="password" class="form-control" id="repassword" name="repassword">
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="/chatroom-v2">Login</a>
                </form>

            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</body>

</html>