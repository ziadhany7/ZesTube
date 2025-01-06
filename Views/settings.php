<?php require_once '../Models/header.php' ?>
<?php
require_once '../Models/classes/User.php';



// Check if the delete button was clicked
if(isset($_SESSION['UserId'])){


$usrid = $_SESSION['UserId'];
if (isset($_POST['submit'])) {
    $usr = new User();
    $result = $usr->DeleteProfile($usrID);
    session_destroy();
    echo '<script>
        alert("' . $result . '")
        </script>';
    echo "<script>setTimeout(\"location.href = './index.php';\",500);</script>";
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
                                    <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                        <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Delete Profile</p>
                                        <form class="mx-1 mx-md-4" method="post" autocomplete="off" enctype="multipart/form-data">

                                            <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                                <input type="submit" value="Delete" class="btn btn-outline-danger btn-lg" name="submit">
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
<?php require_once '../Models/footer.php'; ?>