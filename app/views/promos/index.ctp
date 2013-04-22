<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<head> 
<title><?php echo Configure::read('site.name');?> | <?php echo $this->Html->cText($title_for_layout, false);?></title>
<?php
    echo $this->Html->meta('icon'), "\n";
    echo $this->Html->meta('keywords', $meta_for_layout['keywords']), "\n";
    echo $this->Html->meta('description', $meta_for_layout['description']), "\n";
    echo $this->Html->css('smoothness/jquery-ui-1.8.18.custom.css');
?>    
    
<?php echo $this->element('site_tracker', array('cache' => 30, 'plugin' => 'site_tracker')); ?>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        
        <!-- styles -->
        <link href="/assets/css/bootstrap.css" rel="stylesheet">
        <link href="/assets/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="/assets/css/docs.css" rel="stylesheet">
        <link href="/assets/js/google-code-prettify/prettify.css" rel="stylesheet">
        <link rel="stylesheet" href="/assets/css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
                <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
                <!-- fav and touch icons -->

        <link rel="apple-touch-icon" href="/assets/ico/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/assets/ico/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/assets/ico/apple-touch-icon-114x114.png">
        <!--GOOGLE FONTS-->
        <link href='http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz' rel='stylesheet' type='text/css' />
        <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css' />
        <link href='http://fonts.googleapis.com/css?family=Quattrocento+Sans:400,700,400italic,700italic|Doppio+One' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Fugaz+One' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Bowlby+One+SC' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Days+One|Open+Sans+Condensed:700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Exo:800' rel='stylesheet' type='text/css'>
        <!--/GOOGLE FONTS-->

        <style type="text/css">
            #mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
            #wrap{margin:0 auto 0 auto; width:1024px;}
            #mailchimp{margin:0 auto 0 auto; width:750px;}
        </style>
</head>
<body style="background-color: #82abcd;">

<br /><br />

<div id="wrap" class="well">
    <br />
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span4">
            <!--Sidebar content-->
            <img style="margin-left: 70px !important;" src="img/logo.png" />
            <hr>
                <div class="alert alert-info">
                  <strong>Launching soon in</strong> Boston, New York, Spain, Argentina, Italy, Puerto Rico & Dominican Republic.
                </div>  
                <hr>
                <!-- Begin MailChimp Signup Form -->
                <link href="http://cdn-images.mailchimp.com/embedcode/slim-081711.css" rel="stylesheet" type="text/css">
                <div>
                <form action="http://joinajoin.us5.list-manage1.com/subscribe/post?u=ad8b183644394a80859a35fca&amp;id=0bf03dac34" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
                    <label for="mce-EMAIL"><h5>Sign up and we'll send you information on how you can benefit as a Join Seeker or Join Provider.</h5></label>
                    <input style="width: 97% !important;" type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
                    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="btn btn-info btn-large"></div>
                </form>
                </div>
                <!--End mc_embed_signup-->  
                <hr>  
                <div style="padding-top: 35px;">
                     <a style="color: #FFF !important;" href="<?php echo Configure::read('facebook.site_facebook_url'); ?>" title="Follow me on facebook"><button class="btn btn-primary">Follow me on facebook </button></a>
                     <a style="color: #FFF !important;" href="<?php echo Configure::read('twitter.site_twitter_url'); ?>" title="Follow me on twitter"><button class="btn btn-info">Follow me on twitter </button></a>
                </div>
                
        </div>
        
        
        
        <div class="span8">
            <!--Body content-->
            <h2>Have Fun and Make a Living</h2>
            <div class="well modal-example" style="background-color: #CCC; border: none; padding: 5px !important;">
                <iframe id="ytplayer" type="text/html" width="638" height="359"src="http://www.youtube.com/embed/9bg7EkS-UkI?&theme=light&autoplay=1" frameborder="0"/></iframe>
            </div>    
            <h3>We're currently scouting rentals, spots and experiences for you.</h3>
        </div>

      </div>
    </div>
</div>

<!--
<div id="wrap">
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span9">
                <button class="btn btn-primary"> <a style="color: #FFF !important;" href="<?php echo Configure::read('facebook.site_facebook_url'); ?>" title="Follow me on facebook">Follow me on facebook</a> </button>
            </div>    

            <div class="span3">    
                <button class="btn btn-info"> <a style="color: #FFF !important;" href="<?php echo Configure::read('twitter.site_twitter_url'); ?>" title="Follow me on twitter">Follow me on twitter</a> </button>
            </div>    
        </div>
    </div>
</div>
-->
<body>
</html>