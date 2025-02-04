<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{   
    header('location:index.php');
}
else{
    if(isset($_POST['add']))
    {
        $empid=$_POST['empcode'];
        $fname=$_POST['firstName'];
        $lname=$_POST['lastName'];   
        $email=$_POST['email']; 
        $password=md5($_POST['password']); 
        $gender=$_POST['gender']; 
        $dob=$_POST['dob']; 
        $department=$_POST['department']; 
        $address=$_POST['address']; 
        $city=$_POST['city']; 
        $country=$_POST['country']; 
        $mobileno=$_POST['mobileno']; 
        $status=1;

        $sql="INSERT INTO tblemployees(EmpId,FirstName,LastName,EmailId,Password,Gender,Dob,Department,Address,City,Country,Phonenumber,Status) VALUES(:empid,:fname,:lname,:email,:password,:gender,:dob,:department,:address,:city,:country,:mobileno,:status)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':empid',$empid,PDO::PARAM_STR);
        $query->bindParam(':fname',$fname,PDO::PARAM_STR);
        $query->bindParam(':lname',$lname,PDO::PARAM_STR);
        $query->bindParam(':email',$email,PDO::PARAM_STR);
        $query->bindParam(':password',$password,PDO::PARAM_STR);
        $query->bindParam(':gender',$gender,PDO::PARAM_STR);
        $query->bindParam(':dob',$dob,PDO::PARAM_STR);
        $query->bindParam(':department',$department,PDO::PARAM_STR);
        $query->bindParam(':address',$address,PDO::PARAM_STR);
        $query->bindParam(':city',$city,PDO::PARAM_STR);
        $query->bindParam(':country',$country,PDO::PARAM_STR);
        $query->bindParam(':mobileno',$mobileno,PDO::PARAM_STR);
        $query->bindParam(':status',$status,PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if($lastInsertId)
        {
            $msg="Employee record added Successfully";
        }
        else 
        {
            $error="Something went wrong. Please try again";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <meta name="description" content="Responsive Admin Dashboard Template" />
    <meta name="keywords" content="admin,dashboard" />
    <meta name="author" content="Steelcoders" />

    <title>Admin | Add Employee</title>

    <!-- Internal Styles -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }
        .card {
            margin-left: 250px;
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .page-title {
            font-size: 24px;
            color: #333;
            margin-bottom: 15px;
        }
        .input-field label {
            color: #555;
        }
        .input-field input[type="text"], .input-field input[type="email"], .input-field input[type="password"], .input-field input[type="date"], .input-field input[type="tel"], .input-field select {
            border-radius: 4px;
            border: 1px solid #ccc;
            padding: 10px;
            width: 100%;
        }
        .waves-effect {
            background-color: #3f51b5;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
        .succWrap {
            padding: 10px;
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }
        .errorWrap {
            padding: 10px;
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
    </style>

    <!-- Internal Scripts -->
    <script type="text/javascript">
        function valid() {
            if(document.addemp.password.value != document.addemp.confirmpassword.value) {
                alert("New Password and Confirm Password Field do not match!");
                document.addemp.confirmpassword.focus();
                return false;
            }
            return true;
        }
        function checkAvailabilityEmpid() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "check_availability.php",
                data: 'empcode=' + $("#empcode").val(),
                type: "POST",
                success: function(data) {
                    $("#empid-availability").html(data);
                    $("#loaderIcon").hide();
                },
                error: function() {}
            });
        }
        function checkAvailabilityEmailid() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "check_availability.php",
                data: 'emailid=' + $("#email").val(),
                type: "POST",
                success: function(data) {
                    $("#emailid-availability").html(data);
                    $("#loaderIcon").hide();
                },
                error: function() {}
            });
        }
    </script>
</head>

