<?php require_once '../Models/header.php' ?>
<?php require_once '../Models/classes/Video.php' ?>
<?php require_once '../Models/classes/Channel.php' ?>
<?php require_once '../Models/classes/Notification.php' ?>
<?php require_once '../Models/classes/Subscribe.php' ?>


<?php
require_once '../Models/classes/Channel.php';
require_once '../Models/classes/User.php';
require_once '../Models/classes/Playlist.php';
if(isset($_SESSION['UserId'])){


$usrId = $_SESSION['UserId'];
$channel = new Channel();
$usr = new User();

$usr->GetProfileInfo($usrId);
$usrPP  = $usr->getProfilePic();

if ($channel->GetChannelInfoUsrID($usrId)) {
    $channName = $channel->getChannelName();
    $channID = $channel->getChannelID();
    $channVideos = $channel->getNumOfVideos($channID);

?>
    <!-- Video Content -->
    <div class="mt-xxl-5" style="width: 98vw;">
        <div>
            <section class="vh-100 bg-light">
                <div class="container h-100">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-lg-12 col-xl-11">
                            <div class="card text-danger" style="border-radius: 25px;">
                                <div class="card-body p-md-5">
                                    <div class="row justify-content-center">
                                        <?php

                                        if (isset($_POST['uploadViBtn'])) {
                                            $usrID = $_SESSION['UserId'];

                                            if (isset($_FILES['VideoUrl']) && isset($_FILES['VideoThumb'])) {
                                                if (!empty($_POST['VideoTitle']) && !empty($_POST['VideoDesc'])) {
                                                    $VidTtile = $_POST['VideoTitle'];
                                                    $VidDesc = $_POST['VideoDesc'];

                                                    if ($_POST['playList'] == 'NULL') {
                                                        $playList = "NULL";
                                                    } else {
                                                        $playList = $_POST['playList'];
                                                    }

                                                    $vidName = $_FILES['VideoUrl']['name'];
                                                    $TmpVidName = $_FILES['VideoUrl']['tmp_name'];
                                                    $vidError = $_FILES['VideoUrl']['error'];

                                                    $thumbName = $_FILES['VideoThumb']['name'];
                                                    $TmpThumbName = $_FILES['VideoThumb']['tmp_name'];
                                                    $thumbError = $_FILES['VideoThumb']['error'];


                                                    if ($vidError === 0 && $thumbError === 0) {
                                                        $video_ext = strtolower(pathinfo($vidName, PATHINFO_EXTENSION));
                                                        $thumb_ext = strtolower(pathinfo($thumbName, PATHINFO_EXTENSION));

                                                        $allowedVid_ext = array('mp4', 'avi', 'mkv', 'webm', 'flv');
                                                        $allowedThumb_ext = array('png', 'jpg', 'jpeg', 'gif');

                                                        if (in_array($video_ext, $allowedVid_ext) && in_array($thumb_ext, $allowedThumb_ext)) {
                                                            $uniq_ID = uniqid("video-", true);
                                                            $new_video_name = $uniq_ID . '.' . $video_ext;
                                                            $new_thumb_name = $uniq_ID . '.' . $thumb_ext;

                                                            $video_upload_path = '../Views/uploads/videos/' . $new_video_name;
                                                            $thumb_upload_path = '../Views/uploads/thumbnails/' . $new_thumb_name;
                                                            move_uploaded_file($TmpVidName, $video_upload_path);
                                                            move_uploaded_file($TmpThumbName, $thumb_upload_path);

                                                            $upldVid = new Video();
                                                            $chann = new Channel();

                                                            $chann->GetChannelInfoUsrID($usrID);

                                                            $channId = $chann->getChannelID();

                                                            $result = $upldVid->uploadVideo($new_video_name, $channId, $VidTtile, $VidDesc, $new_thumb_name, $playList);

                                                            $subs = new Subscribe();
                                                            $allSubs = $subs->getSubs($channID); 
                                                            $notif = new Notification();
                                                            foreach($allSubs as $sub){
                                                                $notif->notify($usrId,$channName.' uploaded new video','upload',0,$sub['User_ID']);
                                                            }
                                                            if ($result == 'Video Uploaded Successfully') {
                                                                echo "<div class='alert alert-success text-center' role='alert'>$result</div>";
                                                                echo "<script>setTimeout(\"location.href = './index.php';\",1000);</script>";
                                                            } elseif ($result == 'An error occurred') {
                                                                echo "<div class='alert alert-danger text-center' role='alert'>$result</div>";
                                                                echo "<script>setTimeout(\"location.href = './index.php';\",1000);</script>";
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                        <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                            <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Video Upload</p>
                                            <form class="mx-1 mx-md-4" method="post" autocomplete="off" enctype="multipart/form-data">
                                                <div class="d-flex flex-row align-items-center mb-4">
                                                    <div class="form-outline flex-fill mb-0">
                                                        <label for="formFile" class="form-label fw-bolder text-danger">Video</label>
                                                        <input class="form-control form-control-lg" id="formFile" type="file" name="VideoUrl" required>
                                                    </div>
                                                </div>

                                                <div class="d-flex flex-row align-items-center mb-4">
                                                    <div class="form-outline flex-fill mb-0">
                                                        <label for="formFile" class="form-label fw-bolder text-danger">Thumbnail</label>
                                                        <input class="form-control form-control-lg" id="formFile" type="file" name="VideoThumb" required>
                                                    </div>
                                                </div>

                                                <div class="d-flex flex-row align-items-center mb-4">
                                                    <div class="form-outline flex-fill mb-0">
                                                        <label class="form-label fw-bolder text-danger" for="form3Example2c">Title</label>
                                                        <input type="text" id="form3Example2c" class="form-control" name="VideoTitle" required>
                                                    </div>
                                                </div>

                                                <div class="d-flex flex-row align-items-center mb-4">
                                                    <div class="form-outline flex-fill mb-0">
                                                        <label class="form-label fw-bolder text-danger" for="form3Example3c">Video Description</label>
                                                        <input type="text" id="form3Example3c" class="form-control" name="VideoDesc" required>
                                                    </div>
                                                </div>


                                                <div class="d-flex flex-row align-items-center mb-4">
                                                    <div class="form-outline flex-fill mb-0">
                                                        <label class="form-label fw-bolder text-danger" for="formSelector">Choose Playlist</label>
                                                        <select class="form-select" aria-label="Default select example" id="formSelector" name="playList">
                                                            <option selected value="NULL">None</option>
                                                            <?php
                                                            $plylist = new Playlist();
                                                            $playlistsNames = $plylist->getPlayListsNames($channID);
                                                            foreach ($playlistsNames as $row) {
                                                            ?>
                                                                <option value="<?php echo $row['playlist_ID']; ?>"><?php echo $row['title']; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                                    <input type="submit" value="Upload" class="btn btn-outline-danger btn-lg" name="uploadViBtn">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

<?php
} else {
?>
    <div class="mb-5 mt-5">
        <br>
        <br>
    </div>
    <div class='container h-100 align-self-center mt-5'>
        <div class='row d-flex justify-content-center align-items-center h-100'>
            <div class='col-lg-12 col-xl-11'>
                <div class='card text-danger' style='border-radius: 25px;'>
                    <div class='card-body p-md-5'>
                        <div class='row justify-content-center'>
                            <div class='text-center'>
                                <h1>
                                    You Don't Have A Channel
                                </h1>
                                <center>
                                    <div class="bg-danger p-3 align-self-center" style="width:fit-content">
                                        <a href="./createChannel.php" class="text-light fw-bolder" style="text-decoration: none;">Create Channel</a>
                                    </div>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>




<?php 
}
else{
    echo '<script>
    alert("Access denied");
    </script>';
    echo "<script>setTimeout(\"location.href = './index.php';\");</script>";
}
?>



<?php require_once '../Models/footer.php' ?>