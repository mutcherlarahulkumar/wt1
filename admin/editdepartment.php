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
$did=intval($_GET['deptid']);    
$deptname=$_POST['departmentname'];
$deptshortname=$_POST['departmentshortname'];
$deptcode=$_POST['deptcode'];   
$sql="update tbldepartments set DepartmentName=:deptname,DepartmentCode=:deptcode,DepartmentShortName=:deptshortname where id=:did";
$query = $dbh->prepare($sql);
$query->bindParam(':deptname',$deptname,PDO::PARAM_STR);
$query->bindParam(':deptcode',$deptcode,PDO::PARAM_STR);
$query->bindParam(':deptshortname',$deptshortname,PDO::PARAM_STR);
$query->bindParam(':did',$did,PDO::PARAM_STR);
$query->execute();
$msg="Department updated Successfully";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin | Update Department</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <meta name="description" content="Responsive Admin Dashboard Template" />
    <meta name="keywords" content="admin,dashboard" />
    <meta name="author" content="Steelcoders" />
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }
        .card {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            margin-left: 250px;
        }
        .page-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            text-align: center;
            margin: 20px 0;
        }
        .errorWrap {
            padding: 10px;
            background: #f8d7da;
            border-left: 4px solid #dd3d36;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .succWrap {
            padding: 10px;
            background: #d4edda;
            border-left: 4px solid #28a745;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .input-field input {
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 10px;
            width: 100%;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .input-field input:focus {
            border-color: #3f51b5;
        }
        label {
            font-size: 14px;
            color: #333;
        }
        button {
            background-color: #3f51b5;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #283593;
        }
        .row {
            margin-bottom: 0;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
    </style>
</head>
<body>
    <?php include("./includes/sidebar.php") ?>
    <div class="container">
        <div class="page-title">Update Department</div>
        <div class="card">
            <form method="post">
                <?php if($error){?>
                    <div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div>
                <?php } else if($msg){?>
                    <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?> </div>
                <?php }?>
                
                <?php 
                $did=intval($_GET['deptid']);
                $sql = "SELECT * from tbldepartments WHERE id=:did";
                $query = $dbh -> prepare($sql);
                $query->bindParam(':did',$did,PDO::PARAM_STR);
                $query->execute();
                $results=$query->fetchAll(PDO::FETCH_OBJ);
                if($query->rowCount() > 0)
                {
                    foreach($results as $result)
                    {               
                ?>  

                <div class="row">
                    <div class="input-field col s12">
                        <input id="departmentname" type="text" name="departmentname" value="<?php echo htmlentities($result->DepartmentName);?>" required>
                        <label for="deptname">Department Name</label>
                    </div>

                    <div class="input-field col s12">
                        <input id="departmentshortname" type="text" name="departmentshortname" value="<?php echo htmlentities($result->DepartmentShortName);?>" required>
                        <label for="deptshortname">Department Short Name</label>
                    </div>

                    <div class="input-field col s12">
                        <input id="deptcode" type="text" name="deptcode" value="<?php echo htmlentities($result->DepartmentCode);?>" required>
                        <label for="deptcode">Department Code</label>
                    </div>
                </div>

                <?php }} ?>

                <div class="input-field col s12">
                    <button type="submit" name="update">UPDATE</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // JS functionalities (if needed)
    </script>
</body>
</html>
<?php } ?>
