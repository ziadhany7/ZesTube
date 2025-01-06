<?php require_once '../Models/header.php' ?>

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
                                        require_once '../Controller/DBController.php';
                                        if(isset($_POST['sendRep'])){
                                            if(isset($_GET['vidID'])){
                                                $video_ID = $_GET['vidID'];
                                                $reportReason = $_POST['reportReason'];
                                                $reporterName = $_POST['yourName'];
                                                $db = new DBController();
                                                $db->startConnection();
                                                $qry = "INSERT INTO feedback (report, reporterName, reportedVideo_ID) VALUES ('$reportReason','$reporterName','$video_ID')";
                                                $db->insert($qry);
                                                $db->closeConnection();
                                                echo "<div class='alert alert-success text-center' role='alert'>Video Reported and is being reviewed by admin</div>";
                                                echo "<script>setTimeout(\"location.href = './index.php';\",1500);</script>";
                                            }
                                        }
                                    
                                    ?>
                                    <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                        <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4 text-danger">Report Video</p>
                                        <form class="mx-1 mx-md-4" method="post" autocomplete="off" enctype="multipart/form-data">
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <div class="form-outline flex-fill mb-0">
                                                    <label class="form-label fw-bolder text-danger" for="form3Example2c">Reason for report</label>
                                                    <input type="text" id="form3Example2c" class="form-control" name="reportReason">
                                                </div>
                                            </div>
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <div class="form-outline flex-fill mb-0">
                                                    <label class="form-label fw-bolder text-danger" for="form3Example2c">Your name</label>
                                                    <input type="text" id="form3Example2c" class="form-control" name="yourName">
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4 ">
                                                <input type="submit" value="Send" class="btn btn-outline-danger btn-lg" name="sendRep">
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