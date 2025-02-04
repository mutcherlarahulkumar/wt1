<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{   
    header('location:index.php');
}
else{
    $eid=intval($_GET['empid']);
    if(isset($_POST['update']))
    {
        $fname=$_POST['firstName'];
        $lname=$_POST['lastName'];   
        $gender=$_POST['gender']; 
        $dob=$_POST['dob']; 
        $department=$_POST['department']; 
        $address=$_POST['address']; 
        $city=$_POST['city']; 
        $country=$_POST['country']; 
        $mobileno=$_POST['mobileno']; 
        $sql="update tblemployees set FirstName=:fname,LastName=:lname,Gender=:gender,Dob=:dob,Department=:department,Address=:address,City=:city,Country=:country,Phonenumber=:mobileno where id=:eid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fname',$fname,PDO::PARAM_STR);
        $query->bindParam(':lname',$lname,PDO::PARAM_STR);
        $query->bindParam(':gender',$gender,PDO::PARAM_STR);
        $query->bindParam(':dob',$dob,PDO::PARAM_STR);
        $query->bindParam(':department',$department,PDO::PARAM_STR);
        $query->bindParam(':address',$address,PDO::PARAM_STR);
        $query->bindParam(':city',$city,PDO::PARAM_STR);
        $query->bindParam(':country',$country,PDO::PARAM_STR);
        $query->bindParam(':mobileno',$mobileno,PDO::PARAM_STR);
        $query->bindParam(':eid',$eid,PDO::PARAM_STR);
        $query->execute();
        $msg="Employee record updated Successfully";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin | Update Employee</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    
    <style>
        /* Basic styles for page layout */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f7fc;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            margin-left: 250px;
        }
        .page-title {
            text-align: center;
            font-size: 30px;
            margin: 20px 0;
        }

        /* Card styling */
        .card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        /* Form input styling */
        .input-field {
            width: 100%;
            margin-bottom: 20px;
        }

        .input-field input, .input-field select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .input-field label {
            font-size: 16px;
            color: #333;
        }

        /* Button styling */
        .btn {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #45a049;
        }

        /* Success and Error Message Styling */
        .errorWrap, .succWrap {
            padding: 10px;
            margin-bottom: 20px;
            color: white;
            border-radius: 5px;
        }

        .errorWrap {
            background-color: #e74c3c;
        }

        .succWrap {
            background-color: #2ecc71;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .container {
                width: 95%;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="page-title">Update Employee</div>

    <?php if($error){?>
        <div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div>
    <?php } else if($msg){?>
        <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?> </div>
    <?php }?>
    <?php include("./includes/sidebar.php") ?>
    <div class="card">
        <form method="post" name="updatemp">
            <?php 
            $eid=intval($_GET['empid']);
            $sql = "SELECT * from  tblemployees where id=:eid";
            $query = $dbh -> prepare($sql);
            $query -> bindParam(':eid',$eid, PDO::PARAM_STR);
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            if($query->rowCount() > 0) {
                foreach($results as $result) { ?> 
                    <div class="input-field">
                        <label for="empcode">Employee Code (Must be unique)</label>
                        <input name="empcode" id="empcode" value="<?php echo htmlentities($result->EmpId);?>" type="text" autocomplete="off" readonly required>
                    </div>

                    <div class="input-field">
                        <label for="firstName">First Name</label>
                        <input id="firstName" name="firstName" value="<?php echo htmlentities($result->FirstName);?>" type="text" required>
                    </div>

                    <div class="input-field">
                        <label for="lastName">Last Name</label>
                        <input id="lastName" name="lastName" value="<?php echo htmlentities($result->LastName);?>" type="text" autocomplete="off" required>
                    </div>

                    <div class="input-field">
                        <label for="email">Email</label>
                        <input name="email" type="email" id="email" value="<?php echo htmlentities($result->EmailId);?>" readonly autocomplete="off" required>
                    </div>

                    <div class="input-field">
                        <label for="phone">Mobile Number</label>
                        <input id="phone" name="mobileno" type="tel" value="<?php echo htmlentities($result->Phonenumber);?>" maxlength="10" autocomplete="off" required>
                    </div>

                    <div class="input-field">
                        <select name="gender">
                            <option value="<?php echo htmlentities($result->Gender);?>"><?php echo htmlentities($result->Gender);?></option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="input-field">
                        <label for="birthdate">Date of Birth</label>
                        <input id="birthdate" name="dob" type="date" value="<?php echo htmlentities($result->Dob);?>">
                    </div>

                    <div class="input-field">
                        <select name="department">
                            <option value="<?php echo htmlentities($result->Department);?>"><?php echo htmlentities($result->Department);?></option>
                            <?php 
                            $sql = "SELECT DepartmentName from tbldepartments";
                            $query = $dbh -> prepare($sql);
                            $query->execute();
                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                            foreach($results as $resultt) { ?> 
                                <option value="<?php echo htmlentities($resultt->DepartmentName);?>"><?php echo htmlentities($resultt->DepartmentName);?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="input-field">
                        <label for="address">Address</label>
                        <input id="address" name="address" type="text" value="<?php echo htmlentities($result->Address);?>" autocomplete="off" required>
                    </div>

                    <div class="input-field">
                        <label for="city">City/Town</label>
                        <input id="city" name="city" type="text" value="<?php echo htmlentities($result->City);?>" autocomplete="off" required>
                    </div>

                    <div class="input-field">
                        <label for="country">Country</label>
                        <input id="country" name="country" type="text" value="<?php echo htmlentities($result->Country);?>" autocomplete="off" required>
                    </div>
            <?php }} ?>

            <div class="input-field">
                <button type="submit" name="update" class="btn">UPDATE</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let elems = document.querySelectorAll('select');
        M.FormSelect.init(elems);
    });
</script>

</body>
</html>
<?php } ?>
