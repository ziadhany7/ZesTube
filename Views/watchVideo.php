<?php require_once '../Models/header.php' ?>

<style>
    .showVideo {
        width: 90% !important;
        height: auto !important;
        margin-top: 10% !important;
        margin-left: 5% !important;
    }

    ;

    .btn {
        padding: 50% !important;
        margin-left: 150% !important;
    }

    ;

    .comment {
        width: 50%;
    }

    ;
</style>

<?php
require_once '../Models/classes/Video.php';
require_once '../Models/classes/Like.php';
require_once '../Models/classes/Comment.php';
require_once '../Models/classes/Subscribe.php';
require_once '../Models/classes/User.php';
require_once '../Models/classes/Channel.php';
require_once '../Models/classes/Notification.php';
require_once '../Models/classes/Watchlater.php';

$vidUrl = $_GET['url'];
$vid = new Video();
$vid->GetVideoInfo($vidUrl);
$vidT = $vid->getVideoTitle();
$vidD = $vid->getVideoDescription();
$vidL = $vid->getNumOfLikes();
$vidID = $vid->getVideoID();
$vidV = $vid->getNumOfViews();
$vidV += 1;
$vid->updateViews($vidV);
$vidV = $vid->getNumOfViews();
$vidDate = $vid->getDateUploaded();
$vidChannID = $vid->getChannelId();

$chann = new Channel();
$chann->GetChannelInfoChannID($vidChannID);
$channName = $chann->getChannelName();
$channID = $chann->getChannelId();
$channSubs = $chann->getNumberOfSubscribers($channID);
$channUsr = $chann->getUserID();
if (isset($_SESSION['UserId'])) {
    $usrid = $_SESSION['UserId'];

    $usr = new User();
    $usr->GetProfileInfo($usrid);
    $fName = $usr->getFName();
    $lName = $usr->getLName();
}


if (isset($_POST['submit'])) {
    if (isset($usrid)) {
        if (!empty($_POST['msg'])) {
            $comment = new Comment();
            $msg = $_POST['msg'];
            $comm = $comment->addComment($msg, $usrid, $vidID);
            $notif = new Notification();
            $notifcation = $fName . ' ' . $lName . ' commented on your video';
            $notif->notify($usrid, $notifcation, 'comment', 0, $channUsr);
            echo "<meta http-equiv='refresh' content='0'>";
        }
    } else {
        echo '<script>
        alert("You are guest please register")
        </script>';
    }
}

if (isset($_POST['like'])) {
    if (isset($usrid)) {
        if ($usrid != $channUsr) {
            $like = new Like();
            $msg = $like->Like($usrid, $vidID);
            $notif = new Notification();
            $notifcation = $fName . ' ' . $lName . ' ' . $msg . ' your video';
            $notif->notify($usrid, $notifcation, 'like', 0, $channUsr);
            echo "<meta http-equiv='refresh' content='0'>";
        }
    } else {
        echo '<script>
        alert("You are guest please register")
        </script>';
    }
}

if (isset($_POST['wlater'])) {
    if (isset($usrid)) {
        $viewWatchL = new Watchlater();
        $viewWatchL->AddToWatchLater($usrid, $vidID);
        echo "<meta http-equiv='refresh' content='0'>";
        echo "<div class='alert alert-success text-center' role='alert'>'Successful pressed'</div>";
    } else {
        echo '<script>
        alert("You are guest please register")
        </script>';
    }
}

if (isset($_POST['sub'])) {
    if (isset($usrid)) {
        if ($usrid != $channUsr) {
            $sub = new Subscribe();
            $msg = $sub->subscribe($usrid, $channID);
            $notif = new Notification();
            $notifcation = $fName . ' ' . $lName . ' ' . $msg . ' to your channel';
            $notif->notify($usrid, $notifcation, 'subscribe', 0, $channUsr);
            echo "<meta http-equiv='refresh' content='0'>";
        }
    } else {
        echo '<script>
        alert("You are guest please register")
        </script>';
    }
}
$shareLink = "http://localhost/ZesTube/Views/watchVideo.php?url=" . $vidUrl;

