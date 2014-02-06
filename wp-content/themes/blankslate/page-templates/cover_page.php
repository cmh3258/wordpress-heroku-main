<?php
/*
Template Name: Cover Page
*/
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    
<head>
    
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> 
<link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,100italic,300italic,400italic' rel='stylesheet' type='text/css'>
    
    <title>Recommenu - Recommendations for individual food items</title>
    <meta name="keywords" content="Mobile App, Recommenu, Menu, Restaurant" />
    <meta name="description" content="A mobile app that allows you to never eat a bad meal again. Users can view recommendations and 
          ratings from friends, food bloggers, chefs and celebrities." />
    <meta name="revised" content="Designer: Katie Eldredge, Chris Hume. Coder: Chris Hume, 11/14/13" />
    <meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
   
 <!--   <link  type="text/css" rel="stylesheet" href="stylesheet2_mobile.css" media="only screen and (max-device-width: 320px)" /> 
    -- <link type="text/css" rel="stylesheet" href="flexslider/flexslider.css" media="all" />

    <link type="text/css" rel="stylesheet" href="home_style.css" media="all" />
-->
    <!--<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>" />-->
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/home_style.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
       
    <!--
    <script src="flexslider/jquery.flexslider.js"></script>
    <script src="flexslider/jquery.jquery.scrollTo.js"></script>
    <script src="flexslider/jquery.localscroll.js"></script>
    -->
    <!-- Load jQuery -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
 
    <!-- Load ScrollTo -->
    <script type="text/javascript" src="http://flesler-plugins.googlecode.com/files/jquery.scrollTo-1.4.2-min.js"></script>
 
    <!-- Load LocalScroll -->
    <script type="text/javascript" src="http://flesler-plugins.googlecode.com/files/jquery.localscroll-1.2.7-min.js"></script>

   <!--<script>
    $(document).ready(function() {
  //change the integers below to match the height of your upper dive, which I called
  //banner.  Just add a 1 to the last number.  console.log($(window).scrollTop())
  //to figure out what the scroll position is when exactly you want to fix the nav
  //bar or div or whatever.  I stuck in the console.log for you.  Just remove when
  //you know the position.
  var fixed = false;
  $(window).scroll(function () { 
  //window.alert("sometext");
    if( $(this).scrollTop() > 500 ) {
        if( !fixed ) {
            fixed = true;
            $('nav').css({
                'color':'green',
                '-webkit-box-shadow': '0 2px 10px #999',
                '-moz-box-shadow': '0 2px 10px #999',
                'box-shadow': '0 2px 10px #999',
                'position' : 'fixed'
                
            });
            $('h3').css({
                'color':''
            });
        }
    } else {
        if( fixed ) {
            fixed = false;
            $('nav').css({
                'border':'0px solid green',
                'box-shadow':'0px 0px black',
                'position' : 'relative'
            });
        }
    }
  });
});


</script> 
    -->
<script>
    $(document).ready(function() {
  //change the integers below to match the height of your upper dive, which I called
  //banner.  Just add a 1 to the last number.  console.log($(window).scrollTop())
  //to figure out what the scroll position is when exactly you want to fix the nav
  //bar or div or whatever.  I stuck in the console.log for you.  Just remove when
  //you know the position.
  $(window).scroll(function () { 

    console.log($(window).scrollTop());

    if ($(window).scrollTop() > 580) {
      $('nav').addClass('navbar-fixed-top');
    }

    if ($(window).scrollTop() < 581) {
      $('nav').removeClass('navbar-fixed-top');
    }
  });
});
</script>

<!-- Place in the <head>, after the three links
<script type="text/javascript" charset="utf-8">
  $(window).load(function() {
    $('.flexslider').flexslider({
        animation : "slide",
        controlsContainer: ".flex-container"
    });
  });
</script>
-->

<script>
    // When the document is loaded...
    $(document).ready(function()
    {
        
        // Scroll the whole document
        $('#nav_list').localScroll({
           target:'body'
        });
        $('#nav_wrap').localScroll({
           target:'body'
        });
        
    });
</script>    
    
</head>

   
   
