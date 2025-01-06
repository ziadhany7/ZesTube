<?php
require_once '../Models/header.php';
require_once '../Models/classes/Video.php';
require_once '../Models/classes/User.php';
require_once '../Models/classes/Channel.php';
require_once '../Controller/DBController.php';
?>

<div class="mt-xxl-5" style="width: 98vw;">
    <div class="row row-cols-1 row-cols-md-3 g-3 p-5">

        <?php
        $db  = new DBController();
        $db->startConnection();
        $searchValue = $_GET['searchKey'];
        $whereToSearch = $_GET['searchFor'];
        $bits = explode(' ', $searchValue);
        $sql = '';
        if ($whereToSearch == "video") {
            $sql = "SELECT * FROM video WHERE videoDescrip LIKE '%" . implode("%' OR videoDescrip LIKE '%", $bits) . "%'";
            $result = $db->select($sql);
            if (empty($result)) {
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
                foreach ($result as $row) {
                    echo '<div class="col">';
                    echo '<div class="card">';
                    echo '<form method = "get">';
                    echo '<a href="watchVideo.php?url=' . $row['video'] . '" style="text-decoration: none; color: black;">';
                    echo '<img src="uploads/thumbnails/' . $row['videoThumb'] . '"' . 'class="card-img-top" style="width: 100%; height:400px;">';
                    echo '<div class="card-body">';
                    echo '<h4 class="card-title text-danger">' . $row['videoTitle'] . '</h4>';
                    echo '<h6 class="card-title">Date Uploaded</h6>';
                    echo '<p class="card-text">' . timeElapsedSinceNow($row['dateuploded']) . '</p>';
                    echo '<h6 class="card-title">Views</h6>';
                    echo '<p class="card-text">' . $row['numOfViews'] . '</p>';
                    echo '</div>';
                    echo '<div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">';
                    echo '</div>';
                    echo '</a>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                }
            }
        } else {
            $sql = "SELECT * FROM channel WHERE channelName LIKE '%" . implode("%' OR channelName LIKE '%", $bits) . "%'";
            $result = $db->select($sql);
            if (empty($result)) {
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
                foreach ($result as $chann) {
                    $Chan = new Channel();
                    $channID = $chann['channel_ID'];
                    $chanUserID = $chann['user_ID'];
                    $channSubs = $Chan->getNumberOfSubscribers($channID);
                    $Usr = new User();
                    $Usr->GetProfileInfo($chanUserID);
                    $usrPP  = $Usr->getProfilePic();
                    echo '<div class="col mb-5">';
                    echo '<div class="card">';
                    echo '<form method = "get">';
                    echo '<a href="./visitChannel.php?channel_ID=' .$channID.'"'. 'style="text-decoration: none; color: black;"> ';
                    echo '<img src="./uploads/profilePics/' . $usrPP . '"' . 'class="card-img-top" style="width: 100%; height:400px;">';
                    echo '<div class="card-body">';
                    echo '<h4 class="card-title text-danger">' . $chann['channelName'] . '</h4>';
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
        }

        ?>
    </div>
</div>

<?php require_once '../Models/footer.php' ?>