<body>
    <?php include('includes/header.php');?>
    <?php include('includes/sidebar.php');?>

    <main class="mn-inner">
        <div class="row">
            <div class="col s12">
                <div class="page-title">Add Employee</div>
            </div>
            <div class="col s12 m12 l12">
                <div class="card">
                    <div class="card-content">
                        <form id="example-form" method="post" name="addemp" onsubmit="return valid();">
                            <div>
                                <h3>Employee Info</h3>
                                <section>
                                    <div class="wizard-content">
                                        <div class="row">
                                            <div class="col m6">
                                                <div class="row">
                                                    <?php if($error){?>
                                                        <div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div>
                                                    <?php } else if($msg){?>
                                                        <div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div>
                                                    <?php }?>

                                                    <div class="input-field col s12">
                                                        <label for="empcode">Employee Code(Must be unique)</label>
                                                        <input name="empcode" id="empcode" onBlur="checkAvailabilityEmpid()" type="text" autocomplete="off" required>
                                                        <span id="empid-availability" style="font-size:12px;"></span>
                                                    </div>

                                                    <div class="input-field col m6 s12">
                                                        <label for="firstName">First name</label>
                                                        <input id="firstName" name="firstName" type="text" required>
                                                    </div>

                                                    <div class="input-field col m6 s12">
                                                        <label for="lastName">Last name</label>
                                                        <input id="lastName" name="lastName" type="text" autocomplete="off" required>
                                                    </div>

                                                    <div class="input-field col s12">
                                                        <label for="email">Email</label>
                                                        <input name="email" type="email" id="email" onBlur="checkAvailabilityEmailid()" autocomplete="off" required>
                                                        <span id="emailid-availability" style="font-size:12px;"></span>
                                                    </div>

                                                    <div class="input-field col s12">
                                                        <label for="password">Password</label>
                                                        <input id="password" name="password" type="password" autocomplete="off" required>
                                                    </div>

                                                    <div class="input-field col s12">
                                                        <label for="confirm">Confirm password</label>
                                                        <input id="confirm" name="confirmpassword" type="password" autocomplete="off" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col m6">
                                                <div class="row">
                                                    <div class="input-field col m6 s12">
                                                        <select name="gender" autocomplete="off">
                                                            <option value="">Gender...</option>                                          
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                            <option value="Other">Other</option>
                                                        </select>
                                                    </div>

                                                    <div class="input-field col m6 s12">
                                                        <label for="birthdate">Birthdate</label>
                                                        <input id="birthdate" name="dob" type="date" class="datepicker" autocomplete="off">
                                                    </div>

                                                    <div class="input-field col m6 s12">
                                                        <select name="department" autocomplete="off">
                                                            <option value="">Department...</option>
                                                            <?php 
                                                            $sql = "SELECT DepartmentName from tbldepartments";
                                                            $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                            if($query->rowCount() > 0)
                                                            {
                                                                foreach($results as $result)
                                                                {   
                                                                    ?>                                            
                                                                    <option value="<?php echo htmlentities($result->DepartmentName);?>"><?php echo htmlentities($result->DepartmentName);?></option>
                                                                    <?php 
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div class="input-field col m6 s12">
                                                        <label for="address">Address</label>
                                                        <input id="address" name="address" type="text" autocomplete="off" required>
                                                    </div>

                                                    <div class="input-field col m6 s12">
                                                        <label for="city">City/Town</label>
                                                        <input id="city" name="city" type="text" autocomplete="off" required>
                                                    </div>

                                                    <div class="input-field col m6 s12">
                                                        <label for="country">Country</label>
                                                        <input id="country" name="country" type="text" autocomplete="off" required>
                                                    </div>

                                                    <div class="input-field col s12">
                                                        <label for="phone">Mobile number</label>
                                                        <input id="phone" name="mobileno" type="tel" maxlength="10" autocomplete="off" required>
                                                    </div>

                                                    <div class="input-field col s12">
                                                        <button type="submit" name="add" id="add" class="waves-effect waves-light btn indigo m-b-xs">ADD</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
<?php } ?>
