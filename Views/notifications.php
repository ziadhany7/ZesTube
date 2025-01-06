<?php require_once '../Models/header.php' ?>
<style>
    @import url(https://fonts.googleapis.com/css?family=Roboto:300,400,700&display=swap);

    body {
        font-family: "Roboto", sans-serif;
        background: #EFF1F3;
        min-height: 100vh;
        position: relative;
    }

    .section-50 {
        padding: 50px 0;
    }

    .m-b-50 {
        margin-bottom: 50px;
    }

    .dark-link {
        color: #333;
    }

    .heading-line {
        position: relative;
        padding-bottom: 5px;
    }

    .heading-line:after {
        content: "";
        height: 4px;
        width: 75px;
        background-color: red;
        position: absolute;
        bottom: 0;
        left: 0;
    }

    .notification-ui_dd-content {
        margin-bottom: 30px;
    }

    .notification-list {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
        padding: 20px;
        margin-bottom: 7px;
        background: #fff;
        -webkit-box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
    }

    .notification-list--unread {
        border-left: 2px solid red;
    }

    .notification-list .notification-list_content {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
    }

    .notification-list .notification-list_content .notification-list_img img {
        height: 48px;
        width: 48px;
        border-radius: 50px;
        margin-right: 20px;
    }

    .notification-list .notification-list_content .notification-list_detail p {
        margin-bottom: 5px;
        line-height: 1.2;
    }
</style>


<?php
require_once '../Models/classes/Notification.php';
if(isset($_SESSION['UserId'])){


$notif = new Notification();
$usrID = $_SESSION['UserId'];
$num = $notif->getNumberOfNotifications($usrID);

$allNotifications = $notif->displayNotifications($usrID);
if(isset($_POST['read'])){
    $notif->markAsRead($usrID);
    echo "<meta http-equiv='refresh' content='0'>";
}
foreach ($allNotifications as $notification) {
    $seenOrnot = $notification['seen'];
    $unread = '';
    if ($seenOrnot == 0) {
        $unread = '--unread';
    } else {
        $unread = '';
        $num -= 1;
    }
}
?>
<section class="section-50 mt-5">
    <div class="container">

        <h3 class="m-b-50 heading-line">Notifications <i class="fa fa-bell text-muted"></i> <span class="badge bg-danger"><?php echo $num ?></span></h3>
        <div class="mb-5">
            <form method="post">
                <button type="submit" class="ms-xxl-5 btn btn-danger" name="read">Mark all as read</button>
            </form>
        </div>

        <div class="notification-ui_dd-content">
            <?php
            $allNotifications = $notif->displayNotifications($usrID);
            foreach ($allNotifications as $notification) {
                $seenOrnot = $notification['seen'];
                $unread = '';
                if ($seenOrnot == 0) {
                    $unread = '--unread';
                } else {
                    $unread = '';
                }
                echo '
                    <div class="notification-list notification-list' . $unread . '">
                    <div class="notification-list_content">
                        <div class="me-5">
                            <i class="fa-solid fa-bell"></i>
                        </div>
                        <div class="notification-list_detail">
                            <p><b>' . $notification['notification'] . '</b></p>
                        </div>
                    </div>
                </div>
                    ';
            }
            ?>
        </div>
    </div>
</section>
<?php 
}
else{
    echo '<script>
    alert("Access denied");
    </script>';
    echo "<script>setTimeout(\"location.href = './index.php';\");</script>";
}
?>
<?php require_once '../Models/footer.php'; ?>