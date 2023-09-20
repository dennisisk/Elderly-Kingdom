<html>
  <head>
    <link rel="stylesheet" href="css/aboutus.css">
    <title>About Us | Elderly Kingdom</title>
  </head>
  <body>
    <?php include("header.php"); 
      include("dependency.php"); ?>
    <div class="jumbotron text-center">
      <h2 class="intro">About Us</h1>
      <h3 class="intro">We are...</h2>
      <p class="intro">An non-profit organization specialized for elderly services.</p>
    </div>
    <div class="container-fluid text-center">
      <h2>What Do We Provide?</h2>
      <br>
      <div class="row">
        <div class="col-sm-4">
          <span class="glyphicon glyphicon-education logo-small"></span>
          <h4>Education</h4>
          <p>Educate public about aging	</p>
        </div>
        <div class="col-sm-4">
          <span class="glyphicon glyphicon-user logo-small"></span>
          <h4>Forum</h4>
          <p>Provide interactions to exchange information</p>
        </div>
        <div class="col-sm-4">
          <span class="glyphicon glyphicon-eye-open logo-small"></span>
          <h4>Caring</h4>
          <p>Caring services for elderlies in our center</p>
        </div>
      </div>
    </div>
    <div class="container-fluid text-center bg-grey">
      <div class="row">
        <div class="col-sm-4">
          <span class="glyphicon glyphicon-plus logo"></span> 
        </div>
        <div class="col-sm-8">
          <h2>Our Values</h2>
          <h4><strong>MISSION: </strong>Improve elderly's daily living</h4>
          <p><strong>VISION: </strong>Raise the public's awareness of aging issue</p>
        </div>
      </div>
    </div>
    <!-- carousel -->
    <h2 style="text-align:center">other's thoughts on us</h2>
    <div id="myCarousel" class="carousel slide text-center" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <h4>"This organization is so energetic! Helped me a lot on daily life"<br><span style="font-style:normal;">Mrs. Wong, Citizen in Hung Hom</span></h4>
        </div>
        <div class="item">
          <h4>"Let me know more about my grandma."<br><span style="font-style:normal;">Jon, Participant in our activities</span></h4>
        </div>
        <div class="item">
          <h4>"The resources provided are very useful and interesting."<br><span style="font-style:normal;">Charles, Researcher in CityU</span></h4>
        </div>
      </div>
    </div>
    <?php include("footer.php"); ?>
  </body>
</html>