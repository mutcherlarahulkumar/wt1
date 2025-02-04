<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(isset($_POST['signin']))
{
    $uname=$_POST['username'];
    $password=md5($_POST['password']);
    $sql ="SELECT EmailId,Password,Status,id FROM tblemployees WHERE EmailId=:uname and Password=:password";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':uname', $uname, PDO::PARAM_STR);
    $query-> bindParam(':password', $password, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    if($query->rowCount() > 0)
    {
        foreach ($results as $result) {
            $status=$result->Status;
            $_SESSION['eid']=$result->id;
        }
        if($status==0)
        {
            $msg="Your account is Inactive. Please contact admin";
        } else {
            $_SESSION['emplogin']=$_POST['username'];
            echo "<script type='text/javascript'> document.location = 'emp-changepassword.php'; </script>";
        }
    } else {
        echo "<script>alert('Invalid Details');</script>";
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <title>ELMS | Home Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f6;
        }
        header {
            background-color: #00796b;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }
        .sidebar {
            width: 250px;
            background-color: #004d40;
            height: 100vh;
            color: white;
            position: fixed;
            padding-top: 20px;
        }
        .sidebar a {
            text-decoration: none;
            color: white;
            display: block;
            padding: 10px 20px;
            margin: 5px 0;
            border-radius: 4px;
        }
        .sidebar a:hover {
            background-color: #00695c;
        }
        .content {
            margin-left: 270px;
            padding: 20px;
        }
        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            padding: 20px;
            max-width: 400px;
            margin: auto;
        }
        .card h4 {
            margin-bottom: 20px;
            color: #00796b;
        }
        .input-field {
            margin-bottom: 20px;
        }
        .input-field label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        .input-field input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn {
            background-color: #00796b;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #004d40;
        }
        .errorWrap {
            background: #ffdddd;
            padding: 10px;
            border-left: 4px solid #f44336;
            margin-bottom: 15px;
            color: #d32f2f;
        }
    </style>
</head>
<body>
    <header>
        <h1>ELMS | Employee Leave Management System</h1>
    </header>
    <div class="sidebar">
        <a href="index.php">Employee Login</a>
        <a href="forgot-password.php">Emp Password Recovery</a>
        <a href="admin/">Admin Login</a>
    </div>
    <div class="content">
        <div class="card">
            <h4>Employee Login</h4>
            <?php if($msg){?><div class="errorWrap"><strong>Error:</strong> <?php echo htmlentities($msg); ?> </div><?php }?>
            <form name="signin" method="post">
                <div class="input-field">
                    <label for="username">Email Id</label>
                    <input id="username" type="text" name="username" required>
                </div>
                <div class="input-field">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>
                </div>
                <button type="submit" name="signin" class="btn">Sign in</button>
            </form>
        </div>
    </div>
</body>
</html>
