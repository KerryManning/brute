<?php 
date_default_timezone_set('Europe/London');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // set variables and trim/ filter input
  $name = trim(filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING));
  $email = trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL));
  $message = trim(filter_input(INPUT_POST, "message", FILTER_SANITIZE_SPECIAL_CHARS));

  // form validation - check for empty fields
  if($name=="" OR $email=="" OR $message=="") {
    $error_message = "PLEASE COMPLETE ALL FIELDS";
  }
  // form validation - check spam honeypot
  if(!isset($error_message) && $_POST["address"]!="") {
    $error_message = "BAD FORM INPUT";
  }

  // load phpmailer
  require "vendor/autoload.php";
  $mail = new PHPMailerOAuth;

  // validate email
  if (!isset($error_message) && (!$mail->ValidateAddress($email))) {
    $error_message = "Invalid Email Address";
  }

  // build and send form
  if (!isset($error_message)) {
    $email_body = "";
    $email_body .= "Name: " . $name . "<br>" . "<br>";
    $email_body .= "Email Address: " . $email . "<br>" . "<br>";
    $email_body .= "Message: " . $message . "<br>" . "<br>";

    $mail->isSMTP();
    // $mail->SMTPDebug = 1;
    $mail->Debugoutput = 'html';
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->SMPTSecure = "tls";
    $mail->SMTPAuth = true;
    $mail->AuthType = 'XOAUTH2';
    $mail->oauthUserEmail = "you@gmail.com";
    $mail->oauthClientId = "*******";
    $mail->oauthClientSecret = "*******";
    $mail->oauthRefreshToken = "*******";

    $mail->setFrom("you@gmail.com");
    $mail->addAddress("another-person@mail.com");     // Add recipient
   
    $mail->isHTML(true);
    $mail->Subject = "Brute website contact from " . $name;
    $mail->Body    = $email_body;

    // check form email has been sent and redirect
    if($mail->send()) {
      header("location:index.php?status=thanks");
      exit;
    }
    // set error message if email isn't sent
    $error_message = "Message could not be sent. ";
    $error_message .= "Mailer Error: " . $mail->ErrorInfo;
  }
}
?>

