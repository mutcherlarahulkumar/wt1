<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['emplogin'])==0)
{   
    header('location:index.php');
}
else{
    // Code for change password 
    if(isset($_POST['change']))
    {
        $password = md5($_POST['password']);
        $newpassword = md5($_POST['newpassword']);
        $username = $_SESSION['emplogin'];
        $sql = "SELECT Password FROM tblemployees WHERE EmailId=:username and Password=:password";
        $query = $dbh->prepare($sql);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        if($query->rowCount() > 0)
        {
            $con = "update tblemployees set Password=:newpassword where EmailId=:username";
            $chngpwd1 = $dbh->prepare($con);
            $chngpwd1->bindParam(':username', $username, PDO::PARAM_STR);
            $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
            $chngpwd1->execute();
            $msg = "Your Password succesfully changed";
        }
        else {
            $error = "Your current password is wrong";    
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Employee | Change Password</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="description" content="Responsive Admin Dashboard Template" />
    <meta name="keywords" content="admin,dashboard" />
    <meta name="author" content="Steelcoders" />
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .errorWrap, .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }
        .errorWrap {
            border-left-color: #dd3d36;
        }
        .succWrap {
            border-left-color: #5cb85c;
        }
        .page-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }
        .card {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card-content {
            padding: 20px;
        }
        .input-field {
            margin-bottom: 20px;
        }
        .input-field input {
            padding: 10px;
            border: 1px solid #ccc;
            width: 100%;
            border-radius: 4px;
            font-size: 16px;
        }
        .input-field label {
            font-size: 14px;
            color: #555;
        }
        button {
            background-color: #2196f3;
            padding: 10px 20px;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
        }
        button:hover {
            background-color: #0b7dda;
        }
        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #333;
            color: white;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px;
            font-size: 16px;
            margin-bottom: 10px;
        }
        .sidebar a:hover {
            background-color: #575757;
        }
        .main-content {
            margin-left: 200px;
            padding: 20px;
        }
        .container {
                margin-top: 20px;
                padding: 20px;
                background: white;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                max-width: 900px;
        }
    </style>
</head>
<body>
    <?php include('includes/header.php'); ?>
    
    <div>
    <?php include('includes/sidebar.php'); ?>
    </div>

    <div class="main-content">
        <div class="container">
            <div class="col s12">
                <div class="page-title">Change Password</div>
            </div>
            <div class="col s12 m12 l6">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <form class="col s12" name="chngpwd" method="post">
                                <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
                                else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="password" type="password" class="validate" autocomplete="off" name="password" required>
                                        <label for="password">Current Password</label>
                                    </div>

                                    <div class="input-field col s12">
                                        <input id="password" type="password" name="newpassword" class="validate" autocomplete="off" required>
                                        <label for="password">New Password</label>
                                    </div>

                                    <div class="input-field col s12">
                                        <input id="password" type="password" name="confirmpassword" class="validate" autocomplete="off" required>
                                        <label for="password">Confirm Password</label>
                                    </div>

                                    <div class="input-field col s12">
                                        <button type="submit" name="change">Change</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php } ?>
