<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Code for change password 
if(isset($_POST['change'])) {
    $newpassword = md5($_POST['newpassword']);
    $empid = $_SESSION['empid'];

    $con = "UPDATE tblemployees SET Password=:newpassword WHERE id=:empid";
    $chngpwd1 = $dbh->prepare($con);
    $chngpwd1->bindParam(':empid', $empid, PDO::PARAM_STR);
    $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
    $chngpwd1->execute();
    $msg = "Your Password has been successfully changed.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>ELMS | Password Recovery</title>

    <style>
        /* Reset some basic styles */
        body, h1, h2, h3, h4, h5, h6, p {
            margin: 0;
            padding: 0;
        }

        /* Body Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        .mn-content {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        #slide-out {
            width: 250px;
            background-color: #333;
            color: white;
            padding: 20px;
        }

        .sidebar-menu a {
            color: white;
            display: block;
            padding: 10px;
            text-decoration: none;
        }

        .sidebar-menu a:hover {
            background-color: #575757;
        }

        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 10px;
            background-color: #333;
            text-align: center;
            color: white;
        }

        /* Content Styles */
        .mn-inner {
            flex-grow: 1;
            padding: 20px;
        }

        .page-title {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
        }

        .card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .input-field {
            margin-bottom: 20px;
        }

        .input-field input,
        .input-field label {
            width: 100%;
        }

        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        /* Success/Error Message */
        .errorWrap, .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid;
            box-shadow: 0 1px 1px rgba(0,0,0,.1);
        }

        .errorWrap {
            border-color: #dd3d36;
        }

        .succWrap {
            border-color: #5cb85c;
        }

        .errorWrap strong, .succWrap strong {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="mn-content">
        <aside id="slide-out" class="side-nav">
            <div class="side-nav-wrapper">
                <ul class="sidebar-menu">
                    <li><a href="index.php">Employee Login</a></li>
                    <li><a href="forgot-password.php">Emp Password Recovery</a></li>
                    <li><a href="admin/">Admin Login</a></li>
                </ul>
                <div class="footer">
                    <p>PHPGURUKUL &copy;</p>
                </div>
            </div>
        </aside>

        <main class="mn-inner">
            <div class="page-title">Employee Password Recovery</div>

            <div class="card">
                <div class="card-content">
                    <span class="card-title">Employee details</span>

                    <?php if($msg) { ?>
                        <div class="succWrap"><strong>Success</strong>: <?php echo htmlentities($msg); ?></div>
                    <?php } ?>

                    <form name="signin" method="post">
                        <div class="input-field">
                            <input id="empid" type="text" name="empid" autocomplete="off" required>
                            <label for="empid">Employee Id</label>
                        </div>
                        <div class="input-field">
                            <input id="password" type="text" name="emailid" autocomplete="off" required>
                            <label for="password">Email id</label>
                        </div>
                        <div class="right-align">
                            <input type="submit" name="submit" value="Sign in" class="btn">
                        </div>
                    </form>

                    <?php 
                    if (isset($_POST['submit'])) {
                        $empid = $_POST['empid'];
                        $email = $_POST['emailid'];
                        $sql = "SELECT id FROM tblemployees WHERE EmailId=:email and EmpId=:empid";
                        $query = $dbh->prepare($sql);
                        $query->bindParam(':email', $email, PDO::PARAM_STR);
                        $query->bindParam(':empid', $empid, PDO::PARAM_STR);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);

                        if ($query->rowCount() > 0) {
                            foreach ($results as $result) {
                                $_SESSION['empid'] = $result->id;
                            }
                    ?>

                    <form name="udatepwd" method="post">
                        <div class="input-field">
                            <input id="newpassword" type="password" name="newpassword" required>
                            <label for="newpassword">New Password</label>
                        </div>

                        <div class="input-field">
                            <input id="confirmpassword" type="password" name="confirmpassword" required>
                            <label for="confirmpassword">Confirm Password</label>
                        </div>

                        <div class="input-field">
                            <button type="submit" name="change" class="btn">Change</button>
                        </div>
                    </form>

                    <?php
                        } else {
                    ?>
                    <div class="errorWrap"><strong>ERROR</strong>: Invalid details</div>
                    <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
