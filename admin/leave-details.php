<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0) {   
    header('location:index.php');
} else {
    // code for update the read notification status
    $isread=1;
    $did=intval($_GET['leaveid']);  
    date_default_timezone_set('Asia/Kolkata');
    $admremarkdate=date('Y-m-d G:i:s ', strtotime("now"));
    $sql="update tblleaves set IsRead=:isread where id=:did";
    $query = $dbh->prepare($sql);
    $query->bindParam(':isread',$isread,PDO::PARAM_STR);
    $query->bindParam(':did',$did,PDO::PARAM_STR);
    $query->execute();

    // code for action taken on leave
    if(isset($_POST['update'])) { 
        $did=intval($_GET['leaveid']);
        $description=$_POST['description'];
        $status=$_POST['status'];   
        date_default_timezone_set('Asia/Kolkata');
        $admremarkdate=date('Y-m-d G:i:s ', strtotime("now"));
        $sql="update tblleaves set AdminRemark=:description,Status=:status,AdminRemarkDate=:admremarkdate where id=:did";
        $query = $dbh->prepare($sql);
        $query->bindParam(':description',$description,PDO::PARAM_STR);
        $query->bindParam(':status',$status,PDO::PARAM_STR);
        $query->bindParam(':admremarkdate',$admremarkdate,PDO::PARAM_STR);
        $query->bindParam(':did',$did,PDO::PARAM_STR);
        $query->execute();
        $msg="Leave updated Successfully";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin | Leave Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <meta name="description" content="Responsive Admin Dashboard Template" />
    <meta name="keywords" content="admin,dashboard" />
    <meta name="author" content="Steelcoders" />
    
    <!-- Internal CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            
        }
        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
            margin-left: 250px;
        }
        .page-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .success, .error {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .success {
            background-color: #dff0d8;
            color: #3c763d;
        }
        .error {
            background-color: #f2dede;
            color: #a94442;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .filter-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .filter-container input, .filter-container select {
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .filter-container select {
            width: 150px;
        }
        .modal-content textarea {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .modal-footer {
            text-align: right;
        }
        .modal{
            margin-left: 250px;
        }
    </style>
</head>
<body>
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>
    
    <main class="mn-inner">
        <div class="row">
            <div class="col s12">
                <div class="page-title">Leave Details</div>
            </div>
            
            <div class="col s12 m12 l12">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Leave Details</span>
                        <?php if($msg) { ?><div class="success"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?> </div><?php } ?>
                        
                        <!-- Filters and Search -->
                        <div class="filter-container">
                            <input type="text" id="search" placeholder="Search by employee name..." onkeyup="filterTable()">
                            <select id="statusFilter" onchange="filterTable()">
                                <option value="">All Statuses</option>
                                <option value="1">Approved</option>
                                <option value="2">Not Approved</option>
                                <option value="0">Waiting for Approval</option>
                            </select>
                        </div>

                        <table id="leaveTable" class="responsive-table">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Emp ID</th>
                                    <th>Leave Type</th>
                                    <th>Leave Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $lid=intval($_GET['leaveid']);
                                $sql = "SELECT tblleaves.id as lid, tblemployees.FirstName, tblemployees.LastName, tblemployees.EmpId, tblemployees.id, tblemployees.Gender, tblemployees.Phonenumber, tblemployees.EmailId, tblleaves.LeaveType, tblleaves.ToDate, tblleaves.FromDate, tblleaves.Description, tblleaves.PostingDate, tblleaves.Status, tblleaves.AdminRemark, tblleaves.AdminRemarkDate from tblleaves join tblemployees on tblleaves.empid=tblemployees.id where tblleaves.id=:lid";
                                $query = $dbh -> prepare($sql);
                                $query->bindParam(':lid', $lid, PDO::PARAM_STR);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                
                                if($query->rowCount() > 0) {
                                    foreach($results as $result) { 
                                        $statusText = "";
                                        if($result->Status == 1) { $statusText = "<span style='color: green;'>Approved</span>"; }
                                        elseif($result->Status == 2) { $statusText = "<span style='color: red;'>Not Approved</span>"; }
                                        else { $statusText = "<span style='color: blue;'>Waiting for Approval</span>"; }
                                        ?>
                                        <tr>
                                            <td><?php echo htmlentities($result->FirstName . " " . $result->LastName); ?></td>
                                            <td><?php echo htmlentities($result->EmpId); ?></td>
                                            <td><?php echo htmlentities($result->LeaveType); ?></td>
                                            <td>From <?php echo htmlentities($result->FromDate); ?> to <?php echo htmlentities($result->ToDate); ?></td>
                                            <td><?php echo $statusText; ?></td>
                                            <td>
                                                <?php if($result->Status == 0) { ?>
                                                    <a class="modal-trigger waves-effect waves-light btn" href="#modal1">Take Action</a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal for action -->
    <div id="modal1" class="modal">
        <div class="modal-content">
            <h4>Leave Action</h4>
            <form method="post">
                <select name="status" required>
                    <option value="">Choose your option</option>
                    <option value="1">Approved</option>
                    <option value="2">Not Approved</option>
                </select>
                <textarea name="description" placeholder="Admin Remark" required></textarea>
        </div>
        <div class="modal-footer">
            <input type="submit" name="update" value="Submit" class="waves-effect waves-light btn blue m-b-xs">
        </div>
        </form>
    </div>

    <!-- Internal JS for search and filter -->
    <script>
        function filterTable() {
            const search = document.getElementById('search').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;
            const rows = document.querySelectorAll('#leaveTable tbody tr');

            rows.forEach(row => {
                const name = row.cells[0].textContent.toLowerCase();
                const status = row.cells[4].textContent.trim().toLowerCase();
                
                const isNameMatch = name.includes(search);
                const isStatusMatch = status.includes(statusFilter.toLowerCase());

                if (isNameMatch && (statusFilter === "" || isStatusMatch)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
<?php } ?>