if (isset($_GET['url'])) {
    $url = $_GET['url'];
    echo '<input type="text" id="url" value="' . $shareLink . '" style="position: absolute; left: -1000px;">';
    echo '<script>
function copy() {
    var Url = document.getElementById("url");
    Url.select();
    document.execCommand("copy");
    alert("URL copied to clipboard!");
}
</script>';
}

?>


<div>
    <div class="col">
        <div class="card ">
            <div class="mt-5"><video class="showVideo" src="../Views/uploads/videos/<?php echo $vidUrl; ?>" controls></video></div>
            <div class="card-body">
                <b>
                    <h2 class="card-title"><?php echo $vidT; ?></h2>
                </b>
                <h5 class="card-title text-danger">Description</h5>
                <p class="card-text"><?php echo $vidD; ?></p>
                <h5 class="card-title text-danger">Views</h5>
                <p class="card-text"><?php echo $vidV; ?></p>
            </div>
        </div>
    </div>
    <div class="grid text-center ">
        <div class="channelCard ">
            <div class="card mt-4" style="width: 18rem; margin-left: 4%;">
                <div class="card-body">
                    <form method="post" action="">
                        <a href="../Views/visitChannel.php?channel_ID=<?php echo $channID ?>" style="text-decoration: none;">
                            <h5 class="card-title" style="display: inline;"><?php echo $channName ?></h5>
                        </a>
                        <button type="submit" class="mt-2 ms-2 btn btn-danger" name='sub'>Subscribers <?php echo $channSubs ?></button>
                    </form>
                </div>
            </div>
        </div>

        <div>
            <form method="post" action="">
                <button type="submit" class="btn btn-outline-danger mt-5" style="height:90%;" name='like'><?php echo $vidL ?> Like
                    <i class="fa-solid fa-heart"></i>
                </button>
            </form>
        </div>
        <div>
            <form method="post" action="">
                <button type="submit" class="btn btn-outline-dark mt-5" style="height:90%;" name='wlater'> Watch later
                </button>
            </form>
        </div>

        <div>
            <form method="post" action="">
                <button class="btn btn-outline-dark mt-5" style="height:90%;" name="shareVideo" onclick="copy()">Share
                    <i class="fa-solid fa-share"></i>
                </button>
            </form>
        </div>
        <div>
            <form method="post" action="./reportVideo.php?vidID=<?php echo $vidID ?>">
                <button type="submit" class="btn btn-outline-dark mt-5" style="height:90%; width:150px;">Report Video
                    <i class="fa-solid fa-bug"></i>
                </button>
            </form>
        </div>
    </div>
    </br>

    </br>
</div>

<center>
    <div class="input-group mb-3 p-5">
        <form method="post" style="width:100%">
            <input type="text" class="form-control" placeholder="Write Your Comment..." aria-label="text-box" name="msg" autocomplete="off" style="width: 100%; height:60px;">
            <button type="submit" class="btn btn-outline-danger mt-2" name="submit" style="width:300px; height:60px;"> <b>Send</b></button>
        </form>
    </div>
</center>

<?php
$com = new Comment();
$Comm = $com->displayComments($vidID);

if (empty($Comm)) {
    echo "<div class='container h-100'>
            <div class='row d-flex justify-content-center align-items-center h-100'>
                <div class='col-lg-12 col-xl-11'>
                    <div class='card text-danger' style='border-radius: 25px;'>
                        <div class='card-body p-md-5'>
                            <div class='row justify-content-center'>";
    echo "<div class='alert alert-danger text-center' role='alert'>No Comment Found</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
} else {
    foreach ($Comm as $row) {
        $usrID = $row['user_ID'];
        $acc = new User();
        $acc->GetProfileInfo($usrID);
        $fName = $acc->getFName();
        $lName = $acc->getLName();
        echo '<div class=channelCard>';
        echo '<div class="card" style="width: 18rem; margin-left:0% ;width:100%">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title" style="display: inline;">' . $fName . ' ' . $lName . '</h5>';
        echo '<br>';
        echo '<form>';
        echo '<label class="form-label fw-bolder text-danger me-5" for="form3Example2c">' . $row['comment'] . '</label>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}
?>

</div>

<?php require_once '../Models/footer.php' ?>