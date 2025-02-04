<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin'])==0) {   
    header('location:index.php');
} else {
    if(isset($_POST['add'])) {
        $deptname = $_POST['departmentname'];
        $deptshortname = $_POST['departmentshortname'];
        $deptcode = $_POST['deptcode'];   

        $sql = "INSERT INTO tbldepartments(DepartmentName, DepartmentCode, DepartmentShortName) 
                VALUES(:deptname, :deptcode, :deptshortname)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':deptname', $deptname, PDO::PARAM_STR);
        $query->bindParam(':deptcode', $deptcode, PDO::PARAM_STR);
        $query->bindParam(':deptshortname', $deptshortname, PDO::PARAM_STR);
        $query->execute();

        $lastInsertId = $dbh->lastInsertId();
        if($lastInsertId) {
            $msg = "Department Created Successfully";
        } else {
            $error = "Something went wrong. Please try again";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Add Department</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 2% auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .input-field {
            margin-bottom: 15px;
        }
        .input-field label {
            font-weight: bold;
        }
        .input-field input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 5px;
        }
        .submit-btn {
            width: 100%;
            padding: 12px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #45a049;
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>
    <div>
        <?php include("./includes/header.php") ?>
        <?php include("./includes/sidebar.php")  ?>
    </div>
    <div class="container">
        <div class="form-header">
            <h2>Add Department</h2>
        </div>

        <?php if($error) { ?>
            <div class="message error">
                <strong>Error:</strong> <?php echo htmlentities($error); ?>
            </div>
        <?php } else if($msg) { ?>
            <div class="message success">
                <strong>Success:</strong> <?php echo htmlentities($msg); ?>
            </div>
        <?php } ?>

        <form method="post">
            <div class="input-field">
                <label for="departmentname">Department Name</label>
                <input type="text" id="departmentname" name="departmentname" required autocomplete="off">
            </div>

            <div class="input-field">
                <label for="departmentshortname">Department Short Name</label>
                <input type="text" id="departmentshortname" name="departmentshortname" required autocomplete="off">
            </div>

            <div class="input-field">
                <label for="deptcode">Department Code</label>
                <input type="text" id="deptcode" name="deptcode" required autocomplete="off">
            </div>

            <button type="submit" name="add" class="submit-btn">Add Department</button>
        </form>
    </div>
</body>
</html>
<?php } ?>
