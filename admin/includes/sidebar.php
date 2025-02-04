<aside id="slide-out" class="side-nav" style="position: fixed; top: 0; left: 0; height: 100%; width: 200px; background-color: #ffffff; box-shadow: 2px 0px 5px rgba(0, 0, 0, 0.1); z-index: 1000; padding: 20px; overflow-y: auto; font-family: Arial, sans-serif;">
    <div class="side-nav-wrapper">
        <div class="sidebar-profile" style="display: flex; align-items: center; margin-bottom: 30px;">
            <div class="sidebar-profile-image" style="margin-right: 10px;">
                <img src="../assets/images/profile-image.png" class="circle" alt="Profile Image" style="width: 40px; height: 40px; border-radius: 50%;">
            </div>
            <div class="sidebar-profile-info">
                <p style="margin: 0; font-weight: bold; font-size: 16px;">Admin</p>
            </div>
        </div>

        <ul class="sidebar-menu" style="list-style: none; padding: 0; margin: 0;">
            <li style="padding: 10px 0;">
                <a href="dashboard.php" style="display: flex; align-items: center; color: #555; text-decoration: none; font-size: 14px; padding: 10px; border-radius: 4px; transition: background-color 0.3s ease;">
                    <i class="material-icons" style="margin-right: 10px;"></i>Dashboard
                </a>
            </li>

            <li style="padding: 10px 0;">
                <a class="collapsible-header" style="display: flex; align-items: center; justify-content: space-between; cursor: pointer; color: #555; text-decoration: none; font-size: 14px; padding: 10px; border-radius: 4px; transition: background-color 0.3s ease;">
                    <span><i class="material-icons" style="margin-right: 10px;"></i>Department</span>
                    <i class="nav-drop-icon material-icons">></i>
                </a>
                <div class="collapsible-body" style="display: none; margin-left: 20px;">
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="padding: 5px 0;"><a href="adddepartment.php" style="padding-left: 20px;">Add Department</a></li>
                        <li style="padding: 5px 0;"><a href="managedepartments.php" style="padding-left: 20px;">Manage Department</a></li>
                    </ul>
                </div>
            </li>

            <li style="padding: 10px 0;">
                <a class="collapsible-header" style="display: flex; align-items: center; justify-content: space-between; cursor: pointer; color: #555; text-decoration: none; font-size: 14px; padding: 10px; border-radius: 4px; transition: background-color 0.3s ease;">
                    <span><i class="material-icons" style="margin-right: 10px;"></i>Leave Type</span>
                    <i class="nav-drop-icon material-icons">></i>
                </a>
                <div class="collapsible-body" style="display: none; margin-left: 20px;">
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="padding: 5px 0;"><a href="addleavetype.php" style="padding-left: 20px;">Add Leave Type</a></li>
                        <li style="padding: 5px 0;"><a href="manageleavetype.php" style="padding-left: 20px;">Manage Leave Type</a></li>
                    </ul>
                </div>
            </li>

            <li style="padding: 10px 0;">
                <a class="collapsible-header" style="display: flex; align-items: center; justify-content: space-between; cursor: pointer; color: #555; text-decoration: none; font-size: 14px; padding: 10px; border-radius: 4px; transition: background-color 0.3s ease;">
                    <span><i class="material-icons" style="margin-right: 10px;"></i>Employees</span>
                    <i class="nav-drop-icon material-icons">></i>
                </a>
                <div class="collapsible-body" style="display: none; margin-left: 20px;">
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="padding: 5px 0;"><a href="addemployee.php" style="padding-left: 20px;">Add Employee</a></li>
                        <li style="padding: 5px 0;"><a href="manageemployee.php" style="padding-left: 20px;">Manage Employee</a></li>
                    </ul>
                </div>
            </li>

            <li style="padding: 10px 0;">
                <a class="collapsible-header" style="display: flex; align-items: center; justify-content: space-between; cursor: pointer; color: #555; text-decoration: none; font-size: 14px; padding: 10px; border-radius: 4px; transition: background-color 0.3s ease;">
                    <span><i class="material-icons" style="margin-right: 10px;"></i>Leave Management</span>
                    <i class="nav-drop-icon material-icons">></i>
                </a>
                <div class="collapsible-body" style="display: none; margin-left: 20px;">
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="padding: 5px 0;"><a href="leaves.php" style="padding-left: 20px;">All Leaves</a></li>
                        <li style="padding: 5px 0;"><a href="pending-leavehistory.php" style="padding-left: 20px;">Pending Leaves</a></li>
                        <li style="padding: 5px 0;"><a href="approvedleave-history.php" style="padding-left: 20px;">Approved Leaves</a></li>
                        <li style="padding: 5px 0;"><a href="notapproved-leaves.php" style="padding-left: 20px;">Not Approved Leaves</a></li>
                    </ul>
                </div>
            </li>

            <li style="padding: 10px 0;">
                <a href="logout.php" style="display: flex; align-items: center; color: #555; text-decoration: none; font-size: 14px; padding: 10px; border-radius: 4px; transition: background-color 0.3s ease;">
                    <i class="material-icons" style="margin-right: 10px;"></i>Sign Out
                </a>
            </li>
        </ul>

        <ul>
            <a href="check_availability.php">Check Availability</a>
        </ul>
    </div>

    <script>
        // Script to toggle collapsible menu
        const collapsibleHeaders = document.querySelectorAll('.collapsible-header');
        collapsibleHeaders.forEach(header => {
            header.addEventListener('click', () => {
                header.classList.toggle('active');
                const body = header.nextElementSibling;
                body.style.display = body.style.display === 'none' ? 'block' : 'none';
            });
        });
    </script>
</aside>
