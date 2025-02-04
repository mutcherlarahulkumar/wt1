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
        $leavetype = $_POST['leavetype'];
        $description = $_POST['description'];
        $sql = "INSERT INTO tblleavetype(LeaveType, Description) VALUES(:leavetype, :description)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':leavetype', $leavetype, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if($lastInsertId)
        {
            $msg = "Leave type added Successfully";
        }
        else 
        {
            $error = "Something went wrong. Please try again";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Title -->
    <title>Admin | Add Leave Type</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <meta name="description" content="Responsive Admin Dashboard Template" />
    <meta name="keywords" content="admin, dashboard" />
    <meta name="author" content="Steelcoders" />

    <!-- Internal Styles -->
    <style>
        /* Overall Body */
        body {
            font-family: 'Roboto', sans-serif;
            background: #f4f6f9;
            color: #333;
            margin: 0;
        }
        
        /* Page container */
        .main-container {
            margin-top: 50px;
        }

        /* Header and Sidebar */
        .page-title {
            font-size: 28px;
            font-weight: 600;
            color: #3f51b5;
        }
        
        .card {
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin: 0 auto;
            max-width: 600px;
        }

        /* Form Styling */
        .input-field {
            margin-bottom: 20px;
        }

        input[type="text"], textarea {
            border-radius: 4px;
            padding: 10px;
            border: 1px solid #ddd;
            width: 100%;
            margin-bottom: 20px;
            font-size: 16px;
        }

        input[type="text"]:focus, textarea:focus {
            border-color: #3f51b5;
            outline: none;
        }

        /* Submit Button */
        .btn {
            background-color: #3f51b5;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            transition: background-color 0.3s ease;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #303f9f;
        }

        /* Alerts */
        .errorWrap, .succWrap {
            padding: 15px;
            margin: 20px 0;
            background-color: #f9f9f9;
            border-left: 5px solid;
            font-size: 16px;
        }

        .errorWrap {
            border-color: #f44336;
        }

        .succWrap {
            border-color: #4caf50;
        }

        .label {
            font-weight: 500;
            color: #333;
        }
    </style>

    <!-- Materialize CSS and JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Materialize components
            var elems = document.querySelectorAll('.sidenav');
            var instances = M.Sidenav.init(elems);
        });
    </script>
</head>
<body>

    <?php include('includes/header.php');?>
    <?php include('includes/sidebar.php');?>

    <main class="main-container">
        <div class="row">
            <div class="col s12">
                <div class="page-title">Add Leave Type</div>
            </div>
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <form method="post">
                            <?php if($error) { ?>
                                <div class="errorWrap"><strong>ERROR</strong> : <?php echo htmlentities($error); ?> </div>
                            <?php } else if($msg) { ?>
                                <div class="succWrap"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?> </div>
                            <?php } ?>

                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="leavetype" type="text" name="leavetype" required>
                                    <label for="leavetype">Leave Type</label>
                                </div>

                                <div class="input-field col s12">
                                    <textarea id="textarea1" name="description" class="materialize-textarea" length="500"></textarea>
                                    <label for="description">Description</label>
                                </div>

                                <div class="input-field col s12">
                                    <button type="submit" name="add" class="btn waves-effect waves-light">ADD</button>
                                </div>
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
