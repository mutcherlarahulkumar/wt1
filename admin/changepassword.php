<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{
// Code for change password 
if(isset($_POST['change']))
    {
$password=md5($_POST['password']);
$newpassword=md5($_POST['newpassword']);
$username=$_SESSION['alogin'];
    $sql ="SELECT Password FROM admin WHERE UserName=:username and Password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':username', $username, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
$con="update admin set Password=:newpassword where UserName=:username";
$chngpwd1 = $dbh->prepare($con);
$chngpwd1-> bindParam(':username', $username, PDO::PARAM_STR);
$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
$chngpwd1->execute();
$msg="Your Password succesfully changed";
}
else {
$error="Your current password is wrong";    
}
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        
        <!-- Title -->
        <title>Admin | Change Password</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta charset="UTF-8">
        <meta name="description" content="Responsive Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Steelcoders" />
        
        <style>
            /* Inline styles */
            body {
                font-family: Arial, sans-serif;
                background-color: #f7f7f7;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                filter: brightness(1.1);
            }

            .page-title {
                font-size: 24px;
                color: #333;
                font-weight: bold;
                margin-bottom: 20px;
            }

            .card {
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                padding: 20px;
                width: 100%;
                max-width: 600px;
                margin: auto;
                filter: contrast(1.05);
            }

            .card-content {
                padding: 0;
            }

            .input-field input {
                border: 1px solid #ddd;
                border-radius: 4px;
                padding: 12px;
                width: 100%;
                margin-bottom: 20px;
                transition: border-color 0.3s ease;
            }

            .input-field input:focus {
                border-color: #3f51b5;
                outline: none;
            }

            .waves-effect {
                background-color: #3f51b5;
                color: white;
                padding: 10px 20px;
                border-radius: 4px;
                text-align: center;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .waves-effect:hover {
                background-color: #303f9f;
            }

            .errorWrap, .succWrap {
                background-color: #f8d7da;
                color: #721c24;
                padding: 10px;
                border-radius: 4px;
                margin-bottom: 20px;
                font-weight: bold;
            }

            .succWrap {
                background-color: #d4edda;
                color: #155724;
            }
        </style>
    </head>
    <body>
        <?php include('includes/header.php');?>
        <?php include('includes/sidebar.php');?>

        <main class="mn-inner">
            <div class="row">
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
                                            <button type="submit" name="change" class="waves-effect waves-light btn" onclick="return valid();">Change</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <script>
            // Inline JavaScript
            document.querySelector('.waves-effect').addEventListener('click', function() {
                alert('Password Changed!');
            });
        </script>
    </body>
</html>

<?php } ?>
