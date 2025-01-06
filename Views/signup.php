<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up</title>
    <link rel="icon" href="../icons8-youtube-96.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css" integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>


<body>
    <section class="vh-100 bg-light">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-danger" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <?php
                                require_once '../Models/classes/User.php';
                                session_start();
                                if (isset($_POST['submit'])) {
                                    if (!empty($_POST['FirstName']) && !empty($_POST['LastName']) && !empty($_POST['email']) && !empty($_POST['password'])) {
                                        $new_PP_name = "Default-Profile-Pic.png";
                                        if(isset($_FILES['ProfilePic'])){
                                            $pp_Name = $_FILES['ProfilePic']['name'];
                                            $Tmp_ppName = $_FILES['ProfilePic']['tmp_name'];
                                            $pp_Error = $_FILES['ProfilePic']['error'];
                                            
                                            $pp_ext = strtolower(pathinfo($pp_Name, PATHINFO_EXTENSION));
    
                                            $allowedPP_ext = array('png', 'jpg', 'jpeg', 'gif');
    
                                            if (in_array($pp_ext, $allowedPP_ext)) {
                                                $uniq_ID = uniqid("ProfilePicture-", true);
                                                $new_PP_name = $uniq_ID . '.' . $pp_ext;
    
                                                $pp_upload_path = '../Views/uploads/profilePics/' . $new_PP_name;
                                                move_uploaded_file($Tmp_ppName, $pp_upload_path);
                                            }
                                        }
                                    
                                        $usr = new User();

                                        
                                        $result = $usr->register($_POST['FirstName'], $_POST['LastName'], $_POST['email'], $_POST['password'], $new_PP_name);
                                        if ($result == 'User already exists. Try again') {
                                            echo "<div class='alert alert-danger text-center' role='alert'>$result</div>";
                                            echo "<script>setTimeout(\"location.href = 'signup.php';\",1000);</script>";
                                        } elseif ($result == 'Error') {
                                            echo "<div class='alert alert-danger text-center' role='alert'>$result</div>";
                                            echo "<script>setTimeout(\"location.href = 'signup.php';\",1000);</script>";
                                        } else {
                                            echo "<div class='alert alert-success text-center' role='alert'>$result</div>";
                                            echo "<script>setTimeout(\"location.href = 'login.php';\",1000);</script>";
                                        }
                                    }
                                }

                                ?>
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>
                                    <form class="mx-1 mx-md-4" method="post" autocomplete="off" enctype="multipart/form-data">

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="text" id="form3Example1c" class="form-control" name="FirstName" required>
                                                <label class="form-label" for="form3Example1c">First Name</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="text" id="form3Example2c" class="form-control" name="LastName" required>
                                                <label class="form-label" for="form3Example2c">Last Name</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="email" id="form3Example3c" class="form-control" name="email" required>
                                                <label class="form-label" for="form3Example3c">Your Email</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="password" id="form3Example4c" class="form-control" name="password" required>
                                                <label class="form-label" for="form3Example4c">Password</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label for="formFile" class="form-label fw-bolder text-danger">Choose Profile Picture</label>
                                                <input class="form-control form-control-lg" id="formFile" type="file" name="ProfilePic">
                                            </div>
                                        </div>
                                        <div class="form-check d-flex justify-content-center mb-5">
                                            <span class="text-black">Already Have an account?<a href="login.php" class="link-danger">Login</a></span>
                                        </div>

                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <input type="submit" value="Sign In" class="btn btn-outline-danger btn-lg" name="submit">
                                        </div>

                                        <div class="form-check d-flex justify-content-center mb-5">
                                            <a href="./index.php" class="link-danger">Continue Browsing</a>
                                        </div>

                                    </form>

                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                    <img src="../Views/assets/images/image1.jpeg" class="img-fluid">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>