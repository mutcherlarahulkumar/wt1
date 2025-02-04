<aside id="slide-out" class="side-nav fixed">
    <style>
        /* Sidebar Styles */
        .side-nav {
            width: 200px; /* Sidebar width */
            background-color: white;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
            z-index: 999; /* Ensures sidebar is above other content */
            padding-top: 20px; /* Space from top */
        }

        .sidebar-profile {
            text-align: center;
            padding-bottom: 20px;
        }

        .sidebar-profile-image img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        .sidebar-profile-info p {
            margin: 10px 0 5px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .sidebar-profile-info span {
            font-size: 14px;
            color: #777;
        }

        /* Menu Styles */
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            border-bottom: 1px solid #f0f0f0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            color: #333;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .sidebar-menu a:hover {
            background-color: #f5f5f5;
        }

        .sidebar-menu i {
            margin-right: 15px;
            font-size: 20px;
            color: #666;
        }

        .collapsible-body {
            display: none;
            background-color: #f9f9f9;
            padding-left: 20px;
        }

        .footer {
            text-align: center;
            padding: 10px 0;
            font-size: 14px;
            color: #999;
        }

        .footer a {
            color: #009688;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>

    <!-- Sidebar Content -->
    <div class="sidebar-profile">
        <div class="sidebar-profile-image">
            <img src="assets/images/profile-image.png" alt="Profile Image">
        </div>
        <div class="sidebar-profile-info">
            <?php
            $eid = $_SESSION['eid'];
            $sql = "SELECT FirstName, LastName, EmpId FROM tblemployees WHERE id = :eid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':eid', $eid, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            if ($query->rowCount() > 0) {
                foreach ($results as $result) { ?>
                    <p><?php echo htmlentities($result->FirstName . " " . $result->LastName); ?></p>
                    <span><?php echo htmlentities($result->EmpId); ?></span>
            <?php }
            } ?>
        </div>
    </div>

    <ul class="sidebar-menu">
        <li><a href="myprofile.php"></i>My Profile</a></li>
        <li><a href="emp-changepassword.php"></i>Change Password</a></li>
        <li>
            <a class="collapsible-header" onclick="toggleCollapsible(this)"></i>Leaves
                <i class="material-icons nav-drop-icon">></i>
            </a>
            <div class="collapsible-body">
                <ul>
                    <li><a href="apply-leave.php">Apply Leave</a></li>
                    <li><a href="leavehistory.php">Leave History</a></li>
                </ul>
            </div>
        </li>
        <li><a href="logout.php"></i>Sign Out</a></li>
    </ul>

    <div class="footer">
        <p>&copy; 2025 Your Company</p>
    </div>

    <script>
        function toggleCollapsible(element) {
            const collapsibleBody = element.nextElementSibling;
            const icon = element.querySelector('.nav-drop-icon');
            if (collapsibleBody.style.display === "block") {
                collapsibleBody.style.display = "none";
                icon.textContent = ">"; // Update icon to show closed state
            } else {
                collapsibleBody.style.display = "block";
                icon.textContent = "^"; // Update icon to show open state
            }
        }
    </script>
</aside>
