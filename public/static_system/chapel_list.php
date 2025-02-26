<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Template Mo">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <title>Education - List of Meetings</title>
    <link href="public/static_system/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/static_system/assets/css/fontawesome.css">
    <link rel="stylesheet" href="public/static_system/assets/css/templatemo-edu-meeting.css">
    <link rel="stylesheet" href="public/static_system/assets/css/owl.css">
    <link rel="stylesheet" href="public/static_system/assets/css/lightbox.css">

  </head>

<body>

   <style>
    .heading-page{
      padding-top: 120px !important;
  background-image: linear-gradient(to right, rgba(0, 0, 0, .7), rgba(0, 0, 0, .7)), url('GDRIVE/background-image.jpg') !important;

  
    }

    .our-facts{
}
    </style>

  <!-- Sub Header -->
  <div class="sub-header">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-sm-8">
         
        </div>
        <div class="col-lg-4 col-sm-4">
          <div class="right-icons">
            <ul>
              <li><a href="#"><i class="fa fa-facebook"></i></a></li>
             
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky">
      <div class="container">
          <div class="row">
              <div class="col-12">
                  <nav class="main-nav">
                      <!-- ***** Logo Start ***** -->
                      <a href="static" class="logo">
                          <?php $site = query("select * from site_options");
                          $site = $site[0];
                          echo($site["site_title"]);
                          ?>
                      </a>
                      <!-- ***** Logo End ***** -->
                      <!-- ***** Menu Start ***** -->
                      <ul class="nav">
                          <li><a href="static">Home</a></li>
                      </ul>        
                      <a class='menu-trigger'>
                          <span>Menu</span>
                      </a>
                      <!-- ***** Menu End ***** -->
                  </nav>
              </div>
          </div>
      </div>
  </header>
<?php 
  if(isset($_GET["branch"]))
  $chapel = query("select * from chapel where branch = ?", $_GET["branch"]);
else
$chapel = query("select * from chapel");
?>
  <section class="heading-page header-text" id="top">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h2>Chapels</h2>
        </div>
      </div>
      <a style="font-size: 13px;
    color: #fff;
    background-color: #a12c2f;
    padding: 12px 30px;
    display: inline-block;
    border-radius: 22px;
    font-weight: 500;
    text-transform: uppercase;
    transition: all .3s;
    border: none;
    outline: none;" class="button" href="static_chapel_list">All</a>
  <?php $branch = query("select * from branch"); ?>
      <?php foreach($branch as $row): ?>
  <a style="font-size: 13px;
    color: #fff;
    background-color: #a12c2f;
    padding: 12px 30px;
    display: inline-block;
    border-radius: 22px;
    font-weight: 500;
    text-transform: uppercase;
    transition: all .3s;
    border: none;
    outline: none;" class="button" href="static_chapel_list?branch=<?php echo($row["branch"]); ?>"><?php echo($row["branch"]); ?></a>
<?php endforeach; ?>

    </div>
  </section>

  <section class="meetings-page" id="meetings">
    <div class="container">
      <div class="row">
          <?php 
          foreach($chapel as $c): 
          $chapel_image = query("select * from chapel_image where chapel_id = ? limit 1", $c["chapel_id"]);
          ?>
            <div class="col-lg-3">
            <div class="our-courses">
            <a href="static_chapel_details?id=<?php echo($c["chapel_id"]); ?>">
            <div class="item" style="padding-top: 10px; padding-bottom:10px;">
            <?php if(!isset($chapel_image[0]["chapel_image"])): ?>
              <img width="300" height="250" src="resources/chapels/default_chapel.jpg" alt="Course One" style="border: 5px solid #fff;">
            <?php else: ?>
              <img width="300" height="250" src="<?php echo($chapel_image[0]["chapel_image"]); ?>" alt="Course One" style="border: 5px solid #fff;">
            <?php endif; ?>
              
              <div class="down-content">
                <h4><?php echo($c["chapel_name"]); ?></h4>
                <div class="info">
                  <div class="row">
                    <div class="col-12">
                       <span class="text-center">P <?php echo(to_peso($c["price_amount"])); ?></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </a>
            </div>
            </div>
          <?php endforeach; ?>
      </div>
    </div>
    <div class="footer">
      <p>Copyright © <?php echo(date("Y")); ?> STA TERESA FUNERAL HOMES INC.
    </div>
  </section>


  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
    <script src="public/static_system/vendor/jquery/jquery.min.js"></script>
    <script src="public/static_system/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="public/static_system/assets/js/isotope.min.js"></script>
    <script src="public/static_system/assets/js/owl-carousel.js"></script>
    <script src="public/static_system/assets/js/lightbox.js"></script>
    <script src="public/static_system/assets/js/tabs.js"></script>
    <script src="public/static_system/assets/js/isotope.js"></script>
    <script src="public/static_system/assets/js/video.js"></script>
    <script src="public/static_system/assets/js/slick-slider.js"></script>
    <script src="public/static_system/assets/js/custom.js"></script>
    <script>
        //according to loftblog tut
        $('.nav li:first').addClass('active');

        var showSection = function showSection(section, isAnimate) {
          var
          direction = section.replace(/#/, ''),
          reqSection = $('.section').filter('[data-section="' + direction + '"]'),
          reqSectionPos = reqSection.offset().top - 0;

          if (isAnimate) {
            $('body, html').animate({
              scrollTop: reqSectionPos },
            800);
          } else {
            $('body, html').scrollTop(reqSectionPos);
          }

        };

        var checkSection = function checkSection() {
          $('.section').each(function () {
            var
            $this = $(this),
            topEdge = $this.offset().top - 80,
            bottomEdge = topEdge + $this.height(),
            wScroll = $(window).scrollTop();
            if (topEdge < wScroll && bottomEdge > wScroll) {
              var
              currentId = $this.data('section'),
              reqLink = $('a').filter('[href*=\\#' + currentId + ']');
              reqLink.closest('li').addClass('active').
              siblings().removeClass('active');
            }
          });
        };

        $('.main-menu, .responsive-menu, .scroll-to-section').on('click', 'a', function (e) {
          e.preventDefault();
          showSection($(this).attr('href'), true);
        });

        $(window).scroll(function () {
          checkSection();
        });
    </script>
</body>


  </body>

</html>
