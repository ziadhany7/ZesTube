<?php require_once '../Models/header.php' ?>
<?php require_once '../Models/classes/Playlist.php' ?>
<?php require_once '../Models/classes/Channel.php'?>
<?php require_once '../Models/classes/User.php' ?>
<?php 
if(isset($_SESSION['UserId'])){

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

                                    if (isset($_POST['createPlaylist'])) {
                                        if (!empty($_POST['playlistName'])) {
                                            $plilName = $_POST['playlistName'];
                                            $usrId = $_SESSION['UserId'];
                                            $usr = new User();

                                            $usr->GetProfileInfo($usrId);
                        

                                            $chan = new Channel();
                                            $chan->GetChannelInfoUsrID($usrId);
                                            $channID = $chan->getChannelID();

                                            $plyli = new Playlist();
                                            $result = $plyli->createPlaylist($plilName,$channID);

                                            if ($result == "Playlist already exists") {
                                                echo "<div class='alert alert-danger text-center' role='alert'>$result</div>";
                                            } elseif ($result == "Playlist Created Successfully") {
                                                echo "<div class='alert alert-success text-center' role='alert'>$result</div>";
                                                echo "<script>setTimeout(\"location.href = './myChannel.php';\",1000);</script>";
                                            }
                                        }
                                    }

                                    ?>
                                    <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                        <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Create Playlist</p>
                                        <form class="mx-1 mx-md-4" method="post" autocomplete="off" enctype="multipart/form-data">
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <div class="form-outline flex-fill mb-0">
                                                    <label class="form-label fw-bolder text-danger" for="form3Example2c">Playlist Name</label>
                                                    <input type="text" id="form3Example2c" class="form-control" name="playlistName" required>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                                <input type="submit" value="Create" class="btn btn-outline-danger btn-lg" name="createPlaylist">
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
}
else{
    echo '<script>
    alert("Access denied");
    </script>';
    echo "<script>setTimeout(\"location.href = './index.php';\");</script>";
}
?>
<?php require_once '../Models/footer.php' ?>