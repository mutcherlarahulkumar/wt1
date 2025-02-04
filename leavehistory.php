<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['emplogin'])==0)
    {   
header('location:index.php');
}
else{

 ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        
        <!-- Title -->
        <title>Employee | Leave History</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta charset="UTF-8">
        <meta name="description" content="Responsive Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Steelcoders" />
        
        <!-- Internal Styles -->
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f9;
            }

            header {
                background-color: #0078d7;
                color: white;
                padding: 15px 20px;
                text-align: center;
                font-size: 20px;
            }

            

            .sidebar a {
                padding: 10px 15px;
                text-decoration: none;
                color: white;
                display: block;
            }

            .sidebar a:hover {
                background-color: #575757;
            }

            .container {
                margin-left: 270px;
                margin-top: 20px;
                padding: 20px;
                background: white;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                max-width: 900px;
            }

            .card-title {
                font-size: 24px;
                font-weight: bold;
                margin-bottom: 20px;
            }

            .table-container {
                overflow-x: auto;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
            }

            th, td {
                padding: 12px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }

            th {
                background-color: #0078d7;
                color: white;
                position: sticky;
                top: 0;
            }

            tr:hover {
                background-color: #f1f1f1;
            }

            .search-container {
                margin-bottom: 15px;
                display: flex;
                justify-content: space-between;
            }

            .search-container input, .search-container select {
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 4px;
            }

            .search-container input {
                width: 250px;
            }

            .status-approved {
                color: green;
                font-weight: bold;
            }

            .status-not-approved {
                color: red;
                font-weight: bold;
            }

            .status-waiting {
                color: blue;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <header>
            Employee Leave Management System
        </header>
        <?php include('includes/sidebar.php');?>
        <div class="container">
            <div class="card-title">Leave History</div>
            <?php if($msg){?><div class="succWrap"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Search records...">
                <select id="statusFilter">
                    <option value="">All</option>
                    <option value="approved">Approved</option>
                    <option value="not approved">Not Approved</option>
                    <option value="waiting">Pending</option>
                </select>
            </div>
            <div class="table-container">
                <table id="example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Leave Type</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Description</th>
                            <th>Posting Date</th>
                            <th>Admin Remark</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $eid=$_SESSION['eid'];
                        $sql = "SELECT LeaveType,ToDate,FromDate,Description,PostingDate,AdminRemarkDate,AdminRemark,Status from tblleaves where empid=:eid";
                        $query = $dbh -> prepare($sql);
                        $query->bindParam(':eid',$eid,PDO::PARAM_STR);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                        $cnt=1;
                        if($query->rowCount() > 0)
                        {
                        foreach($results as $result)
                        {               ?>  
                            <tr data-status="<?php echo htmlentities($result->Status == 1 ? 'approved' : ($result->Status == 2 ? 'not approved' : 'waiting')); ?>">
                                <td> <?php echo htmlentities($cnt);?></td>
                                <td><?php echo htmlentities($result->LeaveType);?></td>
                                <td><?php echo htmlentities($result->ToDate);?></td>
                                <td><?php echo htmlentities($result->FromDate);?></td>
                                <td><?php echo htmlentities($result->Description);?></td>
                                <td><?php echo htmlentities($result->PostingDate);?></td>
                                <td><?php if($result->AdminRemark=="")
                                {
                                    echo htmlentities('waiting for approval');
                                } else {
                                    echo htmlentities(($result->AdminRemark)." "."at"." ".$result->AdminRemarkDate);
                                }
                                ?></td>
                                <td><?php $stats=$result->Status;
                                if($stats==1){
                                ?>
                                    <span class="status-approved">Approved</span>
                                <?php } if($stats==2)  { ?>
                                    <span class="status-not-approved">Not Approved</span>
                                <?php } if($stats==0)  { ?>
                                    <span class="status-waiting">waiting for approval</span>
                                <?php } ?>
                                </td>
                            </tr>
                        <?php $cnt++;} }?>
                    </tbody>
                </table>
            </div>
        </div>
        <script>
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const rows = document.querySelectorAll('#example tbody tr');

            function filterTable() {
                const searchValue = searchInput.value.toLowerCase();
                const statusValue = statusFilter.value;

                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    const rowStatus = row.getAttribute('data-status');

                    const matchesSearch = text.includes(searchValue);
                    const matchesStatus = !statusValue || rowStatus === statusValue;

                    row.style.display = matchesSearch && matchesStatus ? '' : 'none';
                });
            }

            searchInput.addEventListener('keyup', filterTable);
            statusFilter.addEventListener('change', filterTable);
        </script>
    </body>
</html>
<?php } ?>