<body>

    <div id="header_content"> 
      <div class="">
        <div class="container_h">
            <div class="">
                <div class="">
                    <!--<h1>Recommenu</h1>-->
                    <img src="../images/logo_update.png" alt="logo" id="main_logo_small"/>
                    <h3>A great meal, every time</h3>
                    <h5>Recommendations from the people that you trust.</h5>
                </div>
            </div>
        </div>
      </div>
   </div>
    
   <nav class="nav_fix">
            <div id="nav_wrap" class="">    
                <a href="#header_content" class="header_font"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/logo_update.png" alt="logod" id="main_logo"/></a>
                
                <div id="nav_list">
                <ul class="nav_fix">
                    <li><a href="#about">About the App</a></li>
                    <li><a href="#interest">Learn More</a></li>
                    <li><a href="#meetus">Meet the Team</a></li>
                    <li><a href="#contact">Contact Us</a></li>
                    <!--<li><a href="http://recommenublog.zzl.org/">Blog</a></li>
                    <li><a href="../?page_id=6">Blog</a></li>-->
                    <li><a href="<?php echo get_permalink( 7 ); ?>">Blog</a></li>
                    
                    
                   <!-- <li id="download"><a href="#coming_soon">Download RM</a></li> -->
                </ul>
                    </div>
                <!--<p id="get_rm"><a href="#coming_soon"><img src="images/get_rm_button.png" alt="Get RM Button" id="get_rm_button"/></a></p>
                -->
                <a href="#" id="pull"></a>
            </div>             
        </nav>   
       
  <div id="about"></div>   
  <div id="main_content_pad"></div>  
 
   <!-- 
   <div class="section">
        <div class="container">
            <div class="center">
                <div class="content">
                  <div class="info">   
                     <h3 id="title_small">Recommenu</h3>
                     <p>
                         An iPhone app that pulls up a restaurants menu
                         along with recommendations for each item. Allowing you
                         to leave any restaurant satisfied.
                      </p>
                  </div>                     
                </div>
               
            </div>
        </div>
       
    </div>
  <hr id ="seperator_center"></hr>
   -->
    
    
  
  
  <!-- Place somewhere in the <body> of your page 
   -->
   <!--
 <div id="feature_section_2">
    <div class="section">
        <div class="container">
            <div class="center">
                <div class="content">
                  <div class="info_features">   
                    <div class="float_left_2">   
<div class="flexslider">
  <ul class="slides">
    <li>
      <img src="flexslider/images/slide1.jpg" />
    </li>
    <li>
      <img src="flexslider/images/slide2.jpg" />
      <p class="flex-caption">This image is wrapped in a link!</p>
    </li>
    <li>
      <img src="flexslider/images/slide3.jpg" />
    </li>
  </ul>
</div></div>
                         <div class="float_right">    
                        
                    </div>
                  </div>                     
                </div>
            </div>
        </div>
    </div>
   </div>

  
<div class="main_feature_slider">
    <div id="feature_1" class="feature_slide">
        <h3>Feature one</h3>
    </div>
    <div id="feature_2" class="feature_slide">
        <h3>Feature teo</h3>
    </div>
    <div id="feature_3" class="feature_slide">
        <h3>Feature three</h3>
    </div>
    <div id="feature_4" class="feature_slide">
        <h3>Feature four</h3>
    </div>
