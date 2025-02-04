<?php 
require_once("includes/config.php");

// Add CSS styling internally for better presentation
echo "<style>
    .available { color: green; }
    .not-available { color: red; }
    #add { margin-top: 10px; padding: 8px 15px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; }
    #add:disabled { background-color: #ccc; cursor: not-allowed; }
    input { margin: 5px; padding: 10px; width: 200px; border-radius: 5px; border: 1px solid #ccc; }
    label { font-weight: bold; }
</style>";

// Add JavaScript to handle dynamic enabling/disabling of the 'Add' button
echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
<script>
    $(document).ready(function(){
        // Initially disable the Add button
        $('#add').prop('disabled', true);

        // Check availability of empcode when user clicks the 'Check' button
        $('#check-empcode').on('click', function(e){
            e.preventDefault(); // Prevent form submission
            var empcode = $('#empcode').val();
            if(empcode.length >= 3) { // Trigger after 3 characters are typed
                $.post('', { empcode: empcode }, function(response){
                    $('#empcode-status').html(response);
                    toggleAddButton(); // Check if both are valid to enable 'Add' button
                });
            }
        });

        // Check availability of emailid when user clicks the 'Check' button
        $('#check-emailid').on('click', function(e){
            e.preventDefault(); // Prevent form submission
            var emailid = $('#emailid').val();
            if(emailid.length >= 3) { // Trigger after 3 characters are typed
                $.post('', { emailid: emailid }, function(response){
                    $('#emailid-status').html(response);
                    toggleAddButton(); // Check if both are valid to enable 'Add' button
                });
            }
        });

        // Function to enable Add button if both fields are valid
        function toggleAddButton() {
            var empcodeValid = $('#empcode-status').hasClass('available');
            var emailidValid = $('#emailid-status').hasClass('available');
            if(empcodeValid && emailidValid) {
                $('#add').prop('disabled', false);
            } else {
                $('#add').prop('disabled', true);
            }
        }
    });
</script>";

// Display the form
echo "<form method='post' action=''>
    <label for='empcode'>Employee Code:</label><br>
    <input type='text' id='empcode' name='empcode' required><br>
    <button type='button' id='check-empcode'>Check</button><br>
    <span id='empcode-status'></span><br><br>

    <label for='emailid'>Email ID:</label><br>
    <input type='email' id='emailid' name='emailid' required><br>
    <button type='button' id='check-emailid'>Check</button><br>
    <span id='emailid-status'></span><br><br>

    <button type='submit' id='add' disabled>Add</button>
</form>";

// Code for empid availability (PHP)
if (!empty($_POST["empcode"])) {
    $empid = $_POST["empcode"];
    $sql = "SELECT EmpId FROM tblemployees WHERE EmpId=:empid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':empid', $empid, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
        echo "<span class='not-available'>Employee id already exists.</span>";
    } else {
        echo "<span class='available'>Employee id available for Registration.</span>";
    }
}

// Code for emailid availability (PHP)
if (!empty($_POST["emailid"])) {
    $emailid = $_POST["emailid"];
    $sql = "SELECT EmailId FROM tblemployees WHERE EmailId=:emailid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':emailid', $emailid, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
        echo "<span class='not-available'>Email id already exists.</span>";
    } else {
        echo "<span class='available'>Email id available for Registration.</span>";
    }
}
?>
