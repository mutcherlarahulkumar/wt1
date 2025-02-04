<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['emplogin'])==0)
{   
    header('location:index.php');
}
else {
    $eid = $_SESSION['emplogin'];
    if(isset($_POST['update'])) {
        $fname = $_POST['firstName'];
        $lname = $_POST['lastName'];   
        $gender = $_POST['gender']; 
        $dob = $_POST['dob']; 
        $department = $_POST['department']; 
        $address = $_POST['address']; 
        $city = $_POST['city']; 
        $country = $_POST['country']; 
        $mobileno = $_POST['mobileno']; 

        $sql = "update tblemployees set FirstName=:fname, LastName=:lname, Gender=:gender, Dob=:dob, Department=:department, Address=:address, City=:city, Country=:country, Phonenumber=:mobileno where EmailId=:eid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':lname', $lname, PDO::PARAM_STR);
        $query->bindParam(':gender', $gender, PDO::PARAM_STR);
        $query->bindParam(':dob', $dob, PDO::PARAM_STR);
        $query->bindParam(':department', $department, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':city', $city, PDO::PARAM_STR);
        $query->bindParam(':country', $country, PDO::PARAM_STR);
        $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
        $query->bindParam(':eid', $eid, PDO::PARAM_STR);
        $query->execute();
        $msg = "Employee record updated Successfully";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Details</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
        }
        /* Sidebar styles */
        /* .sidebar {
            height: 100%;
            width: 200px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #0078d4;
            color: white;
            padding-top: 20px;
            padding-left: 20px;
            display: flex;
            flex-direction: column;
        } */
        .sidebar {
            width: 200px; /* Sidebar width */
            background-color: white;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
            z-index: 999; /* Ensures sidebar is above other content */
            padding-top: 20px; /* Space from top */
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: block;
            font-size: 16px;
            margin-bottom: 15px;
        }
        .sidebar a:hover {
            background-color: #005fa3;
            border-radius: 4px;
        }
        /* Main content */
        .main-content {
            margin-left: 270px;
            width: calc(100% - 270px);
            padding: 20px;
        }
        .header {
            background-color: #0078d4;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }
        .form-section {
            margin-bottom: 20px;
        }
        .form-section label {
            font-size: 14px;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }
        .form-section input, .form-section select {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-section button {
            background-color: #0078d4;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-section button:hover {
            background-color: #005fa3;
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 14px;
        }
        .errorWrap {
            background-color: #ffe6e6;
            border-left: 4px solid #f44336;
        }
        .succWrap {
            background-color: #e6ffe6;
            border-left: 4px solid #4caf50;
        }
        




        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            border-bottom: 1px solid #f0f0f0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            color: #333;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .sidebar-menu a:hover {
            background-color: #f5f5f5;
        }

        .sidebar-menu i {
            margin-right: 15px;
            font-size: 20px;
            color: #666;
        }

        .collapsible-body {
            display: none;
            background-color: #f9f9f9;
            padding-left: 20px;
        }
        .sidebar-profile {
            text-align: center;
            padding-bottom: 20px;
        }

        .sidebar-profile-image img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        .sidebar-profile-info p {
            margin: 10px 0 5px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .sidebar-profile-info span {
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
    <div class="sidebar-profile">
        <div class="sidebar-profile-image">
            <img src="assets/images/profile-image.png" alt="Profile Image">
        </div>
        <div class="sidebar-profile-info">
            <?php
            // $eid = $_SESSION['eid'];
            $sql = "SELECT FirstName, LastName, EmpId FROM tblemployees WHERE id = :eid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':eid', $eid, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            if ($query->rowCount() > 0) {
                foreach ($results as $result) { ?>
                    <p><?php echo htmlentities($result->FirstName . " " . $result->LastName); ?></p>
                    <span><?php echo htmlentities($result->EmpId); ?></span>
            <?php }
            } ?>
        </div>
    </div>
    <ul class="sidebar-menu">
        <li><a href="myprofile.php"></i>My Profile</a></li>
        <li><a href="emp-changepassword.php"></i>Change Password</a></li>
        <li>
            <a class="collapsible-header" onclick="toggleCollapsible(this)"></i>Leaves
                <i class="material-icons nav-drop-icon">></i>
            </a>
            <div class="collapsible-body">
                <ul>
                    <li><a href="apply-leave.php">Apply Leave</a></li>
                    <li><a href="leavehistory.php">Leave History</a></li>
                </ul>
            </div>
        </li>
        <li><a href="logout.php"></i>Sign Out</a></li>
    </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">Update Employee Info</div>
        <div class="container">
            <?php if($error) { ?>
                <div class="message errorWrap">
                    <strong>ERROR</strong>: <?php echo htmlentities($error); ?>
                </div>
            <?php } else if($msg) { ?>
                <div class="message succWrap">
                    <strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?>
                </div>
            <?php } ?>

            <form method="post" name="updatemp">
                <?php 
                $sql = "SELECT * FROM tblemployees WHERE EmailId=:eid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                if ($query->rowCount() > 0) {
                    foreach ($results as $result) {
                ?>
                    <div class="form-section">
                        <label for="empcode">Employee Code</label>
                        <input name="empcode" id="empcode" value="<?php echo htmlentities($result->EmpId); ?>" type="text" readonly>
                    </div>
                    <div class="form-section">
                        <label for="firstName">First Name</label>
                        <input id="firstName" name="firstName" value="<?php echo htmlentities($result->FirstName); ?>" type="text" required>
                    </div>
                    <div class="form-section">
                        <label for="lastName">Last Name</label>
                        <input id="lastName" name="lastName" value="<?php echo htmlentities($result->LastName); ?>" type="text" required>
                    </div>
                    <div class="form-section">
                        <label for="email">Email</label>
                        <input name="email" id="email" value="<?php echo htmlentities($result->EmailId); ?>" type="email" readonly>
                    </div>
                    <div class="form-section">
                        <label for="phone">Mobile Number</label>
                        <input id="phone" name="mobileno" value="<?php echo htmlentities($result->Phonenumber); ?>" type="tel" maxlength="10" required>
                    </div>
                    <div class="form-section">
                        <label for="gender">Gender</label>
                        <select name="gender">
                            <option value="<?php echo htmlentities($result->Gender); ?>"><?php echo htmlentities($result->Gender); ?></option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-section">
                        <label for="dob">Date of Birth</label>
                        <input id="dob" name="dob" value="<?php echo htmlentities($result->Dob); ?>" type="date">
                    </div>
                    <div class="form-section">
                        <label for="department">Department</label>
                        <select name="department">
                            <option value="<?php echo htmlentities($result->Department); ?>"><?php echo htmlentities($result->Department); ?></option>
                            <?php 
                            $sql = "SELECT DepartmentName FROM tbldepartments";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            foreach ($results as $dept) {
                                echo '<option value="' . htmlentities($dept->DepartmentName) . '">' . htmlentities($dept->DepartmentName) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-section">
                        <label for="address">Address</label>
                        <input id="address" name="address" value="<?php echo htmlentities($result->Address); ?>" type="text" required>
                    </div>
                    <div class="form-section">
                        <label for="city">City</label>
                        <input id="city" name="city" value="<?php echo htmlentities($result->City); ?>" type="text" required>
                    </div>
                    <div class="form-section">
                        <label for="country">Country</label>
                        <input id="country" name="country" value="<?php echo htmlentities($result->Country); ?>" type="text" required>
                    </div>
                    <div class="form-section">
                        <button type="submit" name="update">Update</button>
                    </div>
                <?php } } ?>
            </form>
        </div>
    </div>
    <script>
        function toggleCollapsible(element) {
            const collapsibleBody = element.nextElementSibling;
            const icon = element.querySelector('.nav-drop-icon');
            if (collapsibleBody.style.display === "block") {
                collapsibleBody.style.display = "none";
                icon.textContent = ">"; // Update icon to show closed state
            } else {
                collapsibleBody.style.display = "block";
                icon.textContent = "^"; // Update icon to show open state
            }
        }
    </script>
</body>
</html>
<?php } ?>
