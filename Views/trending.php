<?php require_once '../Models/header.php' ?>

<!-- Video Content -->
<div class="mt-xxl-5" style="width: 98vw;">
    <h1 style="margin-left:45%"><i>Trending</i></h1>
    <div class="row row-cols-1 row-cols-md-3 g-3 p-5">
        <br><br>
        <?php
        require_once '../Controller/DBController.php';
        $db  = new DBController();
        $db->startConnection();
        $sql = "SELECT * FROM video order by numOfViews DESC";
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
        ?>
    </div>
</div>

<?php require_once '../Models/footer.php' ?>