<?php
include("config.php");
session_start();
if(!isset($_SESSION['login_user'])){
   header("Location:index.php");
}
$link = mysqli_connect("localhost", "lorasAdmin", "lorasATR2018", "atr");
//
if (!$link) {
  echo "Error: Unable to connect to MySQL." . PHP_EOL;
  echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
  echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
  exit;


}

// $sql = "SELECT * FROM trainers";
// $result = mysqli_query($link,$sql);
// $row = mysqli_fetch_array($result);

if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form

      $userLoggedIn = $_SESSION["login_user"];
      $date = date("Y-m-d H:i:s");
      $injury = mysqli_real_escape_string($link,$_POST['Injury_Select']);
      $injury_int = (int)$injury;

      $description = mysqli_real_escape_string($link,$_POST['Description']);

      $ATS = mysqli_real_escape_string($link,$_POST['AT_SAW']);
      $ATS_int = (int)$ATS;

      $userID_int = (int)$_SESSION['userID'];
      $userSport_int = (int)$_SESSION['userSport'];


      $sql = "INSERT INTO injury_report(studentID, Date,Description, ATS_ID, InjuryID, sportID)
VALUES ($userID_int,now(),'$description',$ATS_int,$injury_int,$userSport_int)";

// $sql = "INSERT INTO injury_report(studentID, Date,Description, ATS_ID, InjuryID, sportID)
// VALUES (2,now(),'test',1,9,2)";

if(mysqli_query($link, $sql))
{
  // remove all session variables
session_unset();

// destroy the session
session_destroy();
  header("location: /index.php");
}
else {
  echo "Error: " . $sql."".mysqli_error($link);
}

 }
       ?>
 <!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/main.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="js/jquery.repeatable.js"></script>
    <title>Injury Information</title>




  </head>
  <body style="background:#D1B888 !important">

    <div style="background:transparent !important" class ="jumbotron text-center">



<!--NEW BOOTSTRAP LAYOUT -->
<!---->
<!---->

  <section id="cover">
      <div id="cover-caption">
          <div id="container" class="container">
              <div class="row text-black">
                  <div class="col-sm-10 offset-sm-1 text-center">
                      <h1 class="display-3">Injury Info</h1>
                      <div class="info-form">
                          <form method="post"  class="form-inline justify-content-center">
                              <div class="form-group">
                                  <select class="form-control form-control-sm" id="Injury_Select" name="Injury_Select" required>
                                  <option value="" disabled selected>Select a Injury</option>
                                  <?php

                                  $sql = "SELECT * FROM injuries";
                                  $result = mysqli_query($link,$sql);
                                  //$row = mysqli_fetch_array($result);

                                  while ($row = mysqli_fetch_array($result)) {
                                      echo "<option value='" . $row['injuriesID'] . "'>" . $row['Name'] . "</option>";
                                  }

                                   ?>
                                </select>
                              </div>
                              <div class="form-group">
                                  <input type="text" class="form-control form-control-sm" name = "Description" placeholder="Description" required>
                              </div>
                              <div class="form-group">
                                  <select class="form-control form-control-sm" id="AT_SAW" name ="AT_SAW" required>
                                  <option value="" disabled selected>Athletic Trainer Saw</option>
                                  <?php

                                  $sql = "SELECT * FROM trainer";
                                  $result = mysqli_query($link,$sql);


                                  while ($row = mysqli_fetch_array($result)) {
                                      echo "<option value='" . $row['trainerID'] . "'>" . $row['FirstName'] . "</option>";
                                  }

                                   ?>
                                </select>
                              </div>
                              <button type="submit" class="btn btn-sm  ">Submit</button>
                          </form>
                      </div>
                      <br>
                  </div>
              </div>
          </div>
      </div>

        </div>
  </section>
  </body>
</html>
