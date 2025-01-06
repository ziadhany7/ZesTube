<?php require_once '../Models/header.php' ?>
<style>
  .colorBlack {
    color: black;
  }
</style>
<?php
if(isset($_SESSION['UserId'])){

require_once '../Models/classes/User.php';
$id = $_SESSION['UserId'];
$acc = new User();
$acc->GetProfileInfo($id);
$fName = $acc->getFName();
$lName = $acc->getLName();
$email = $acc->getEmail();
$password = $acc->getPassword();

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
                  <?php
                  if (isset($_POST['saveInfo'])) {
                    if (!empty($_POST['fName']) && !empty($_POST['lName']) && !empty($_POST['email']) && !empty($_POST['password'])) {

                      $fName = $_POST['fName'];
                      $lName = $_POST['lName'];
                      $email = $_POST['email'];
                      $password = $_POST['password'];
                      $new_PP_name = "Default-Profile-Pic.png";
                      if (isset($_FILES['ProfilePic'])) {
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

                      $result = $acc->EditProfileInfo($id, $fName, $lName, $email, $password, $new_PP_name);
                      if ($result == "Profile updated successfully. Redirecting...") {
                        echo "<div class='alert alert-success text-center' role='alert'>$result</div>";
                        echo "<script>setTimeout(\"location.href = './profile.php';\",1000);</script>";
                      } else {
                        echo "<div class='alert alert-danger text-center' role='alert'>$result</div>";
                      }
                    }
                  }

                  ?>
                  <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4 text-danger">Edit Profile</p>
                    <form class="mx-1 mx-md-4" method="post" autocomplete="off" enctype="multipart/form-data">
                      <div class="d-flex flex-row align-items-center mb-4">
                        <div class="form-outline flex-fill mb-0">
                          <label class="form-label fw-bolder text-danger" for="form3Example2c">Frist Name</label>
                          <input type="text" id="form3Example2c" class="form-control" name="fName" value="<?php echo $fName; ?>">
                        </div>
                      </div>
                      <div class="d-flex flex-row align-items-center mb-4">
                        <div class="form-outline flex-fill mb-0">
                          <label class="form-label fw-bolder text-danger" for="form3Example2c">Last Name</label>
                          <input type="text" id="form3Example2c" class="form-control" name="lName" value="<?php echo $lName; ?>">
                        </div>
                      </div>
                      <div class="d-flex flex-row align-items-center mb-4">
                        <div class="form-outline flex-fill mb-0">
                          <label class="form-label fw-bolder text-danger" for="form3Example2c">Email</label>
                          <input type="text" id="form3Example2c" class="form-control" name="email" value="<?php echo $email; ?>">
                        </div>
                      </div>

                      <div class="d-flex flex-row align-items-center mb-4">
                        <div class="form-outline flex-fill mb-0">
                          <label class="form-label fw-bolder text-danger" for="form3Example3c">Password</label>
                          <input type="text" id="form3Example3c" class="form-control" name="password" value="<?php echo $password; ?>">
                        </div>
                      </div>
                      <div class="d-flex flex-row align-items-center mb-4">
                        <div class="form-outline flex-fill mb-0">
                          <label for="formFile" class="form-label fw-bolder text-danger">Profile Picture</label>
                          <input class="form-control form-control-lg" id="formFile" type="file" name="ProfilePic">
                        </div>
                      </div>
                      <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4 ">
                        <input type="submit" value="Save" class="btn btn-outline-danger btn-lg" name="saveInfo">
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
<?php require_once '../Models/footer.php' ?>