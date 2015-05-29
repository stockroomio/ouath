<?php
session_start();
//error_reporting(-1);
//ini_set('display_errors','On');
include('db.php'); //Database Connection.
include('number_to_word.php'); //number_to_word_library
if (!isset($_SESSION['github_data'])) {
// Redirection to application index page.
  header("location: index.php");
}
else
{

  $userdata=$_SESSION['github_data'];
// print_r($userdata);
  $email = $userdata->email;
  $fullName = $userdata->name;
  $company = $userdata->company;
  $blog = $userdata->blog;
  $location = $userdata->location;
  $github_id = $userdata->id;
  $github_username = $userdata->login;
  $profile_image = $userdata->avatar_url;
  $github_url = $userdata->url;
  $user_url = $userdata->html_url;
  $github_repo_url = $userdata->repos_url;
  $dirty_date = substr($userdata->created_at,0,10);
  $date = date("M jS, Y", strtotime($dirty_date));

  include('simple_html_dom.php');
  $html = file_get_html($user_url);
  $commit_count = explode(" ", $html->find("span[class=contrib-number]",0)->innertext)[0];
// $commit_count = explode(" ", $value['nodes'][1400]->_['4'])[0];

  $options  = array('http' => array( 'method'=>"GET",
   'header'=>"User-Agent: LiveAshish\r\n"));
  $context  = stream_context_create($options);
  $response = file_get_contents($github_repo_url.'?client_id=bc243b154a63b584b739&client_secret=a00ae3d42b78994ef81b5f32c7fe997c0208e29f', false, $context);
  $data = json_decode($response);

  $response_commit = file_get_contents($github_repo_url.'/stats/contributors?client_id=bc243b154a63b584b739&client_secret=a00ae3d42b78994ef81b5f32c7fe997c0208e29f', false, $context);
  $data_commit = json_decode($response_commit);
// print_r($data_commit);


  $star = 0;
  foreach ($data as $index => $result) {
// echo $result->name;
    $star = $result->stargazers_count;
    $total_stars += $star;

  }

  $q=mysqli_query($connection,"SELECT id FROM users WHERE email='$email'");
  if(mysqli_num_rows($q) == 0)
  {
    $count=mysqli_query($connection,"INSERT INTO users(email,fullname,company,blog,location,github_id,github_username,profile_image,github_url) VALUES('$email','$fullName','$company','$blog','$location','$github_id','$github_username','$profile_image','$github_url')");
  }
// print_r($userdata); // Full data
//echo '<pre>',print_r($userdata,1),'</pre>';
// echo "<a href='logout.php'>Logout</a>";
}
?>


<!doctype html>
<html class="no-js" lang="en">
<head>
  <!-- <base href="localhost/gitshow" /><!-- Let me check this thing --> 
  <meta charset="utf-8" />

  <meta name="description" content="Bulid your Developer portfolio on a click.">
    <meta name="keywords" content="developer, portfolio, stockroom, website, create">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    
    <title>Stockroom</title>
    <meta property="og:title" content="Stockroom"/>
    <meta property="og:url" content="http://stockroom.io"/>
    <meta property="og:image" content="http://stockroom.io/img/logo_fb.jpg"/>
    <meta property="og:site_name" content="Stockroom"/>
    <meta property="og:description" content="Bulid your Developer portfolio on a click."/>
    
  
    <link href="img/fav.png" type="image/x-icon" rel="shortcut icon" />
  <link rel="stylesheet" href="css/foundation.css" />
  <script src="js/vendor/modernizr.js"></script>

  <link rel="stylesheet" href="css/style.css" />

  <link rel="stylesheet" href="css/font.css" />
  <link rel="stylesheet" href="css/icon.css" />



  <script src="js/modernizr.custom.js"></script>


   <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script type="text/javascript" language="javascript" src="js/jquery.dotdotdot.js"></script>


    <script type="text/javascript" language="javascript">
      




  $(window).scroll(function() {

    if ($(document).scrollTop() > ($(document).height() * 0.05)) {
      $(".wrapper").addClass("wrapper_bg");
    } else {
      $(".wrapper").removeClass("wrapper_bg");

    }
  });



  $(document).ready(function() {

    var elements = $('.repo_desc');
    $.each(elements, function(key, value){ 
      if(value.clientHeight > 160){
        value.className += " truncate";
      }
    })

  });


      $(document).ready(function() {
      $(".repo_desc").dotdotdot({
        watch: "window"
      });
    });


      $(document).ready(function() {
      $(".repo_name").dotdotdot({
        watch: "window"
      });
    });


</script>



</script>


</head>
<body>


       <script type="text/javascript">
     jQuery(document).ready(function($) {  
      $(window).load(function(){
        $('#preloader').fadeOut('slow',function(){$(this).remove();});
      });

      });
    </script>

  
    <div id="preloader"> <span> Loading.. Feel free to wait forever.</span></div>

  <section class="wrapper">

    <div class="row">
       <div class="large-12 columns">
           <div class="small-6 columns"><div class="logo"><img src="img/logo.png"></div></div>
          <div class="small-6 columns"><div class="logout"><a href="#"><img src="img/logout.svg"></a></div></div>
      </div>

    </div>

  </section>




  <!-- ///////////////////////////// Start Intro Section ///////////////////////////// -->

  <section class="intro">

    <div class="row" style="padding-top:120px;padding-bottom:120px;">
      <div class="large-12 large-centered columns profile_info">
       <div class="profile_img"><a href="#"><img src="<?php echo $profile_image ?>" ></a> </div>
       <h1 class="profile_name"><?php echo $fullName ?></h1>


      <div class="outer">
       <ul class="location">
        <li> <img src="img/location.svg" class="location_icon"><?php echo $location ?></li>
        <li><img src="img/time.svg" class="time_icon">Joined on <?php echo $date ?></li>

      </ul>



    </div>


      <div style="clear:both"></div>
      <p><span>2301</span> Profile Views</p>

    </div>
  </div>


