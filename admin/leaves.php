<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0) {   
    header('location:index.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin | Total Leave </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <meta name="description" content="Responsive Admin Dashboard Template" />
    <meta name="keywords" content="admin,dashboard" />
    <meta name="author" content="Steelcoders" />
    
    <!-- Internal Styles -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            margin: 20px;
            margin-left: 250px;
        }

        .header {
            background-color: #333;
            color: white;
            padding: 15px 20px;
            font-size: 24px;
            text-align: center;
        }

        .search-container {
            margin: 20px 0;
            text-align: right;
        }

        .search-bar {
            padding: 8px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 250px;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background-color: #f1f1f1;
        }

        .table td a {
            color: #007bff;
            text-decoration: none;
        }

        .table td a:hover {
            text-decoration: underline;
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

        .errorWrap, .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }

        .succWrap {
            border-left: 4px solid #5cb85c;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php include('includes/header.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <div class="header">
            Leave History
        </div>

        <div class="search-container">
            <input type="text" id="search-bar" class="search-bar" placeholder="Search by Employee Name or Leave Type..." onkeyup="searchTable()">
        </div>

        <div class="card">
            <div class="card-title">
                Leave History
            </div>
            <?php if($msg){ ?>
                <div class="succWrap"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?> </div>
            <?php } ?>
            <table id="leave-table" class="table">
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
                    $sql = "SELECT tblleaves.id as lid,tblemployees.FirstName,tblemployees.LastName,tblemployees.EmpId,tblemployees.id,tblleaves.LeaveType,tblleaves.PostingDate,tblleaves.Status 
                            FROM tblleaves 
                            JOIN tblemployees ON tblleaves.empid=tblemployees.id 
                            ORDER BY lid DESC";
                    $query = $dbh -> prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    $cnt = 1;
                    if($query->rowCount() > 0) {
                        foreach($results as $result) {         
                    ?>
                    <tr>
                        <td><b><?php echo htmlentities($cnt);?></b></td>
                        <td><a href="editemployee.php?empid=<?php echo htmlentities($result->id);?>" target="_blank">
                            <?php echo htmlentities($result->FirstName." ".$result->LastName);?> (<?php echo htmlentities($result->EmpId);?>)
                        </a></td>
                        <td><?php echo htmlentities($result->LeaveType);?></td>
                        <td><?php echo htmlentities($result->PostingDate);?></td>
                        <td>
                            <?php 
                            $status = $result->Status;
                            if($status == 1) {
                                echo "<span class='status-approved'>Approved</span>";
                            } elseif($status == 2) {
                                echo "<span class='status-not-approved'>Not Approved</span>";
                            } else {
                                echo "<span class='status-pending'>Waiting for approval</span>";
                            }
                            ?>
                        </td>
                        <td><a href="leave-details.php?leaveid=<?php echo htmlentities($result->lid);?>" class="waves-effect waves-light btn blue m-b-xs">View Details</a></td>
                    </tr>
                    <?php 
                        $cnt++;
                        }
                    } 
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Internal Scripts -->
    <script>
        // Search functionality for table
        function searchTable() {
            let input = document.getElementById('search-bar');
            let filter = input.value.toLowerCase();
            let table = document.getElementById('leave-table');
            let rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                let row = rows[i];
                let columns = row.getElementsByTagName('td');
                let found = false;

                for (let j = 0; j < columns.length - 1; j++) { // exclude the last "Action" column
                    if (columns[j]) {
                        let textValue = columns[j].textContent || columns[j].innerText;
                        if (textValue.toLowerCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                }

                if (found) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
        }
    </script>
</body>
</html>
<?php } ?>
