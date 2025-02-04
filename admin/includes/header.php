<div class="loader-bg"></div>
<div class="loader">
    <div class="preloader-wrapper">
        <div class="spinner-layer spinner-blue">
            <div class="circle"></div>
        </div>
        <div class="spinner-layer spinner-teal">
            <div class="circle"></div>
        </div>
        <div class="spinner-layer spinner-yellow">
            <div class="circle"></div>
        </div>
        <div class="spinner-layer spinner-green">
            <div class="circle"></div>
        </div>
    </div>
</div>

<div class="mn-content">
    <header class="mn-header navbar-fixed">
        <nav>
            <div class="nav-wrapper">
                <section class="material-design-hamburger navigation-toggle">
                    <a href="#" data-activates="slide-out" class="button-collapse">
                        <span class="material-design-hamburger__layer"></span>
                    </a>
                </section>
                <div class="header-title">
                    <span class="chapter-title">ELMS | Admin</span>
                </div>
                <ul class="right nav-right-menu">
                    <li><a href="javascript:void(0)" data-activates="dropdown1" class="dropdown-button"><i class="material-icons">notifications_none</i>
                        <?php
                        $isread = 0;
                        $sql = "SELECT id FROM tblleaves WHERE IsRead = :isread";
                        $query = $dbh->prepare($sql);
                        $query->bindParam(':isread', $isread, PDO::PARAM_STR);
                        $query->execute();
                        $unreadcount = $query->rowCount();
                        ?>
                        <span class="badge"><?php echo htmlentities($unreadcount); ?></span></a></li>
                    <li><a href="changepassword.php" class="search-toggle"><i class="material-icons">Change password</i></a></li>
                </ul>
                <ul id="dropdown1" class="notifications-dropdown">
                    <li class="notification-drop-title">Notifications</li>
                    <?php
                    $sql = "SELECT tblleaves.id AS lid, tblemployees.FirstName, tblemployees.LastName, tblemployees.EmpId, tblleaves.PostingDate FROM tblleaves JOIN tblemployees ON tblleaves.empid = tblemployees.id WHERE tblleaves.IsRead = :isread";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':isread', $isread, PDO::PARAM_STR);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    if ($query->rowCount() > 0) {
                        foreach ($results as $result) {
                    ?>
                    <li>
                        <a href="leave-details.php?leaveid=<?php echo htmlentities($result->lid); ?>">
                            <div class="notification">
                                <div class="notification-icon circle cyan"><i class="material-icons">done</i></div>
                                <div class="notification-text">
                                    <p><b><?php echo htmlentities($result->FirstName . " " . $result->LastName); ?><br />(<?php echo htmlentities($result->EmpId); ?>)</b> applied for leave</p>
                                    <span>at <?php echo htmlentities($result->PostingDate); ?></span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <?php }} ?>
                </ul>
            </div>
        </nav>
    </header>
</div>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }
    .loader-bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
        z-index: 9999;
    }
    .loader {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .preloader-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .spinner-layer {
        position: relative;
        width: 36px;
        height: 36px;
        border: 4px solid transparent;
        border-radius: 50%;
    }
    .spinner-layer .circle {
        position: absolute;
        width: 100%;
        height: 100%;
        border: 4px solid #fff;
        border-radius: 50%;
        animation: spin 1.5s infinite linear;
    }
    .spinner-blue .circle {
        border-color: #1e88e5;
    }
    .spinner-teal .circle {
        border-color: #009688;
    }
    .spinner-yellow .circle {
        border-color: #ffeb3b;
    }
    .spinner-green .circle {
        border-color: #4caf50;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .mn-content {
        position: relative;
        padding-top: 50px;
    }
    .mn-header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background-color: #00bcd4;
        z-index: 1000;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .nav-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
    }
    .header-title {
        color: white;
        font-size: 18px;
        font-weight: bold;
    }
    .nav-right-menu {
        list-style: none;
        display: flex;
        gap: 20px;
    }
    .nav-right-menu li {
        color: white;
    }
    .notifications-dropdown {
        min-width: 300px;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        position: absolute;
        top: 60px;
        right: 0;
        padding: 10px;
        display: none;
    }
    .notification {
        display: flex;
        align-items: center;
        padding: 10px;
    }
    .notification-icon {
        background-color: #00bcd4;
        border-radius: 50%;
        color: white;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
    }
    .notification-text {
        font-size: 14px;
    }
    .badge {
        background-color: red;
        color: white;
        padding: 2px 5px;
        border-radius: 50%;
        font-size: 10px;
    }
</style>

<script>
    window.addEventListener('load', function () {
        // Hide loader once content is loaded
        document.querySelector('.loader-bg').style.display = 'none';
        document.querySelector('.loader').style.display = 'none';
    });
</script>
