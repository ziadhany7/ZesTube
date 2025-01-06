<?php require_once '../Models/header.php' ?>
<style>
  .colorBlack {
    color: black;
  }

  .input {
    border-top-style: hidden;
    border-right-style: hidden;
    border-left-style: hidden;
    border-bottom-style: hidden;
    background-color: while;
  }
</style>
<?php
require_once '../Models/classes/User.php';
if(isset($_SESSION['UserId'])){


$id = $_SESSION['UserId'];
$acc = new User();
$acc->GetProfileInfo($id);
$fName = $acc->getFName();
$lName = $acc->getLName();
$email = $acc->getEmail();
$password = $acc->getPassword();
$profileP = $acc->getProfilePic();
?>
<section class="vh-100" style="background-color: #f4f5f7;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-lg-6 mb-4 mb-lg-0">
        <div class="card mb-3" style="border-radius: .5rem;">
          <div class="row g-0">
            <div class="col-md-4 gradient-custom text-center text-white" style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
              <img src="../Views/uploads/profilePics/<?php echo $profileP; ?>" alt="Avatar" class="img-fluid my-5" style="width:80%;" />
              <h5 class="colorBlack"><?php echo $fName . " " . $lName; ?></h5>
              <div class="mb-5">
                <a href="editProfile.php" style="color:red; text-decoration:none;">Edit Info</a>
                <i class="fa-solid fa-pen-to-square"></i>
              </div>
            </div>
            <div class="col-md-8">
              <div class="card-body p-4">
                <h6>Information</h6>
                <hr class="mt-0 mb-4">
                <div class="row pt-1">
                  <div class="col-6 mb-3">
                    <h6>Frist name</h6>
                    <p><?php echo $fName; ?></p>
                  </div>
                  <div class="col-6 mb-3">
                    <h6>Last name</h6>
                    </p><?php echo $lName; ?></p>
                  </div>
                  <div class="col-6 mb-3">
                    <h6>Email</h6>
                    </p><?php echo $email; ?></p>
                  </div>
                </div>
                <hr class="mt-0 mb-4">
                <div class="row pt-1">
                </div>
              </div>
            </div>
          </div>
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
<?php require_once '../Models/footer.php' ?>