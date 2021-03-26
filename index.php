<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://fonts.googleapis.com/css?family=Lobster|Open+Sans:300,400,700" rel="stylesheet">
  <link rel="stylesheet" href="./bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  <link rel="stylesheet" href="./style.css">
  <title>Academic Conference Search</title>
</head>
<body>
  <div id="guide-template">
    <div id="intro-container">
      <!-- Title of page -->
      <h1>Academic Conference Search</h1>
      <p class="motto">You can search conference by name here.</p>
      <p style="color: white; font-weight: lighter">The number of Page View:
        <!-- To count number of viewer that view this page -->
        <span class="id">
          <?php
            if(isset($_SESSION['views']))
              $_SESSION['views'] = $_SESSION['views']+1;
            else
              $_SESSION['views']=1;
            echo $_SESSION['views'];
            $config['sess_expire_on_close'] = TRUE;
          ?>
        </span>
      </p>
    </div>
    <div id="navbar" style="text-align:center">
      <!-- Box search for user input keyword that they want to search -->
      <div class="search set-center">
        <i class="fas fa-search" aria-hidden="true"></i>
        <input type="textbox" id="txtconfname" placeholder="Search for conferences...">
        <span class="spanbtn"><input type="Submit" id="btnsearch" value="Search"></span>
      </div>
      <!-- Tab bar below search box. User can choose the type of conference that they want to show -->
      <ul class="tabs">
        <li><a href="#" data-href="#list_des" class="tab-link active"><i class="fab fa-google fa-lg"></i><span class="d-none d-lg-block"><span>Description</span></span></a></li>
        <li><a href="#" data-href="#list_video" class="tab-link"><i class="fab fa-youtube fa-lg"></i><span class="d-none d-lg-block"><span>Video</span></span></a></li>
        <li><a href="#" data-href="#list_twitter" class="tab-link"><i class="fab fa-twitter fa-lg"></i><span class="d-none d-lg-block"><span>Twitter</span></span></a></li>
      </ul>
    </div>
  </div>
    <div class="container">
      <!-- Show description result -->
      <div id="list_des" class="list active row"></div>
      <!-- Show videos result -->
      <div id="list_video" class="list row"></div>
      <!-- Show twitter result -->
      <div id="list_twitter" class="list row"></div>
    </div>
  </div>
  <script src="./jquery-3.3.1.min.js"></script>
  <script src="./search.js"></script>
  <script>
    var header = $("#guide-template");
    // scroll to hide title and show only search box and tab bar
    $(window).scroll(function(){
      var scroll = $(window).scrollTop();
      if(scroll >= 190){
        header.addClass("fixed");
      }else{
        header.removeClass("fixed");
      }
    })
    // controll the tab bar in order to let user choose type viewing
    $('.tab-link').on('click',function(ele){
      var active_tab = $(this).attr('data-href')
      $('.list').each(function(){
        $(this).removeClass('active')
      })
      $(active_tab).addClass('active')

      $('.tab-link').each(function(){
        $(this).removeClass('active')
      })
      $(this).addClass('active')
    })
  </script>
</body>
</html>