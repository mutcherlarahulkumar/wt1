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
    <title>Admin | Approved Leave</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <meta name="description" content="Responsive Admin Dashboard Template" />
    <meta name="keywords" content="admin,dashboard" />
    <meta name="author" content="Steelcoders" />
    
    <style>
        /* Basic Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f6;
        }
        .container {
            padding: 20px;
            margin-left: 250px;
        }

        .page-title {
            font-size: 24px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #3f51b5;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn {
            background-color: #007BFF;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .filter-container {
            margin: 20px 0;
        }

        .filter-input {
            padding: 8px;
            margin-right: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
        }

        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
        }
    </style>

    <script>
        function searchLeaves() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchBar");
            filter = input.value.toUpperCase();
            table = document.getElementById("leaveTable");
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td");
                if (td) {
                    txtValue = td[1].textContent || td[1].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</head>

<body>
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>
    
    <main class="container">
        <div class="page-title">Pending Leave History</div>
        
        <!-- Success/Error Message -->
        <?php if($msg) { ?>
            <div class="succWrap"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?> </div>
        <?php } ?>
        
        <!-- Search and Filter Section -->
        <div class="filter-container">
            <input type="text" id="searchBar" class="filter-input" onkeyup="searchLeaves()" placeholder="Search for Employee Name..." />
        </div>
        
        <!-- Leave Table -->
        <table id="leaveTable">
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
                $status = 0; // Pending status
                $sql = "SELECT tblleaves.id as lid, tblemployees.FirstName, tblemployees.LastName, tblemployees.EmpId, tblemployees.id, tblleaves.LeaveType, tblleaves.PostingDate, tblleaves.Status 
                        FROM tblleaves 
                        JOIN tblemployees ON tblleaves.empid = tblemployees.id 
                        WHERE tblleaves.Status = :status 
                        ORDER BY lid DESC";
                $query = $dbh->prepare($sql);
                $query->bindParam(':status', $status, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $cnt = 1;
                if($query->rowCount() > 0) {
                    foreach($results as $result) {
                ?>  
                    <tr>
                        <td><?php echo htmlentities($cnt);?></td>
                        <td><a href="editemployee.php?empid=<?php echo htmlentities($result->id);?>" target="_blank">
                            <?php echo htmlentities($result->FirstName." ".$result->LastName);?> (<?php echo htmlentities($result->EmpId);?>)
                        </a></td>
                        <td><?php echo htmlentities($result->LeaveType);?></td>
                        <td><?php echo htmlentities($result->PostingDate);?></td>
                        <td>
                            <?php 
                            $stats = $result->Status;
                            if($stats == 1) { ?>
                                <span style="color: green">Approved</span>
                            <?php } elseif($stats == 2) { ?>
                                <span style="color: red">Not Approved</span>
                            <?php } elseif($stats == 0) { ?>
                                <span style="color: blue">Waiting for approval</span>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="leave-details.php?leaveid=<?php echo htmlentities($result->lid);?>" class="btn">View Details</a>
                        </td>
                    </tr>
                <?php 
                    $cnt++;
                    }
                }
                ?>
            </tbody>
        </table>
    </main>


</body>
</html>
<?php } ?>
