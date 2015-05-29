<!doctype html>
<html class="no-js" lang="en">
  <head>
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
    <link rel="stylesheet" href="css/style1.css" />
    <link rel="stylesheet" href="css/font.css" />
    <link rel="stylesheet" href="css/icon.css" />

    <link rel="stylesheet" type="text/css" href="css/dialog.css" />
    <link rel="stylesheet" type="text/css" href="css/dialog-ricky.css" />
    

    <script src="js/modernizr.custom.js"></script>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>


    
    
    
    <script type="text/javascript">


    jQuery(document).ready(function($) {  
      $(window).load(function(){
        $('#preloader').fadeOut('slow',function(){$(this).remove();});
      });

      });

      
      $(window).scroll(function() {
        
        if ($(document).scrollTop() > ($(document).height() * 0.05)) {
          $(".wrapper").addClass("wrapper_bg");
        }
        else {
          $(".wrapper").removeClass("wrapper_bg");
          
        }
      }
      );
      
    </script>




    <script type="text/javascript">

                $('#demo1').sharrre({
  share: {
    googlePlus: true,
    facebook: true,
    twitter: true
  },
  buttons: {
    googlePlus: {size: 'tall', annotation:'bubble'},
    facebook: {layout: 'box_count'},
    twitter: {count: 'vertical', via: '_JulienH'}
  },
  hover: function(api, options){
    $(api.element).find('.buttons').show();
  },
  hide: function(api, options){
    $(api.element).find('.buttons').hide();
  },
  enableTracking: true
});
             </script>
    
    
  </head>
  <body>
    
    
     <div id="preloader"></div>
    
     
    
    <a href="http://stockroom.io">
        <div class="logo" style="position:fixed;background: #00BCD4;width: 80px;height: 80px;left: 20px;top: 20px;z-index:999999;">
        <img src="img/logo_1.png" style="width: 40px;display:block;margin-left: 20px;margin-top: 20px;">
        </div>
    </a>
    


    
    
    
    <div id="somedialog" class="dialog">
          <div class="dialog__overlay"></div>
          <div class="dialog__content">
            <h2>Hey, We will be ready by <br>this Sunday. Wait till then :D</h2><div><button class="action" data-dialog-close><img src="img/close.svg"></button></div>
          </div>
        </div>

       
    
    <section class="intro">
      
      <div class="row introtxt">
        
        <div class="title">
          
          <h1>
            Build your 
            <span>
              Developer Portfolio
            </span>
            on a click
          </h1>
          
          <a href="#" class="btn trigger" data-dialog="somedialog" >
            Sign in using Github
          </a>
          
        </div>
        
      </div>
      
    </section>
    
    
    
    
    <section class="steps">
      <div class="row">
        
        <div class="medium-4  columns">
          <h1>
            Sign in
          </h1>
          
          <img src="img/1.png">
          
          <div class="line">
          </div>
          
          <p>
            Step 1 
          </p>
        </div>
        
        <div class="medium-4  columns">
          <h1>
            Authorize
          </h1>
          
          <img src="img/2.png">
          
          <div class="line">
          </div>
          
          <p>
            Step 2 
          </p>
        </div>
        
        <div class="medium-4  columns">
          <h1>
            You're live
          </h1>
          
          <img src="img/3.png">
          
          <div class="line">
          </div>
          
          <p>
            Step 3 
          </p>
        </div>
        
        
      </section>
      
      
      
      
      
      <section class="footer">
        
        <div class="profile_screen">
          <img src="img/profile_screen.png">
        </div>
        
        
        
        



              <div class="social">
                        <div class="row" style="margin-top: -112px;">
                       
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

              
              
              
              <a href="http://stockroom.io">
                <img src="img/logo_footer.png">
              </a>
              <img class="zigzag" src="img/zigzag.png">
              <p>
                Made with love in India
              </p>
              
      </section>
             
             
             
             
          

      <script src="js/vendor/jquery.js"></script>
      <script src="js/foundation.min.js"></script>
      <script>
               $(document).foundation();
      </script>

      <script src="js/classie.js"></script>
    <script src="js/dialogFx.js"></script>

    <script>
      (function() {

        var dlgtrigger = document.querySelector( '[data-dialog]' ),
          somedialog = document.getElementById( dlgtrigger.getAttribute( 'data-dialog' ) ),
          dlg = new DialogFx( somedialog );

        dlgtrigger.addEventListener( 'click', dlg.toggle.bind(dlg) );

      })();
    </script>



    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-58589045-1', 'auto');
  ga('send', 'pageview');

  </script>



             
             
            
             
          
             
    </body>
  </html>