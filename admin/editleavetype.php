<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{   
    header('location:index.php');
}
else{
    if(isset($_POST['update']))
    {
        $lid=intval($_GET['lid']);
        $leavetype=$_POST['leavetype'];
        $description=$_POST['description'];
        $sql="update tblleavetype set LeaveType=:leavetype,Description=:description where id=:lid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':leavetype',$leavetype,PDO::PARAM_STR);
        $query->bindParam(':description',$description,PDO::PARAM_STR);
        $query->bindParam(':lid',$lid,PDO::PARAM_STR);
        $query->execute();
        $msg="Leave type updated Successfully";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin | Edit Leave Type</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <meta name="description" content="Admin Panel"/>
    <meta name="keywords" content="admin, dashboard"/>
    <meta name="author" content="Steelcoders"/>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin-left: 250px;
            overflow: hidden;
        }
        .header {
            text-align: center;
            padding: 30px;
            background: #2c3e50;
            color: white;
        }
        .header h1 {
            margin: 0;
            font-size: 2em;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .form-container h3 {
            margin-top: 0;
            color: #333;
        }
        .input-field {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .input-field:focus {
            border-color: #3498db;
        }
        .btn-submit {
            background-color: #3498db;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-submit:hover {
            background-color: #2980b9;
        }
        .message {
            padding: 15px;
            margin: 10px 0;
            border-radius: 4px;
            text-align: center;
        }
        .errorWrap {
            background-color: #f8d7da;
            border-left: 5px solid #dd3d36;
            color: #721c24;
        }
        .succWrap {
            background-color: #d4edda;
            border-left: 5px solid #28a745;
            color: #155724;
        }
        textarea {
            width: 100%;
            height: 150px;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            resize: vertical;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Admin | Edit Leave Type</h1>
    </div>
    <?php include("./includes/sidebar.php") ?>
    <div class="container">
        <?php include('includes/header.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <div class="form-container">
            <form method="post">
                <h3>Edit Leave Type</h3>
                <?php if($error){?>
                    <div class="message errorWrap"><strong>ERROR</strong> : <?php echo htmlentities($error); ?> </div>
                <?php } else if($msg){?>
                    <div class="message succWrap"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?> </div>
                <?php }?>

                <?php
                $lid=intval($_GET['lid']);
                $sql = "SELECT * from tblleavetype where id=:lid";
                $query = $dbh -> prepare($sql);
                $query->bindParam(':lid',$lid,PDO::PARAM_STR);
                $query->execute();
                $results=$query->fetchAll(PDO::FETCH_OBJ);
                if($query->rowCount() > 0) {
                    foreach($results as $result) {
                ?>  
                    <div class="input-field">
                        <label for="leavetype">Leave Type</label>
                        <input type="text" id="leavetype" name="leavetype" value="<?php echo htmlentities($result->LeaveType); ?>" required>
                    </div>
                    <div class="input-field">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" required><?php echo htmlentities($result->Description); ?></textarea>
                    </div>
                <?php }} ?>

                <button type="submit" name="update" class="btn-submit">Update</button>
            </form>
        </div>
    </div>

    <script>
        // Custom JS code for input validation and other dynamic features (if needed)
    </script>
</body>
</html>
<?php } ?>
