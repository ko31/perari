<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9" lang="en"> <![endif]-->
<!-- Consider adding an manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 9]><!--> 	<html class="no-js" lang="en" itemscope itemtype="http://schema.org/Product"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">

    <title>Free video chat - PERARI</title>
    <meta name="description" content="PERARI is a web service of free video chat. It is created in WebRTC." />

    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon" />

    <!-- Mobile viewport optimized: j.mp/bplateviewport -->
    <meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" type="text/css" href="/css/gumby.css.1379423984" />
	<?php
		echo $this->Html->css('style.css');
	?>

    <!--web-fonts -->
    <link href='//fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Nunito:400,700' rel='stylesheet' type='text/css'>

	<?php
		echo $this->Html->script('modernizr-2.6.2.min');
	?>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  </head>

  <body>

      <nav id="navbar-main-nav" class="navbar fixed" gumby-fixed="top">
      <div class="row">
          <a class="toggle" gumby-trigger="#navbar-main-nav #main-nav" href="#"><i class="icon-menu"></i></a>
          <h1 class="four columns logo">
              <a href="/">
                  <i class="icon-chat"></i>PERARI
              </a>
          </h1>
          <nav class="eight columns pull_right">
          <ul id="main-nav">
              <li>
              </li>
          </ul>
          </nav>
      </div>
      </nav>


<?php echo $this->fetch('content'); ?>


    <div class="wrapper shaded" id="subfoot">
        <section class="row">
        <h3 class="action">Enjoy your chat time!</h3>
        </section>
    </div>

  <div class="wrapper">
      <footer class="row" id="credits">
      <div class="six columns">
          <p>
          <span class="nobr">(c) 2014 <a href="http://go-sign.info/" target="_blank" title="gosign">gosign</a> (<a href="https://twitter.com/ko31">@ko31</a>)</span>
          </p>
      </div>
<!--
      <div class="eight columns">
          <div class="row">
              <ul class="socbtns">
                  <li><div class="btn primary"><a target="_blank" href="https://github.com/GumbyFramework/Gumby">Github</a></div></li>
                  <li><div class="btn twitter"><a target="_blank" href="https://twitter.com/gumbycss">Twitter</a></div></li>
                  <li><div class="btn facebook"><a target="_blank" href="https://www.facebook.com/gumbyframework">Facebook</a></div></li>
                  <li><div class="btn danger"><a target="_blank" href="https://plus.google.com/communities/108760896951473344451">Google+</a></div></li>
              </ul>
          </div>
      </div>
      -->
      </footer>
  </div>

  <script gumby-debug gumby-touch="/bower_components/gumby/js/libs" src="/js/libs/gumby.min.js"></script>
  
  <script src="/js/libs/events.min.js"></script>

  <!--[if lt IE 7 ]>
  <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
  <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->

  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-1736292-42', 'auto');
  ga('send', 'pageview');

  </script>
</body>
</html>
