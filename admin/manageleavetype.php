<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{   
    header('location:index.php');
}
else{
    if(isset($_GET['del']))
    {
        $id=$_GET['del'];
        $sql = "delete from  tblleavetype  WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query -> bindParam(':id',$id, PDO::PARAM_STR);
        $query -> execute();
        $msg="Leave type record deleted";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin Dashboard for Managing Leave Types">
    <title>Admin | Manage Leave Type</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .header, .sidebar {
            background-color: #1e2a3a;
            color: white;
            padding: 10px 15px;
        }
        .page-title {
            font-size: 24px;
            font-weight: bold;
        }
        .content {
            padding: 20px;
            margin-left: 250px;
        }
        .card {
            background-color: white;
            padding: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .succWrap, .errorWrap {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .succWrap {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }
        .errorWrap {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        .table-wrapper {
            margin-top: 20px;
            background-color: #ffffff;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #1e2a3a;
            color: white;
        }
        .search-bar {
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
        }
        .search-bar input {
            padding: 8px;
            font-size: 16px;
            width: 30%;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .filter-btn {
            padding: 8px 15px;
            font-size: 16px;
            color: white;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
        }
        .filter-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="header">
        <?php include('includes/header.php'); ?>
    </div>

    <div class="sidebar">
        <?php include('includes/sidebar.php'); ?>
    </div>

    <div class="content">
        <div class="page-title">Manage Leave Type</div>

        <?php if($msg){?><div class="succWrap"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>

        <div class="search-bar">
            <input type="text" id="searchBar" placeholder="Search Leave Types" onkeyup="searchTable()">
            <button class="filter-btn" onclick="filterTable()">Apply Filter</button>
        </div>

        <div class="card">
            <div class="card-content">
                <div class="table-wrapper">
                    <table id="leaveTable" class="display responsive-table">
                        <thead>
                            <tr>
                                <th>Sr No</th>
                                <th>Leave Type</th>
                                <th>Description</th>
                                <th>Creation Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $sql = "SELECT * from tblleavetype";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            $cnt = 1;
                            if($query->rowCount() > 0) {
                                foreach($results as $result) { ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt); ?></td>
                                        <td><?php echo htmlentities($result->LeaveType); ?></td>
                                        <td><?php echo htmlentities($result->Description); ?></td>
                                        <td><?php echo htmlentities($result->CreationDate); ?></td>
                                        <td>
                                            <a href="editleavetype.php?lid=<?php echo htmlentities($result->id);?>">
                                                <i class="material-icons">mode_edit</i>
                                            </a>
                                            <a href="manageleavetype.php?del=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you want to delete');">
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

    <script>
        function searchTable() {
            let input = document.getElementById('searchBar').value.toUpperCase();
            let table = document.getElementById('leaveTable');
            let rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                let cells = rows[i].getElementsByTagName('td');
                let match = false;

                for (let j = 0; j < cells.length; j++) {
                    if (cells[j].textContent.toUpperCase().includes(input)) {
                        match = true;
                        break;
                    }
                }

                if (match) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }

        function filterTable() {
            alert('Filter functionality can be added as per the requirement.');
        }
    </script>
</body>
</html>
<?php } ?>
