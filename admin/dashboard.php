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
        <title>Admin | Dashboard</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Responsive Admin Dashboard">
        <meta name="keywords" content="admin, dashboard">
        
        <!-- Internal Styles -->
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f5f5f5;
            }
            .container {
                width: 80%;
                margin: 20px auto;
                margin-left: 250px;
            }
            .card {
                background-color: #fff;
                border-radius: 8px;
                padding: 20px;
                margin-bottom: 20px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
            .card-title {
                font-size: 20px;
                font-weight: bold;
            }
            .counter {
                font-size: 24px;
                font-weight: bold;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            table th, table td {
                padding: 10px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }
            .btn {
                background-color: #007bff;
                color: white;
                padding: 8px 16px;
                border-radius: 4px;
                text-decoration: none;
            }
            .btn:hover {
                background-color: #0056b3;
            }
            .filter-container {
                margin-bottom: 20px;
            }
            .filter-container select, .filter-container input {
                padding: 8px;
                font-size: 16px;
                border-radius: 4px;
                margin-right: 10px;
            }
            .status-approved {
                color: green;
            }
            .status-not-approved {
                color: red;
            }
            .status-waiting {
                color: blue;
            }
        </style>
    </head>
    <body>
        <?php include('includes/header.php'); ?>
        <?php include('includes/sidebar.php'); ?>
        
        <main class="mn-inner">
            <div class="container">
                <div class="row">
                    <div class="col s12 m12 l4">
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title">Total Registered Employees</span>
                                <span class="counter">
                                    <?php
                                    $sql = "SELECT id from tblemployees";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    echo htmlentities($query->rowCount());
                                    ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m12 l4">
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title">Listed Departments</span>
                                <span class="counter">
                                    <?php
                                    $sql = "SELECT id from tbldepartments";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    echo htmlentities($query->rowCount());
                                    ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m12 l4">
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title">Listed Leave Types</span>
                                <span class="counter">
                                    <?php
                                    $sql = "SELECT id from tblleavetype";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    echo htmlentities($query->rowCount());
                                    ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="filter-container">
                    <form method="GET" action="">
                        <select name="status" id="status">
                            <option value="">Filter by Status</option>
                            <option value="1" <?php echo ($_GET['status'] == 1) ? 'selected' : ''; ?>>Approved</option>
                            <option value="2" <?php echo ($_GET['status'] == 2) ? 'selected' : ''; ?>>Not Approved</option>
                            <option value="0" <?php echo ($_GET['status'] == 0) ? 'selected' : ''; ?>>Waiting</option>
                        </select>
                        <input type="text" name="search" id="search" placeholder="Search by Employee Name" value="<?php echo $_GET['search']; ?>" />
                        <button type="submit" class="btn">Filter</button>
                    </form>
                </div>

                <!-- Latest Leave Applications Table -->
                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title">Latest Leave Applications</span>
                                <table>
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
                                        // Apply filters for status and search
                                        $statusFilter = isset($_GET['status']) ? "AND tblleaves.Status = " . $_GET['status'] : '';
                                        $searchFilter = isset($_GET['search']) ? "AND (tblemployees.FirstName LIKE '%" . $_GET['search'] . "%' OR tblemployees.LastName LIKE '%" . $_GET['search'] . "%')" : '';
                                        
                                        $sql = "SELECT tblleaves.id as lid, tblemployees.FirstName, tblemployees.LastName, tblleaves.LeaveType, tblleaves.PostingDate, tblleaves.Status
                                                FROM tblleaves 
                                                JOIN tblemployees ON tblleaves.empid = tblemployees.id 
                                                WHERE 1 $statusFilter $searchFilter 
                                                ORDER BY tblleaves.id DESC 
                                                LIMIT 6";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) { 
                                        ?>
                                            <tr>
                                                <td><?php echo htmlentities($cnt); ?></td>
                                                <td><a href="editemployee.php?empid=<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->FirstName . " " . $result->LastName); ?></a></td>
                                                <td><?php echo htmlentities($result->LeaveType); ?></td>
                                                <td><?php echo htmlentities($result->PostingDate); ?></td>
                                                <td>
                                                    <?php 
                                                    if ($result->Status == 1) {
                                                        echo '<span class="status-approved">Approved</span>';
                                                    } elseif ($result->Status == 2) {
                                                        echo '<span class="status-not-approved">Not Approved</span>';
                                                    } else {
                                                        echo '<span class="status-waiting">Waiting for Approval</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td><a href="leave-details.php?leaveid=<?php echo htmlentities($result->lid); ?>" class="btn">View Details</a></td>
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
                    </div>
                </div>
            </div>
        </main>

        <!-- Internal Scripts -->
        <script>
            // Ensuring the form is submitted properly without relying on external JS
        </script>

    </body>
</html>

<?php } ?>