<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play Brute</title>
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="css/foundation-icons/foundation-icons.css">
  </head>
  <body>

    <!-- navigation -->
    <!-- small screen nav -->
    <div class="title-bar" id="title-bar-brute" data-responsive-toggle="brute-menu" data-hide-for="medium">
      <a class="show-for-small-only logo-small" href="#"><img class="logo" src="img/brute-nav-logo.png" /></a>
      <button class="menu-icon" type="button" data-toggle></button>
      <div class="title-bar-title">Menu</div>
    </div>

    <!-- medium and larger screen nav -->
    <nav class="top-bar" id="brute-menu">
      <div class="logo-wrapper hide-for-small-only">
        <div class="logo">
          <img class="logo" src="img/brute-nav-logo.png" />
        </div>
      </div>
      <!-- left nav section -->
      <div class="top-bar-left">
        <ul class="vertical medium-horizontal menu">          
          <li><a href="index.php#intro">TRAILER</a></li>
          <li><a href="index.php#about">ABOUT</a></li>
        </ul>
      </div>
      <!-- right nav section -->
      <div class="top-bar-right">
        <ul class="vertical medium-horizontal menu">
          <li><a href="index.php#buy">BUY</a></li>
          <li><a href="index.php#contact">CONTACT</a></li>
        </ul>
      </div>
    </nav>

    <div class="overlay">
     <a href='https://twitter.com/_mgfm_'><i class='fi-social-twitter social'></i></a>
    </div>

    <div class="parallax-top">
      <div class="fullscreen-bg">
        <video loop muted autoplay poster="img/head-image.jpg" class="fullscreen-bg__video">
            <source src="video/BG.mp4" type="video/mp4">
            <p>Your browser doesn't support HTML5 video.
              <a href="video/BG.mp4">Download</a> the video instead.
            </p>
        </video>
      </div>
    </div>

    <div class="parallax-bottom">
      <!-- intro section -->
      <div class="intro" id="intro">
        <div class="row">
          <div class="small-12 columns">
            <h1>OUT NOW!</h1>
          </div>
        </div>
      </div>
      <!-- video -->
      <div class="row video" id="video">
        <div class="small-12 columns">
          <div class="flex-video">
            <iframe width="640" height="360" src="https://www.youtube.com/embed/7CK_-nUIqio?ecver=2"  frameborder="0" allowfullscreen></iframe>
          </div>
        </div>
      </div>
      <!-- buy -->
      <div class="row buy" id="buy">
        <div class="small-12 columns">
          <div>
            <h2>BUY NOW</h2>
            <hr>
            <div class="row stores">
              <div class="small-6 columns store-link">
                <a href="https://mgfm.itch.io/brute"><img src="img/store_icons/itchio.svg"/></a>
              </div>
              <div class="small-6 columns store-link">
                <a href="http://store.steampowered.com/app/451630/Brute/"><img src="img/store_icons/steam.svg"/></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- about -->
      <div class="row about" id="about">
        <div class="small-12 columns">
          <div>
            <h2>ABOUT</h2>
            <hr>
            <p>Brute is a challenging arcade game with a minimalist aesthetic. It's a game about planning, timing and discovery featuring an atmospheric soundtrack and cool sound effects!</p>
            <p>Game Features:</p>
            <ul>
              <li>50 hand crafted levels + 50 "Secret" levels</li>
              <li>Lots of things to shoot</li>
              <li>A weird menu</li>
              <li>Intuitive controls - all you need is a mouse!</li>
              <li>Lots of music!</li>
            </ul>
            <p>Who Am I?</p>
            <p>I'm Michael and I make games and music under the name <a href='https://twitter.com/_mgfm_'>MGFM</a>. I'm a sound designer and composer who has worked on both big and small games. On Brute I was aided enormously by Tyler Barber who provided graphic design help (logos, colour schemes and some sprites). Tyler also contributed music for the "secret" levels. It's great stuff, you should check out his album <a href="https://tylerbarber.bandcamp.com/releases">here</a>  - It's very, very good.</p>
            <p>Please enjoy the free soundtrack bundled in with the game. It's a nice collection of strange electronic soundscapes. If you just like music and don't care for the game, you can also purchase the soundtrack <a href="https://mgfm.itch.io/brute-ost">here</a>.</p>
          </div>
        </div>
      </div>
      <!-- img section -->
      <div class="row collapse imgs">
        <div class="medium-6 columns">
          <img src="img/screenshots/a.png" class="float-center"/>
        </div>
        <div class="medium-6 columns">
          <img src="img/screenshots/b.png" class="float-center"/>
        </div>
        <div class="medium-6 columns">
          <img src="img/screenshots/c.png" class="float-center"/>
        </div>
        <div class="medium-6 columns">
          <img src="img/screenshots/d.png" class="float-center"/>
        </div>
        <div class="medium-6 columns">
          <img src="img/screenshots/e.png" class="float-center"/>
        </div>
        <div class="medium-6 columns">
          <img src="img/screenshots/f.png" class="float-center"/>
        </div>
        <div class="medium-6 columns">
          <img src="img/screenshots/g.png" class="float-center"/>
        </div>
        <div class="medium-6 columns">
          <img src="img/screenshots/h.png" class="float-center"/>
        </div>
      </div>
      <!-- reviews section -->
      <div class="row reviews" id="review">
        <div class="small-12 columns">
          <h2>WORDS</h2>
          <hr>
        </div>
        <div class="medium-6 columns review">
          <p>"Brute was less about reflex than about planning, timing, and discovery. I don’t know whether that would change over the course of the larger game, but I’m keen to spend more time with it anyway for small details like the whirr of your engine or the bounce and pop of your bullets."</p>
          <p>- Graham Smith RPS</p>
        </div>
        <div class="medium-6 columns review">
          <p>"The little noise the ship makes when you speed up is my favourite little ship speeding noise ever."</p>
          <p>- Lexx87</p>
        </div>
      </div>
    </div>



  <div class="bottom">
    <div class="row">
      <div class="medium-6 columns">
        <img src="img/brute-smaller-logo.png" class="float-center" />
      </div>
      <?php
      // check if form has been sent - should thank you message content or form be shown?
      if(isset($_GET["status"]) && $_GET["status"]=="thanks") {
        echo "<div class='medium-6 columns'><p class='thanks'>Thanks for your email!</p></div>";
      }
      else { 
      ?>
      <div class="medium-6 columns">
        <div class="contact-form" id="contact">
          <h4>CONTACT</h4>
          <form method="post" action="index.php#contact">            
            <?php
              // show error message if set
              if(isset($error_message)) {
              echo "<p class='error-message'>" . $error_message . "<p>";
            }?>
            <label for="name">Name
              <input type="text" id="name" name="name" value="<?php if(isset($name)) { echo $name; } ?>"/>
            </label>
            <label for="email">Email
              <input type="text" id="email" name="email" value="<?php if(isset($email)) { echo $email; } ?>"/>
            </label>
            <label for="message">Message
              <textarea id="message" name="message" rows="5"><?php if(isset($message)) { echo htmlspecialchars($message); } ?></textarea>
            </label>
            <div style="display:none">
              <label for="address">Address
                <input type="text" id="address" name="address" />
                <p>Please leave this field blank.</p>
              </label>
            </div>
            <button id="submit">SUBMIT</button>
          </form>
        </div>
      </div>    
    </div>
  <?php
  // close out form display conditional
  } ?>
  </div>

    <script src="bower_components/jquery/dist/jquery.js"></script>
    <script src="bower_components/what-input/what-input.js"></script>
    <script src="bower_components/foundation-sites/dist/foundation.js"></script>
    <script src="js/app.js"></script>
  </body>
</html>
