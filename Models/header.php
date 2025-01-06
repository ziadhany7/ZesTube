<?php
require_once '../Models/usedFunctions.php';
session_start();
if (isset($_SESSION['UserId'])) {
    $usrID = $_SESSION['UserId'];
    if (isset($_POST['LogOutBtn'])) {
        echo "<script>setTimeout(\"location.href = './index.php';\",500);</script>";
        session_destroy();
    }
} else {
    $usrID = 'guest';
    if (isset($_POST['LogInBtn'])) {
        echo "<script>setTimeout(\"location.href = './login.php';\",500);</script>";
    }
    if (isset($_POST['SignInBtn'])) {
        echo "<script>setTimeout(\"location.href = './signup.php';\",500);</script>";
    }
}

if(isset($_POST['searchBtn'])){
    if(!empty($_POST['searchKey'])){
        $url = $_POST['searchKey'];
        $whatToS = $_POST['searchFor'];
        header("Location:./searchResults.php?searchKey=".$url."&searchFor=".$whatToS);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ZesTube</title>
    <link rel="icon" href="../icons8-youtube-96.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css" integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-light">

    <!-- Header -->
    <div class="navbar navbar-dark bg-dark fixed-top" style="height: 6rem;">
        <div class="container-fluid">
            <a class="navbar-brand text-light fw-bolder" href="./index.php">
                Zes<span class="text-danger">Tube</span>
            </a>
            <div class="container-fluid" style="width: fit-content;">
                <form class="d-flex" role="search" method="post">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" style="width: 300px;" name="searchKey">
                    <select name="searchFor">
                        <option value="video">Search For Video</option>
                        <option value="channel">Search For Channel</option>
                    </select>
                    <div class="ms-3">

                    </div>
                    <button class="btn btn-outline-danger" name="searchBtn"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Menu</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./index.php"><i class="fa-solid fa-house me-2"></i>Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./trending.php"><i class="fa-solid fa-fire me-2"></i>Trending</a>
                        </li>
                        <?php
                        if ($usrID != 'guest') {
                        ?>
                            <li class="nav-item">
                                <a class="nav-link" href="./watchLater.php"><i class="fa-regular fa-clock me-2"></i>Watch Later</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./uploadVideo.php"><i class="fa-solid fa-arrow-up-from-bracket me-2"></i>Upload Video</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./subscribtions.php"><i class="fa-sharp fa-solid fa-tv me-2"></i>Subscriptions</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./likedvideos.php"><i class="fa-solid fa-thumbs-up me-2"></i>Liked Videos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./myChannel.php"><i class="fa-regular fa-user me-2"></i>My Channel</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./notifications.php"><i class="fa-regular fa-bell me-2"></i>Notifications</i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./profile.php"><i class="fa-regular fa-user me-2"></i>Profile</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Other Options
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark">
                                    <li><a class="dropdown-item" href="../Views/settings.php"><i class="fa-solid fa-gear me-2"></i>Settings</a></li>
                                </ul>
                            </li>

                            <li class="nav-item align-self-center mt-3">
                                <form method="post">
                                    <input type="submit" value="Log Out" class="btn btn-outline-danger btn-lg" name="LogOutBtn">
                                </form>
                            </li>
                        <?php
                        } else {
                        ?>
                            <li class="nav-item align-self-center">
                                <form method="post">
                                    <input type="submit" value="Log In" class="btn btn-outline-danger btn-lg" name="LogInBtn">
                                    <input type="submit" value="Register" class="btn btn-outline-danger btn-lg" name="SignInBtn">
                                </form>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div style="height: 5rem;">

    </div>