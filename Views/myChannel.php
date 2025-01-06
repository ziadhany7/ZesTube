<?php require_once '../Models/header.php'; ?>

<?php
require_once '../Models/classes/Channel.php';
require_once '../Models/classes/User.php';
require_once '../Models/classes/Playlist.php';

if(isset($_SESSION['UserId'])){


$usrId = $_SESSION['UserId'];
$channel = new Channel();
$usr = new User();

$usr->GetProfileInfo($usrId);
$usrPP  = $usr->getProfilePic();

if ($channel->GetChannelInfoUsrID($usrId)) {
  $channName = $channel->getChannelName();
  $channID = $channel->getChannelID();
  $channSubs = $channel->getNumberOfSubscribers($channID);
  $channVideos = $channel->getNumOfVideos($channID);
  $creationDate = $channel->getDateCreated();
  $totalViews = $channel->getTotalViews();
?>

  <section class="h-100 gradient-custom-2">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-lg-9 col-xl-7">
          <div class="card">
            <div class="rounded-top text-white d-flex flex-row bg-dark" style="height:200px;">
              <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px;">
                <div class="mb-5">
                  <!-- Blank -->
                </div>
                <img src="../Views/uploads/profilePics/<?php echo $usrPP; ?>" alt="Generic placeholder image" class="img-fluid img-thumbnail mt-4 mb-2" style="width: 150px; z-index: 1">
                <a href="./editChannelName.php" class="btn btn-outline-danger" data-mdb-ripple-color="dark" style="z-index: 1;">
                  Edit Channel
                </a>
              </div>
              <div class="ms-3" style="margin-top: 130px;">
                <h5><?php echo $channName; ?></h5>
              </div>
            </div>
            <div class="p-4 text-black" style="background-color: #f8f9fa;">
              <div class="d-flex justify-content-end text-center py-1">
                <div class="me-2">
                  <p class="mb-1 h5"><?php echo $channVideos; ?></p>
                  <p class="small text-muted mb-0">Videos</p>
                </div>
                <div class="me-2">
                  <p class="mb-1 h5"><?php echo $totalViews; ?></p>
                  <p class="small text-muted mb-0">Total Views</p>
                </div>
                <div class="me-2">
                  <p class="mb-1 h5"><?php echo $channSubs; ?></p>
                  <p class="small text-muted mb-0">Subscribers</p>
                </div>
                <div class="me-2">
                  <p class="mb-1 h5"><?php echo $creationDate; ?></p>
                  <p class="small text-muted mb-0">Date Created</p>
                </div>
              </div>
            </div>
            <div class="card-body p-4 text-black">
              <div class="mb-5 mt-5">
                <p class="lead fw-normal mb-1">PlayLists</p>
                <center>
                  <div class="bg-danger p-3 mb-4 rounded" style="width:fit-content">
                    <a href="./createPlaylist.php" class="text-light fw-bolder" style="text-decoration: none;">Create Playlist</a>
                  </div>
                </center>
                <div class="p-4" style="background-color: #f8f9fa;">
                  <?php
                  $plylist = new Playlist();
                  $playlistsNames = $plylist->getPlayListsNames($channID);

                  foreach ($playlistsNames as $row) {
                    echo '
                    <a href="./editPlaylist.php?plyliID=' . $row['playlist_ID'] . '" class="text-light fw-bolder" style="text-decoration: none;">
                    <div class="bg-danger p-2 mb-3 align-text-center rounded" style="width:300px">
                    ' . $row['title'] . '
                  </div>
                  </a>
                    ';
                  }
                  ?>
                </div>
              </div>
              <div class="d-flex justify-content-between align-items-center mb-4">
                <p class="lead fw-normal mb-0">Videos</p>
                <a class="btn btn-outline-success" href="./uploadVideo.php">Upload Video<i class="ms-2 fa-sharp fa-solid fa-plus"></i></a>
              </div>
              <?php
              require_once '../Controller/DBController.php';
              $db  = new DBController();
              $db->startConnection();
              $sql = "SELECT * FROM video WHERE channel_ID = '$channID' order by dateuploded DESC";
              $result = $db->select($sql);
              if (empty($result)) {
                echo "<div class='container h-100'>
            <div class='row d-flex justify-content-center align-items-center h-100'>
                <div class='col-lg-12 col-xl-11'>
                    <div class='card text-danger' style='border-radius: 25px;'>
                        <div class='card-body p-md-5'>
                            <div class='row justify-content-center'>";
                echo "<div class='alert alert-danger text-center' role='alert'>You don't have videos yet</div>";
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
                  echo '<p class="card-text">' . timeElapsedSinceNow($row['dateuploded']) . '</p>';
                  echo '<h6 class="card-title">Views</h6>';
                  echo '<p class="card-text">' . $row['numOfViews'] . '</p>';
                  echo '<a class="btn btn-outline-danger mt-5" href="./deleteVideo.php?vidID=' . $row['video_ID'] . '">Delete Video<i class="ms-2 fa-solid fa-trash"></i></a>';
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
    </div>
  </section>

<?php
} else {
?>
  <div class="mb-5 mt-5">
    <br>
    <br>
  </div>
  <div class='container h-100 align-self-center mt-5'>
    <div class='row d-flex justify-content-center align-items-center h-100'>
      <div class='col-lg-12 col-xl-11'>
        <div class='card text-danger' style='border-radius: 25px;'>
          <div class='card-body p-md-5'>
            <div class='row justify-content-center'>
              <div class='text-center'>
                <h1>
                  You Don't Have A Channel
                </h1>
                <center>
                  <div class="bg-danger p-3 align-self-center" style="width:fit-content">
                    <a href="./createChannel.php" class="text-light fw-bolder" style="text-decoration: none;">Create Channel</a>
                  </div>
                </center>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php
}
?>
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