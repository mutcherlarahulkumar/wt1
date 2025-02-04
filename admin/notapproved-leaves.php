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
    <title>Admin | Not Approved Leaves</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <meta name="description" content="Responsive Admin Dashboard Template" />
    <meta name="keywords" content="admin,dashboard" />
    <meta name="author" content="Steelcoders" />
    
    <!-- Internal CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            margin-left: 250px;
        }
        .page-title {
            text-align: center;
            font-size: 30px;
            margin-top: 30px;
            font-weight: bold;
        }
        .search-bar {
            margin: 20px 0;
            display: flex;
            justify-content: flex-end;
        }
        .search-bar input {
            padding: 10px;
            font-size: 16px;
            width: 300px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .action-btn {
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }
        .action-btn:hover {
            background-color: #0056b3;
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
    </style>

    <!-- Internal JavaScript -->
    <script>
        function filterLeaves() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const rows = document.querySelectorAll('table tbody tr');
            rows.forEach(row => {
                const cells = row.getElementsByTagName('td');
                const employeeName = cells[1].textContent.toLowerCase();
                if (employeeName.indexOf(filter) > -1) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }
    </script>
</head>
<body>
    <?php include('includes/header.php');?>
    <?php include('includes/sidebar.php');?>

    <div class="container">
        <div class="page-title">Not Approved Leave History</div>

        <div class="search-bar">
            <input type="text" id="searchInput" onkeyup="filterLeaves()" placeholder="Search for employee..." />
        </div>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th width="200">Employee Name</th>
                    <th width="120">Leave Type</th>
                    <th width="180">Posting Date</th>                 
                    <th>Status</th>
                    <th align="center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $status = 2;
                $sql = "SELECT tblleaves.id as lid, tblemployees.FirstName, tblemployees.LastName, tblemployees.EmpId, tblemployees.id, tblleaves.LeaveType, tblleaves.PostingDate, tblleaves.Status 
                        FROM tblleaves 
                        JOIN tblemployees ON tblleaves.empid = tblemployees.id 
                        WHERE tblleaves.Status = :status 
                        ORDER BY lid DESC";
                $query = $dbh -> prepare($sql);
                $query->bindParam(':status', $status, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $cnt = 1;
                if($query->rowCount() > 0) {
                    foreach($results as $result) { 
                ?>
                    <tr>
                        <td><b><?php echo htmlentities($cnt);?></b></td>
                        <td><a href="editemployee.php?empid=<?php echo htmlentities($result->id);?>" target="_blank">
                            <?php echo htmlentities($result->FirstName . " " . $result->LastName); ?> (<?php echo htmlentities($result->EmpId);?>)
                        </a></td>
                        <td><?php echo htmlentities($result->LeaveType);?></td>
                        <td><?php echo htmlentities($result->PostingDate);?></td>
                        <td>
                            <?php 
                                $status = $result->Status;
                                if($status == 1) {
                                    echo '<span class="status-approved">Approved</span>';
                                } elseif($status == 2) {
                                    echo '<span class="status-not-approved">Not Approved</span>';
                                } elseif($status == 0) {
                                    echo '<span class="status-pending">Waiting for approval</span>';
                                }
                            ?>
                        </td>
                        <td>
                            <a href="leave-details.php?leaveid=<?php echo htmlentities($result->lid);?>" class="action-btn">View Details</a>
                        </td>
                    </tr>
                <?php 
                        $cnt++;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php } ?>
