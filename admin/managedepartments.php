<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{   
    header('location:index.php');
}
else{
    if(isset($_GET['del'])){
        $id = $_GET['del'];
        $sql = "delete from tbldepartments WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $msg = "Department record deleted";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Title -->
    <title>Admin | Manage Departments</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <meta name="description" content="Responsive Admin Dashboard Template" />
    <meta name="keywords" content="admin,dashboard" />
    <meta name="author" content="Steelcoders" />

    <!-- Styles -->
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        .page-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            padding: 20px;
            background-color: #fff;
            margin: 0;
        }

        .succWrap, .errorWrap {
            padding: 10px;
            margin-bottom: 20px;
            background: #fff;
            border-left: 4px solid #5cb85c;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        }

        .errorWrap {
            border-left-color: #dd3d36;
        }

        .card {
            margin: 20px;
            padding: 15px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
            margin-left: 250px;
        }

        .card-title {
            font-size: 18px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f1f1f1;
        }

        .search-bar {
            padding: 10px;
            margin: 10px;
            width: 100%;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .search-bar:focus {
            border-color: #5cb85c;
        }

        .actions i {
            margin: 0 10px;
            cursor: pointer;
        }
    </style>

</head>
<body>

<?php include('includes/header.php');?>
<?php include('includes/sidebar.php');?>

<main class="mn-inner">
    <div class="row">
        <div class="col s12">
            <div class="page-title">Manage Departments</div>
        </div>
        <div class="col s12 m12 l12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Departments Info</span>
                    <?php if($msg){?><div class="succWrap"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>

                    <!-- Search Bar -->
                    <input type="text" id="searchBar" class="search-bar" placeholder="Search Departments..." onkeyup="filterDepartments()">

                    <table id="example">
                        <thead>
                            <tr>
                                <th>Sr no</th>
                                <th>Dept Name</th>
                                <th>Dept Short Name</th>
                                <th>Dept Code</th>
                                <th>Creation Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="departmentTableBody">
                            <?php 
                                $sql = "SELECT * from tbldepartments";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $cnt = 1;
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) {
                            ?>  
                            <tr>
                                <td><?php echo htmlentities($cnt);?></td>
                                <td><?php echo htmlentities($result->DepartmentName);?></td>
                                <td><?php echo htmlentities($result->DepartmentShortName);?></td>
                                <td><?php echo htmlentities($result->DepartmentCode);?></td>
                                <td><?php echo htmlentities($result->CreationDate);?></td>
                                <td class="actions">
                                    <a href="editdepartment.php?deptid=<?php echo htmlentities($result->id);?>">
                                        <i class="material-icons">mode_edit</i>
                                    </a>
                                    <a href="managedepartments.php?del=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you want to delete');">
                                        <i class="material-icons">delete_forever</i>
                                    </a>
                                </td>
                            </tr>
                            <?php $cnt++; } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- JavaScript -->
<script>
    // Filter departments by search term
    function filterDepartments() {
        var input, filter, table, rows, cells, i, j, match;
        input = document.getElementById("searchBar");
        filter = input.value.toLowerCase();
        table = document.getElementById("example");
        rows = table.getElementsByTagName("tr");

        for (i = 1; i < rows.length; i++) {
            cells = rows[i].getElementsByTagName("td");
            match = false;

            for (j = 0; j < cells.length; j++) {
                if (cells[j].innerText.toLowerCase().indexOf(filter) > -1) {
                    match = true;
                }
            }

            if (match) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    }
</script>

</body>
</html>
<?php } ?>