</section>




<section class="stats">

  <div class="row stats">
    <div class="large-12 large-centered columns">
      <a href="#"><div class="medium-3 columns">Followers <br> <span class="count"><?php echo $userdata->followers ?></span></div></a>
      <a href="#"><div class="medium-3 columns">Following <br> <span class="count"><?php echo $userdata->following ?></span></div></a>
      <a href="#"><div class="medium-3 columns">Commits<br> <span class="count"><?php echo $commit_count ?></span></div></a>
      <a href="#"><div class="medium-3 columns">Public Gists<br> <span class="count"><?php echo $userdata->public_gists ?></span></div></a>

    </div>
  </div>

</section>










<!-- ///////////////////////////// End Intro Section ///////////////////////////// -->


<section class="repo">
  <div class="row" style="margin-top:40px;">
    <h1>Repositories</h1>




    <?php 
    $language_class = array(
      "JavaScript"  => "one",
      "Ruby"        => "two",
      "Java"        => "three",
      "PHP"         => "four",
      "Python"      => "five",
      "C++"         => "six",
      "C"         => "seven",
      "Objective-C"         => "eight",
      "C#"         => "nine",
      "Shell"         => "ten",
      "CSS"         => "eleven",
      "Perl"         => "twelve",
      "CoffeeScript"         => "thirteen",
      "VimL"         => "fourteen",
      "Scala"         => "fifteen",
      "Go"         => "sixteen",
      "Prolog"         => "seventeen",
      "Clojure"         => "eighteen",
      "Haskell"         => "nineteen",
      "Lua"         => "twenty",
      );

    $row_counter = 1;
    $div_counter = 1;
    foreach ($data as $index => $result) {
      if($row_counter%3==1){
                // echo $div_counter;
                // echo convert_number_to_words($div_counter);
        echo '<div class="row '.convert_number_to_words($div_counter).'" style="margin-top: 30px;">   <!-- Row starts -->
        <div class="large-12 large-centered columns">';
        $div_counter++;
      }

      $class = $language_class[$result->language];


      $html_data = file_get_html($result->html_url);
      $commit_count = $html_data->find("span[class=num text-emphasized]",0)->innertext;


  /*<!-- // $response_commit = file_get_contents($result->url.'/stats/contributors?client_id=0a1d07a0d48fe43d0b3d&client_secret=c4c490531fae065397c994923abeb84a4c3f0fdc', false, $context);
//   $data_commit = json_decode($response_commit, true);
//   //echo $data_commit[$count]['total'];
//   //print_r($data_commit);

// $total_commit = 0;
//   foreach($data_commit as $index_commit => $result_commit)
//   {
//     $commit =  $result_commit['total'];
//     echo $commit;
//     $total_commit =$total_commit + $commit;
//     // print_r($result_commit);
//   }
//     echo $total_commit; -->
*/
  


  echo '<a href="'.$result->html_url.'" target="_blank">
  <div class="medium-4 columns">
  <div class="repo_wrapper">
  <h1 class="lang '.$class.'">'.$result->language.' </h1>
  <h2 class="repo_name">'.$result->name.'</h2>
  <div class="line"></div>
  <p class="repo_desc">'.$result->description.'


  </p>

  <ul class="count">
  <li class="star"><span>'.$result->stargazers_count.'</span> </li>
  <li class="fork"><span>'.$result->forks_count.'</span> </li>
  <li class="commit"><span>'.$commit_count.'</span> </li>
  </ul>

  </div>
  </div>
  </a>'; 

  if($row_counter%3==0)
  {

    echo '</div>
    </div>';
  }
  $row_counter++;
}
?>




</div>

</section>



<section class="connect">
  <div class="row">

    <p> hello@soumyabishi.co</p>
  </div>
</section>



      

        <section class="footer">



              
                <img src="img/dev.png" class="dev">
                     

                     <div class="social">
                        <div class="row" >
                       
                           <div class="small-2 small-centered columns">    


                        

                         <div class="small-6  columns">
                           <a href="https://www.facebook.com/pages/Stockroom/756508734415465" target="_blank" class="icon facebook"><span class="icon-facebook"></span></a>
                          
                        </div>
                       



                          <div class="small-6  columns">
                             <a href="http://twitter.com/stockroomio" target="_blank" class="icon twitter"><span class="icon-twitter"></span></a>
                          
                          </div>

                         
                           
                            </div>
                       </div>
                     </div>



                  <a href="#"><img src="img/logo_footer.png"></a>
                  <img class="zigzag" src="img/zigzag.png">
                  <p>Made with love in India</p>

            </section>



<script src="js/foundation.min.js"></script>
<script>
$(document).foundation();
</script>





</body>
</html>