</div>    
  
   -->
  
   <div id="feature_section">
    <div class="section">
        <div class="container">
            <div class="center">
                <div class="content">
                  <div class="info_features"> 
                      
                      <table id="table_feature">
                          <tr>
                              <td id="feat_tab_cell_l">
                                  <img src="<?php bloginfo('stylesheet_directory'); ?>/images/img_menu.png" alt="logo" id="screen_shot_main"/>
                              </td>
                              <td id="feat_tab_cell_r">
                                   <h4>Decide What to Order</h4>
                            <p id="desc_feat">
                                You know where to eat. Now decide what to eat. Have an answer to the question we all ask: "What's good here...?"
                            </p>
                                   
                                   <h4>Opinions you Actually Trust</h4>
                            <p id="desc_feat">
                                See the trusted opinions of local chefs, foodies, and your friends.
                            </p>
                                   
                                   <h4>Convenient Quick-Glance Ratings</h4>
                            <p id="desc_feat">
                                No long reviews. No boring 1-5 star ratings. Fun, simple, intuitive color ratings.
                            </p>
                              </td>
                          </tr> 
                      </table> 
                      <table id="table_feature_small">
                          <tr>
                              <td id="feat_tab_cell_l">
                                  <img src="<?php bloginfo('stylesheet_directory'); ?>/images/img_menu.png" alt="logo" id="screen_shot_main"/>
                              </td>
                          </tr><tr>    
                              <td id="feat_tab_cell_r">
                                   <h4>Decide What to Order</h4>
                            <p id="desc_feat">
                                You know where to eat. Now decide what to eat. Have an answer to the question we all ask: "What's good here...?"
                            </p>
                                   
                                   <h4>Opinions you Actually Trust</h4>
                            <p id="desc_feat">
                                See the trusted opinions of local chefs, foodies, and your friends.
                            </p>
                                   
                                   <h4>Convenient Quick-Glance Ratings</h4>
                            <p id="desc_feat">
                                No long reviews. No boring 1-5 star ratings. Fun, simple, intuitive color ratings.
                            </p>
                              </td>
                          </tr> 
                      </table> 
                     
                      
                      
                      <!--
                    <div class="float_left">
                        <img src="images/iphone_temp_menu.png" alt="logo" id="screen_shot"/>
                    </div>
                   <div class="centerc">   
                    <div class="float_right">    
                        <!--<img src="images/menu screen_mini.png" alt="screenshot" id="dash_preview"/>-->
                      <!--  
                        <div class="current_feature"> 
                            <img src="images/icon_bulb.png" alt="lightbulb" id="icon_feature"/>
                            <h4>Decide What to Order</h4>
                            <p id="desc_feat">
                                You know where to eat. Now decide what to eat. Have an answer to the question we all ask: "What's good here...?"
                            </p>
                        </div>  
                        <div class="current_feature">  
                            <img src="images/icon_checkmark.png" alt="check" id="icon_feature"/>
                            <h4>Opinions you Actually Trust</h4>
                            <p id="desc_feat">
                                See the trusted opinions of local chefs, foodies, and your friends.
                            </p>
                        </div>
                        <div class="current_feature">  
                            <!-- Glasses designed by: http://sethtaylor.com/b2/2013/09/02/free-vector-glasses-icon/ -->  
                       <!--     
                            <img src="images/icon_glasses.png" alt="glasses" id="icon_feature"/>
                            <h4>Convenient Quick-Glance Ratings</h4>
                            <p id="desc_feat">
                                No long reviews. No boring 1-5 star ratings. Fun, simple, intuitive color ratings.
                            </p>
                        </div>
                       </div> 
                     
                    </div>
                       -->
                  </div>                     
                </div>
            </div>
        </div>
    </div>
   </div>
       
   <div id="interest"></div>
   
   <div id="mailing_list_background">
    <div class="section">
        <div class="container">
            <div class="">
                <div class="">
                  <div id="mailing_list_content" class="">   
                     <h3>Interested in Recommenu?</h3>
                     <p id="desc_title2">Sign up for updates, special invites and early access.</p>
                    
                     <!--
                     <form action="email.php" method="post" id="form_email">  
                       <table id="table_interest">
                           <tr>
                               <td> 
                                   <input type="text" name="email" placeholder="Place Email Here" id="input_text">
                               </td>
                               <td>
                                   <input type="submit" id="submit_button_2">            
                               </td>
                           </tr>
                       </table> 
                      </form>    
                      <form action="email.php" method="post" id="form_email">   
                       <table id="table_interest_small">
                           <tr>
                               <td> 
                                   <input type="text" name="email" placeholder="Place Email Here" id="input_text">
                               </td>
                           <tr></tr>    
                               <td>
                                   <input type="submit" id="submit_button_2">            
                               </td>
                           </tr>
                       </table>         
                     </form>
                  </div>                     
                </div>
            </div>
        </div>
    </div>
   </div>
   -->
   
  
    <form id="signup" action="cover_page.php" method="get">
        <input type="hidden" name="ajax" value="true" />
        <input type="text" name="fname" placeholder="First Name" id="fname" class="textinput" value="" />
        <input type="text" name="lname" placeholder="Last Name" id="lname" class="textinput" value="" />
        <input type="email" name="email" placeholder="Email" id="email" class="textinput" value="" />
        <input type="text" name="cname" id="cname" placeholder="City" class="textinput" value="" />
        <!--
        HTML: <input type="radio" name="emailtype" value="html" checked="checked">
        Text: <input type="radio" name="emailtype" value="text">
        -->
        
        <input type="submit" id="SendButton" name="submit" class="textinput" value="Submit" />
    </form>
    <div id="message"></div>


    <script type="text/javascript">
    $(document).ready(function() {
        //alert("I am an alert box!");
        $('#signup').submit(function() {
            $("#message").html("<span class='error'>Adding your email address...</span>");
            $.ajax({
                
                url: '<?php bloginfo('stylesheet_directory'); ?>/page-templates/mcapi/inc/store-address.php', // proper url to your "store-address.php" file
                data: $('#signup').serialize(),
                success: function(msg) {
                    $('#message').html(msg);
                }
            });
        return false;
        });
    });
    </script>
    </div></div></div></div></div></div>
                
         
                
		<!--<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>-->
		<script type="text/javascript" src="js/mailing-list.js"></script>


   
    
 <div id="meetus"></div>  
 <div id="company_section">
   <div class="section">
        <div class="container">
            <div class="">
                <div class="">
                  <div class="">   
                     <h3>Meet Our Team</h3>
                     <hr></hr>
                     <!-- Company Info Section -->
                     <table id="company_table">
                         <tr>
                             <table id="company_table">
                                 <td><img src="<?php bloginfo('stylesheet_directory'); ?>/images/img_jake.png" alt="jake" id="prof_pic"/>
                                     <h5>Jake Bailey</h5>
                                     <h6>CEO</h6>
                                     <!--
                                     <div id="icons_personal">
                                         <a href="#our_team"><img src="images/person_icon.png" alt="j" id="icon_personal_web"/></a>   
                                     </div>
                                     -->
                                 </td>
                                 <td><img src="<?php bloginfo('stylesheet_directory'); ?>/images/img_blake.png" alt="blake" id="prof_pic"/>
                                     <h5>Blake Ellingham</h5>
                                     <h6>CTO, Frontend Developer</h6>
                                     <!--
                                     <div id="icons_personal">
                                         <a href="http://www.linkedin.com/profile/view?id=210209513&locale=en_US&trk=tyah2&trkInfo=tas%3Ablake%20elling"><img src="images/person_icon.png" alt="j" id="icon_personal_web"/></a>   
                                     </div>
                                     -->
                                 </td>
                                 <td><a href="http://caisbalderas.com/"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/img_carlos.png" alt="los" id="prof_pic"/></a>
                                     <h5>Carlos Balderas</h5>
                                     <h6>Backend Developer</h6>
                                     <!--
                                     <div id="icons_personal">
                                         <a href="http://caisbalderas.com/"><img src="images/person_icon.png" alt="j" id="icon_personal_web"/></a>   
                                     </div>
                                     -->
                                 </td>
                             </table>    
                             <table id="company_table">
                                 <td><img src="<?php bloginfo('stylesheet_directory'); ?>/images/img_claire.png" alt="claire" id="prof_pic"/>
                                     <h5>Clair Zimowski</h5>
                                     <h6>Designer</h6>
                                     <!--
                                     <div id="icons_personal">
                                         <a href="http://caisbalderas.com/"><img src="images/person_icon.png" alt="j" id="icon_personal_web"/></a>   
                                     </div>
                                     -->
                                 </td>
                                 <td><a href="http://www.cs.utexas.edu/~cmh3258/"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/img_chris.png" alt="chris" id="prof_pic"/></a>
                                     <h5>Chris Hume</h5>
                                     <h6>Web and Backend Developer</h6>
                                     <!--
                                     <div id="icons_personal">
                                         <a href="#our_team"><img src="images/person_icon.png" alt="j" id="icon_personal_web"/></a>   
                                     </div>
                                     -->
                                 </td>
                                 <td><img src="<?php bloginfo('stylesheet_directory'); ?>/images/img_katie.png" alt="katie" id="prof_pic"/>
                                     <h5>Katie Eldredge</h5>
                                     <h6>Designer</h6>
                                    <!-- <div id="icons_personal">
                                         <a href="#our_team"><img src="images/person_icon.png" alt="j" id="icon_personal_web"/></a>   
                                     </div>
                                    -->
                                 </td>
                         </tr>
                         </table>
                     </table>
                    </div>                     
                </div>
            </div>
        </div>
    </div>             
 </div>
       
 <div id="company_section_small">
   <div class="section">
        <div class="container">
            <div class="">
                <div class="">
                  <div class="">   
                     <h3>Meet Our Team</h3>
                     <hr></hr>
                     <!-- Company Info Section -->
                     <table id="company_table">
                         <tr>
                             <table id="company_table">
                                 <td><img src="<?php bloginfo('stylesheet_directory'); ?>/images/img_jake.png" alt="jake" id="prof_pic"/>
                                     <h5>Jake Bailey</h5>
                                     <h6>CEO</h6>
                                     <!--
                                     <div id="icons_personal">
                                         <a href="#our_team"><img src="images/person_icon.png" alt="j" id="icon_personal_web"/></a>   
                                     </div>
                                     -->
                                 </td>
                                 <td><img src="<?php bloginfo('stylesheet_directory'); ?>/images/img_blake.png" alt="blake" id="prof_pic"/>
                                     <h5>Blake Ellingham</h5>
                                     <h6>CTO, Frontend Developer</h6>
                                     <!--
                                     <div id="icons_personal">
                                         <a href="http://www.linkedin.com/profile/view?id=210209513&locale=en_US&trk=tyah2&trkInfo=tas%3Ablake%20elling"><img src="images/person_icon.png" alt="j" id="icon_personal_web"/></a>   
                                     </div>
                                     -->
                                 </td>
                             </table>    
                             <table id="company_table">
                                 <td><a href="http://caisbalderas.com/"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/img_carlos.png" alt="los" id="prof_pic"/></a>
                                     <h5>Carlos Balderas</h5>
                                     <h6>Backend Developer</h6>
                                     <!--
                                     <div id="icons_personal">
                                         <a href="http://caisbalderas.com/"><img src="images/person_icon.png" alt="j" id="icon_personal_web"/></a>   
                                     </div>
                                     -->
                                 </td>
                                 <td><a href="http://www.cs.utexas.edu/~cmh3258/"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/img_chris.png" alt="chris" id="prof_pic"/></a>
                                     <h5>Chris Hume</h5>
                                     <h6>Web and Backend Developer</h6>
                                     <!--
                                     <div id="icons_personal">
                                         <a href="#our_team"><img src="images/person_icon.png" alt="j" id="icon_personal_web"/></a>   
                                     </div>
                                     -->
                                 </td>
                               </table>  <table id="company_table">
                                 <td><img src="<?php bloginfo('stylesheet_directory'); ?>/images/img_katie.png" alt="chris" id="prof_pic"/>
                                     <h5>Katie Eldredge</h5>
                                     <h6>Designer</h6>
                                    <!-- <div id="icons_personal">
                                         <a href="#our_team"><img src="images/person_icon.png" alt="j" id="icon_personal_web"/></a>   
                                     </div>
                                    -->
                                 </td>
                                 <td><img src="<?php bloginfo('stylesheet_directory'); ?>/images/img_claire.png" alt="claire" id="prof_pic"/>
                                     <h5>Clair Zimowski</h5>
                                     <h6>Designer</h6>
                                     <!--
                                     <div id="icons_personal">
                                         <a href="http://caisbalderas.com/"><img src="images/person_icon.png" alt="j" id="icon_personal_web"/></a>   
                                     </div>
                                     -->
                                 </td>
                                 </table>  
                         </tr>
                         </table>
                     </table>
                    </div>                     
                </div>
            </div>
        </div>
    </div>             
 </div>           
 
   
   
   
   
   <!-- Company Info Section :: Small 
   <table id="company_table_small">
       <tr>
           <td><img src="images/jake_icon.png" alt="jake" id="prof_pic"/>
               <h5>Jake Bailey</h5>
               <h6>CEO, Business Man</h6>
               <div id="icons_personal">
                    <a href="#our_team"><img src="images/person_icon.png" alt="j" id="icon_personal_web"/></a>   
               </div>
           </td>
           <td><img src="images/blake_icon.png" alt="blake" id="prof_pic"/>
               <h5>Blake Ellingham</h5>
               <h6>CTO, Front-End Guru</h6>
               <div id="icons_personal">
                    <a href="http://www.linkedin.com/profile/view?id=210209513&locale=en_US&trk=tyah2&trkInfo=tas%3Ablake%20elling"><img src="images/person_icon.png" alt="j" id="icon_personal_web"/></a>   
               </div>
           </td>
        </tr>
        <tr>
           <td><img src="images/los_icon.png" alt="los" id="prof_pic"/>
               <h5>Carlos Balderas</h5>
               <h6>Backend Master</h6>
               <div id="icons_personal">
                    <a href="http://caisbalderas.com/"><img src="images/person_icon.png" alt="j" id="icon_personal_web"/></a>   
               </div>
           </td>
           <td><img src="images/chris_icon.png" alt="chris" id="prof_pic"/>
               <h5>Chris Hume</h5>
               <h6>Web Dev, Backend</h6>
               <div id="icons_personal">
                    <a href="#our_team"><img src="images/person_icon.png" alt="j" id="icon_personal_web"/></a>   
               </div>
           </td>
       </tr>
   </table>
   
   <!-- Contact_section -->
   <div id="contact"></div>
   <footer>
       <div class="section">
         <div class="container">
           <div class="center">
               <div id="bottom_navigation">
                   <ul>
                        <li><a href="#wider">Home /</a></li>
                        <li><a href="#feature_section">Features /</a></li>
                        <li><a href="#our_team">Team /</a></li>
                        <li><a href="#access">Download</a></li>
                   </ul>
               </div>
               <div id="icon_navigation">
                   <ul>
                       <!-- <li><a href=""><img src="" alt="blog"/></a></li> -->
                        <li><a href="https://twitter.com/RecommenuApp/"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/twiiter_icon.png"></a></li>
                        <li><a href="https://www.facebook.com/recommenuapp"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/facebook_icon.png"></a></li>
                        <li><a href="mailto:mail.recommenu@gmail.com?Subject=Recommenu%20Notification"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/mail_icon.png"></a></li>
                   </ul>
               </div> 
           </div>   
         </div> 
       </div> 
   </footer>    
   
   <!-- Contact_section_mobile -->
   <div id="contact_mobile" class="">
       <div id="">
           <ul>
               <!-- <li><a href="">Blog</a></li>-->
               <li><a href="https://twitter.com/RecommenuApp/"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/twiiter_icon.png"></a></li>
               <li><a href="https://www.facebook.com/recommenuapp"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/facebook_icon.png"></a></li>
               <li><a href="mailto:mail.recommenu@gmail.com?Subject=Recommenu%20Notification"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/mail_icon.png"></a></li>
           </ul>
       </div>    
   </div>    
</div>    
   
     <!-- FlexSlider -->
     <!--
  <script defer src="js/jquery.flexslider.js"></script>
  
  <script type="text/javascript">
      $('#submit_button').hover(function() {
    $(this).find("sumbit_button_white").fadeToggle();
});

      </script>
  
  <script type="text/javascript">
    $(function(){
      SyntaxHighlighter.all();
    });
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "slide",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
  </script>
  <script type="text/javascript">
    $(function(){
      SyntaxHighlighter.all();
    });
    $(window).load(function(){
      $('.flexslider2').flexslider({
        animation: "slide",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
  </script>
  
  <!-- Syntax Highlighter -->
  <!--
  <script type="text/javascript" src="js/shCore.js"></script>
  <script type="text/javascript" src="js/shBrushXml.js"></script>
  <script type="text/javascript" src="js/shBrushJScript.js"></script>
  
  <!-- Optional FlexSlider Additions -->
  <!--
  <script src="js/jquery.easing.js"></script>
  <script src="js/jquery.mousewheel.js"></script>
  <script defer src="js/demo.js"></script>
  -->
  <!--
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-44520220-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
  -->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-44520220-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>  
  
</body>
</html>    
