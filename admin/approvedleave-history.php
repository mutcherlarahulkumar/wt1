<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{   
header('location:index.php');
}
else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Title -->
    <title>Admin | Approved Leaves</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <meta name="description" content="Responsive Admin Dashboard Template" />
    <meta name="keywords" content="admin,dashboard" />
    <meta name="author" content="Steelcoders" />

    <!-- Internal Styles -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        
        .header {
            background-color: #333;
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        .sidebar {
            width: 250px;
            height: 100%;
            background-color: #333;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
            padding-left: 10px;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 10px;
            text-decoration: none;
            margin-bottom: 10px;
            border-radius: 4px;
        }

        .sidebar a:hover {
            background-color: #575757;
        }

        .main-content {
            margin-left: 260px;
            padding: 20px;
        }

        .card {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f1f1f1;
        }

        .status-approved {
            color: green;
        }

        .status-not-approved {
            color: red;
        }

        .status-pending {
            color: blue;
        }

        .btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            margin-right: 10px;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>

    <!-- Internal Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // You can add your custom JavaScript or jQuery here for functionality.
            const table = document.querySelector('table');
            if (table) {
                const rows = table.querySelectorAll('tr');
                rows.forEach(row => {
                    row.addEventListener('mouseover', function () {
                        row.style.backgroundColor = '#f1f1f1';
                    });
                    row.addEventListener('mouseout', function () {
                        row.style.backgroundColor = '';
                    });
                });
            }
        });
    </script>
</head>
<body>
    <div class="">
        <?php include("./includes/header.php") ?>
    </div>

    <div class="">
    <?php include("./includes/sidebar.php") ?>
    </div>

    <div class="main-content">
        <div class="card">
            <div class="card-title">Approved Leave History</div>
            <?php if($msg) { ?><div class="succWrap"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?> </div><?php } ?>

            <table id="example" class="responsive-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Employee Name</th>
                        <th>Leave Type</th>
                        <th>Posting Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                    $status = 1;
                    $sql = "SELECT tblleaves.id as lid, tblemployees.FirstName, tblemployees.LastName, tblemployees.EmpId, tblemployees.id, tblleaves.LeaveType, tblleaves.PostingDate, tblleaves.Status from tblleaves join tblemployees on tblleaves.empid = tblemployees.id where tblleaves.Status = :status order by lid desc";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':status', $status, PDO::PARAM_STR);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    $cnt = 1;
                    if ($query->rowCount() > 0) {
                        foreach ($results as $result) {         
                    ?>  

                    <tr>
                        <td><b><?php echo htmlentities($cnt); ?></b></td>
                        <td><a href="editemployee.php?empid=<?php echo htmlentities($result->id); ?>" target="_blank"><?php echo htmlentities($result->FirstName . " " . $result->LastName); ?> (<?php echo htmlentities($result->EmpId); ?>)</a></td>
                        <td><?php echo htmlentities($result->LeaveType); ?></td>
                        <td><?php echo htmlentities($result->PostingDate); ?></td>
                        <td>
                            <?php
                            $stats = $result->Status;
                            if ($stats == 1) { ?>
                                <span class="status-approved">Approved</span>
                            <?php } elseif ($stats == 2) { ?>
                                <span class="status-not-approved">Not Approved</span>
                            <?php } elseif ($stats == 0) { ?>
                                <span class="status-pending">Waiting for Approval</span>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="leave-details.php?leaveid=<?php echo htmlentities($result->lid); ?>" class="btn">View Details</a>
                        </td>
                    </tr>
                    <?php $cnt++; } } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<?php } ?>
