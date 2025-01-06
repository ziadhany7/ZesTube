<?php
require_once '../Models/header.php';
require_once '../Models/classes/Video.php';
require_once '../Models/classes/Like.php';
require_once '../Models/classes/Comment.php';
require_once '../Models/classes/Subscribe.php';
require_once '../Models/classes/User.php';
require_once '../Models/classes/Channel.php';
require_once '../Models/classes/Watchlater.php';
?>

<?PHP
if(isset($_SESSION['UserId'])){


$userid = $_SESSION['UserId'];
$Sub = new Subscribe();
$watchSubscribtions = $Sub->GetSubChann($userid);
?>

<section class="h-100 gradient-custom-2">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-9 col-xl-7">
                <div class="card p-5">
                    <h1>Subscribed Channels</h1>
                    <br><br>
                    <?php
                    if (empty($watchSubscribtions)) {
                        echo "<div class='container h-100'>
                        <div class='row d-flex justify-content-center align-items-center h-100'>
                        <div class='col-lg-12 col-xl-11'>
                        <div class='card text-danger' style='border-radius: 25px;'>
                        <div class='card-body p-md-5'>
                            <div class='row justify-content-center'>";
                        echo "<div class='alert alert-danger text-center' role='alert'>No results Found</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    } else {
                        foreach ($watchSubscribtions as $chann) {
                            $Chan = new Channel();
                            $Chan->GetChannelInfoChannID($chann['Channel_ID']);
                            $channID = $Chan->getChannelID();
                            $channName = $Chan->getChannelName();
                            $chanUserID = $Chan->getUserID();
                            $channSubs = $Chan->getNumberOfSubscribers($channID);
                            $Usr = new User();
                            $Usr->GetProfileInfo($chanUserID);
                            $usrPP  = $Usr->getProfilePic();
                            echo '<div class="col mb-5">';
                            echo '<div class="card">';
                            echo '<form method = "get">';
                            echo '<a href="./visitChannel.php?channel_ID=' .$channID.'"'. 'style="text-decoration: none; color: black;"> ';
                            echo '<img src="./uploads/profilePics/' . $usrPP . '"' . 'class="card-img-top" style="width: 100%; height:700px;">';
                            echo '<div class="card-body">';
                            echo '<h4 class="card-title text-danger">' . $channName . '</h4>';
                            echo '<h6 class="card-title"> subscribers </h6>';
                            echo '<p class="card-text">' . $channSubs . '</p>';
                            echo '</div>';
                            echo '<div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">';
                            echo '</div>';
                            echo '</a>';
                            echo '</form>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }

                    ?>
                </div>
            </div>
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