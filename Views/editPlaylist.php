<?php
require_once '../Models/header.php';
require_once '../Controller/DBController.php';
require_once '../Models/classes/Playlist.php';
?>

<?php
if(isset($_SESSION['UserId'])){


    $plyID = $_GET['plyliID'];
    $plylist = new Playlist();
    $pli = $plylist->getPlaylistInfo($plyID);
    $plyName = $pli[0]['title'];

    if (isset($_POST['deleteBtn'])) {
        $result = $plylist->deletePlaylist($plyID);
        if ($result == "Playlist Deleted Successfully") {
            echo '<script>
        alert("' . $result . '")
        </script>';
            echo "<script>setTimeout(\"location.href = './myChannel.php';\",500);</script>";
        } elseif ($result == "An error occurred while deleting playlist") {
            echo '<script>
            alert("' . $result . '")
            </script>';
            echo "<script>setTimeout(\"location.href = './myChannel.php';\",500);</script>";
        }
    }
?>

<section class="h-100 gradient-custom-2">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-9 col-xl-7">
                <div class="card p-5">
                    <h1 class="mb-5 text-danger">
                        <?php
                        echo $plyName;
                        ?>
                    </h1>
                    <form class="d-flex mb-5" method="post">
                        <button class="btn btn-outline-danger me-4" name="deleteBtn">Delete Playlist<i class="ms-2 fa-solid fa-trash"></i></button>
                        <a class="btn btn-outline-success" href="./addVideoToPlylist.php?plylisID=<?php echo $plyID; ?>">Add Video<i class="ms-2 fa-sharp fa-solid fa-plus"></i></a>
                    </form>
                    <?php
                    $result = $plylist->getPlaylistVideos($plyID);
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