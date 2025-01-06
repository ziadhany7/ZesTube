<?php require_once '../Models/header.php' ?>
<?php require_once '../Models/classes/Playlist.php' ?>
<?php require_once '../Models/classes/Channel.php' ?>
<?php require_once '../Models/classes/User.php' ?>
<?php require_once '../Models/classes/Video.php' ?>

<?php
$usrID = $_SESSION['UserId'];
$plyID = $_GET['plylisID'];

$channel = new Channel();
$video = new Video();

$channel->GetChannelInfoUsrID($usrID);

$chanID = $channel->getChannelID();

$channelVideos = $video->getAllVideos($chanID);

if (isset($_POST['addVideo'])) {
    $vid_id = $_POST['vid'];
    if (!$video->videoInPlylist($plyID, $vid_id)) {
        $result = $video->addVideoToPlyList($plyID, $vid_id);
        echo '<script>
            alert("' . $result . '")
            </script>';
        echo "<script>setTimeout(\"location.href = './myChannel.php';\",500);</script>";
    } else {
        echo '<script>
        alert("Video is already in this playlist try another one")
        </script>';
    }
}

?>
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

                                    ?>
                                    <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                        <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Choose Video</p>
                                        <form class="mx-1 mx-md-4" method="post" autocomplete="off" enctype="multipart/form-data">
                                            <select class="form-select" aria-label="Default select example" id="formSelector" name="vid">
                                                <?php
                                                foreach ($channelVideos as $row) {
                                                ?>
                                                    <option value="<?php echo $row['video_ID']; ?>"><?php echo $row['videoTitle']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>

                                            <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4 mt-5">
                                                <input type="submit" value="Add Video" class="btn btn-outline-danger btn-lg" name="addVideo">
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
<?php require_once '../Models/footer.php' ?>