<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{
// code for Inactive  employee    
if(isset($_GET['inid']))
{
$id=$_GET['inid'];
$status=0;
$sql = "update tblemployees set Status=:status  WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query -> execute();
header('location:manageemployee.php');
}



//code for active employee
if(isset($_GET['id']))
{
$id=$_GET['id'];
$status=1;
$sql = "update tblemployees set Status=:status  WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query -> execute();
header('location:manageemployee.php');
}
 ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Title -->
        <title>Admin | Manage Employees</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta charset="UTF-8">
        <meta name="description" content="Responsive Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Steelcoders" />
        
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f7fc;
                margin: 0;
                padding: 0;
            }
            .page-title {
                font-size: 24px;
                color: #333;
                margin: 20px;
            }
            .card {
                background: #fff;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                margin: 20px;
                padding: 20px;
                margin-left: 250px;
            }
            .card-title {
                font-size: 20px;
                margin-bottom: 20px;
                font-weight: bold;
            }
            .table-wrapper {
                overflow-x: auto;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }
            th, td {
                padding: 12px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }
            th {
                background-color: #f2f2f2;
                color: #555;
            }
            .search-bar {
                width: 100%;
                padding: 10px;
                margin-bottom: 20px;
                border-radius: 5px;
                border: 1px solid #ccc;
                font-size: 16px;
            }
            .status-btn {
                padding: 5px 10px;
                border-radius: 5px;
                font-size: 14px;
            }
            .active {
                background-color: #4CAF50;
                color: white;
            }
            .inactive {
                background-color: #F44336;
                color: white;
            }
            .filter {
                padding: 10px;
                margin-bottom: 20px;
            }
            .filter select {
                padding: 8px;
                border-radius: 5px;
                border: 1px solid #ccc;
            }
            .actions i {
                padding: 5px;
                font-size: 18px;
                cursor: pointer;
            }
            .actions i:hover {
                color: #007BFF;
            }
        </style>
    </head>
    <body>
       <?php include('includes/header.php');?>

       <?php include('includes/sidebar.php');?>
       
        <main class="mn-inner">
            <div class="row">
                <div class="col s12">
                    <div class="page-title">Manage Employees</div>
                </div>

                <div class="col s12 m12 l12">
                    <div class="card">
                        <div class="card-content">
                            <span class="card-title">Employees Info</span>
                            <?php if($msg){?><div class="succWrap"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>

                            <!-- Search Bar -->
                            <input type="text" id="search-bar" class="search-bar" placeholder="Search Employees...">

                            <!-- Filters -->
                            <div class="filter">
                                <select id="status-filter">
                                    <option value="">Filter by Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <div class="table-wrapper">
                                <table id="employee-table" class="responsive-table">
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Emp ID</th>
                                            <th>Full Name</th>
                                            <th>Department</th>
                                            <th>Status</th>
                                            <th>Reg Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT EmpId,FirstName,LastName,Department,Status,RegDate,id from tblemployees";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;

                                        if($query->rowCount() > 0) {
                                            foreach($results as $result) {
                                        ?>  
                                        <tr>
                                            <td><?php echo htmlentities($cnt);?></td>
                                            <td><?php echo htmlentities($result->EmpId);?></td>
                                            <td><?php echo htmlentities($result->FirstName);?> <?php echo htmlentities($result->LastName);?></td>
                                            <td><?php echo htmlentities($result->Department);?></td>
                                            <td>
                                                <?php $stats=$result->Status; 
                                                    if($stats){ 
                                                ?>
                                                    <a class="status-btn active">Active</a>
                                                <?php } else { ?>
                                                    <a class="status-btn inactive">Inactive</a>
                                                <?php } ?>
                                            </td>
                                            <td><?php echo htmlentities($result->RegDate);?></td>
                                            <td class="actions">
                                                <a href="editemployee.php?empid=<?php echo htmlentities($result->id);?>"><i class="material-icons">mode_edit</i></a>
                                                <?php if($result->Status==1) { ?>
                                                    <a href="manageemployee.php?inid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Are you sure you want to inactive this Employee?');"><i class="material-icons" title="Inactive">clear</i></a>
                                                <?php } else { ?>
                                                    <a href="manageemployee.php?id=<?php echo htmlentities($result->id);?>" onclick="return confirm('Are you sure you want to active this Employee?');"><i class="material-icons" title="Active">done</i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php $cnt++; } } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <script>
            document.getElementById('search-bar').addEventListener('input', function() {
                var filter = this.value.toUpperCase();
                var rows = document.querySelector('#employee-table tbody').rows;
                for (var i = 0; i < rows.length; i++) {
                    var cells = rows[i].cells;
                    var name = cells[2].textContent || cells[2].innerText;
                    if (name.toUpperCase().indexOf(filter) > -1) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            });

            document.getElementById('status-filter').addEventListener('change', function() {
                var status = this.value;
                var rows = document.querySelector('#employee-table tbody').rows;
                for (var i = 0; i < rows.length; i++) {
                    var cell = rows[i].cells[4];
                    if (status === '' || cell.textContent.includes(status === '1' ? 'Active' : 'Inactive')) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            });
        </script>

    </body>
</html>
<?php } ?>
