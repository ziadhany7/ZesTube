<?php
require_once '../Models/header.php';
require_once '../Controller/DBController.php';
require_once '../Models/classes/Playlist.php';

if(isset($_SESSION['UserId'])){


?>

<section class="h-100 gradient-custom-2">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-9 col-xl-7">
                <div class="card p-5">
                    <h1><?php
                        $plyID = $_GET['plyliID'];
                        $plylist = new Playlist();
                        $plylist = $plylist->getPlaylistInfo($plyID);
                        $plyName = $plylist[0]['title'];
                        echo $plyName;
                        ?></h1>
                    <?php
                    $db  = new DBController();
                    $db->startConnection();
                    $sql = "SELECT * FROM video WHERE playlist_ID = '$plyID' order by dateuploded DESC";
                    $result = $db->select($sql);
                    if (empty($result)) {
                        echo "<div class='container h-100'>
                                            <div class='row d-flex justify-content-center align-items-center h-100'>
                                            <div class='col-lg-12 col-xl-11'>
                                            <div class='card text-danger' style='border-radius: 25px;'>
                                            <div class='card-body p-md-5'>
                                            <div class='row justify-content-center'>";
                        echo "<div class='alert alert-danger text-center' role='alert'>This Playlist has no videos</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    } else {
                        foreach ($result as $row) {
                            echo '<div class="col mb-5">';
                            echo '<div class="card">';
                            echo '<form method = "get">';
                            echo '<a href="./watchVideo.php?url=' . $row['video'] . '" style="text-decoration: none; color: black;">';
                            echo '<img src="./uploads/thumbnails/' . $row['videoThumb'] . '"' . 'class="card-img-top" style="width: 100%; height:400px;">';
                            echo '<div class="card-body">';
                            echo '<h4 class="card-title text-danger">' . $row['videoTitle'] . '</h4>';
                            echo '<h6 class="card-title">Date Uploaded</h6>';
                            echo '<p class="card-text">' .timeElapsedSinceNow($row['dateuploded']). '</p>';
                            echo '<h6 class="card-title">Views</h6>';
                            echo '<p class="card-text">' .$row['numOfViews']. '</p>';
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