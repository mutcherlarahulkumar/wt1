<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['emplogin'])==0)
{   
    header('location:index.php');
}
else{
    if(isset($_POST['apply']))
    {
        $empid=$_SESSION['eid'];
        $leavetype=$_POST['leavetype'];
        $fromdate=$_POST['fromdate'];  
        $todate=$_POST['todate'];
        $description=$_POST['description'];  
        $status=0;
        $isread=0;
        if($fromdate > $todate){
            $error=" ToDate should be greater than FromDate ";
        }
        $sql="INSERT INTO tblleaves(LeaveType,ToDate,FromDate,Description,Status,IsRead,empid) VALUES(:leavetype,:fromdate,:todate,:description,:status,:isread,:empid)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':leavetype',$leavetype,PDO::PARAM_STR);
        $query->bindParam(':fromdate',$fromdate,PDO::PARAM_STR);
        $query->bindParam(':todate',$todate,PDO::PARAM_STR);
        $query->bindParam(':description',$description,PDO::PARAM_STR);
        $query->bindParam(':status',$status,PDO::PARAM_STR);
        $query->bindParam(':isread',$isread,PDO::PARAM_STR);
        $query->bindParam(':empid',$empid,PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if($lastInsertId)
        {
            $msg="Leave applied successfully";
        }
        else 
        {
            $error="Something went wrong. Please try again";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Employee | Apply Leave</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px; /* Reduced margin */
            padding: 15px;
            margin-left: 250px;
        }
        .errorWrap, .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }
        .errorWrap {
            border-left-color: #dd3d36;
        }
        .succWrap {
            border-left-color: #5cb85c;
        }
        .page-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }
        .card {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card-content {
            padding: 20px;
        }
        .input-field {
            margin-bottom: 20px;
        }
        .input-field input, .input-field textarea, .input-field select {
            padding: 10px;
            border: 1px solid #ccc;
            width: 100%;
            border-radius: 4px;
            font-size: 16px;
        }
        .input-field label {
            font-size: 14px;
            color: #555;
        }
        button {
            background-color: #2196f3;
            padding: 10px 20px;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
        }
        button:hover {
            background-color: #0b7dda;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>
<body>

    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <main class="mn-inner">
        <div class="row">
            <div class="col s12">
                <div class="page-title">Apply for Leave</div>
            </div>
            <div class="col s12 m12 l8">
                <div class="card">
                    <div class="card-content">
                        <form method="post" name="addemp">
                            <div>
                                <h3>Apply for Leave</h3>
                                <section>
                                    <div class="row">
                                        <?php if($error){?><div class="errorWrap"><strong>ERROR </strong>:<?php echo htmlentities($error); ?> </div><?php } 
                                        else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
                                        <div class="input-field col s12">
                                            <select name="leavetype" autocomplete="off">
                                                <option value="">Select leave type...</option>
                                                <?php 
                                                $sql = "SELECT LeaveType from tblleavetype";
                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                if($query->rowCount() > 0)
                                                {
                                                    foreach($results as $result)
                                                    {   
                                                        ?>                                            
                                                        <option value="<?php echo htmlentities($result->LeaveType);?>"><?php echo htmlentities($result->LeaveType);?></option>
                                                    <?php }} ?>
                                            </select>
                                        </div>

                                        <div class="input-field col m6 s12">
                                            <label for="fromdate">From Date</label>
                                            <input placeholder="" name="fromdate" class="masked" type="date" data-inputmask="'alias': 'date'" required>
                                        </div>
                                        <div class="input-field col m6 s12">
                                            <label for="todate">To Date</label>
                                            <input placeholder="" name="todate" class="masked" type="date" data-inputmask="'alias': 'date'" required>
                                        </div>
                                        <div class="input-field col m12 s12">
                                            <label for="description">Description</label>    
                                            <textarea name="description" class="materialize-textarea" length="500" required></textarea>
                                        </div>
                                    </div>
                                    <button type="submit" name="apply" id="apply">Apply</button>                                             
                                </section>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>

<?php } ?>
