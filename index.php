<?php
 include "miggy.php";
 $miggy = new Miggy();
 $miggy->connect();
 ?>

<!DOCTYPE html>

<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>#GovHack 2013 - Gold Coast/Australia | Inclusive // Illuside</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Australia gold coast govhack 2013">
    <meta name="author" content="">

    <!-- Le styles -->
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="js/bootstrap-datepicker.js" rel="stylesheet">
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
<!--    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>-->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=visualization"></script>

    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Country', 'Total'],
          <?php echo $miggy->showGoogleChart($_REQUEST['year']); ?>
        ]);

        var options = {
          title: 'Top 10 Immigration',
		  backgroundColor: 'none',
		  height: '400',
		  width: '600',
		  label: 'labeled',
		  is3D: 'true',
           };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>


    <link href="css/style.css" rel="stylesheet">

    <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="http://twitter.github.io/bootstrap/assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://twitter.github.io/bootstrap/assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="http://twitter.github.io/bootstrap/assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="http://twitter.github.io/bootstrap/assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="http://twitter.github.io/bootstrap/assets/ico/favicon.png">
  </head>

  <body>

  <div class="navbar navbar-inverse navbar-fixed-top">  <!--------- START NAVBAR ------------>
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="/"><img src="img/miggy_markOnly.png" class="mark"></a>
          <div class="nav-collapse collapse">
            <ul class="nav pull-right">
              <li class="active"><a href="http://govhack.org" target="_blank">#GovHack 2013</a></li>

            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>



    <div class="container ">

      <img src="img/miggy_v01.png" class="logo">

      <div class="intro">
      	<h1>Discover the <span>positive</span> impact made by<span> immigrants</span> in Australia by exploring their <span>culinary</span> contribution. <span>Enjoy!</span></h1>
      </div>

    </div> <!-- /container -->
<a name="show"></a>
    <div class="container">  <!--------- START MIGGY ------------>
    	<div class="row-fluid">


        	<div class="span12"> <!--------- START DATE PICKER ------------>
            	<h3>When?</h3>
                	<p>Pick a year, I dare you!</p>

                    <form method="post" name="installer" onsubmit="showHide(); return false;">
                    	<select onchange="window.location =  '?year=' +  jQuery('#year option:selected').val() + '#show';" id="year">
                        <?php
                            echo $miggy->getDropDownDataByYear( $_REQUEST['year'] );
                        ?>
                        </select>

                        <br/>

                        <input type="submit" value="Go" name="submit" id="submit" />

                    </form>

            </div><!--------- FINISH DATE PICKER ------------>


            </div>

            <div id="hidden_div" style="display:none;">

                <div class="row-fluid">
                    <div class="span12 countryList"><!--------- START LIST BLOCK ------------>

                        <a name="show"></a>

                        <h3>Top Migrating Nations in <?php echo $_REQUEST['year']?></h3>
                            <p>These are the top 10 nationalities that migrated to Australia ...</p>

                            <div class="row-fluid">
                                <div class="span7 offset2">

                					<div id="chart_div"></div><!--------- CHART BLOCK ------------>
           						 </div>
  							</div>
                 </div>

        <div class="row-fluid">
        	<div class="span6"><!--------- START MAP BLOCK ------------>
                <a name="map"></a>
                <h3>Where are they going to?</h3>
                    <p>Which places are benefiting from these cultures</p>

                    <?php
                    echo$miggy->showLabelMap( $_REQUEST['year'] );
                    ?>

<!--                    <button onclick="toggleHeatmap()">Toggle Heatmap</button>-->
<!--                    <button onclick="toggleIcons()">Toggle Icons</button>-->

                    <div id="map_canvas" style="width: 510px; height: 478px; border: #fff solid 4px;"></div>


        </div><!--------- FINISH MAP BLOCK ------------>

        <div class="span6">
        	<h3>Here's the exciting part!</h3>
            	<p>Find cuisines of the respectives cultures in your area!</p>

                <ul class="thumbnails" style="width: 448px;margin-left: 59px;">
                  <li class="span1">
                    <div class="thumbnail">
                      <img src="img/icons/restaurantIcon-aqua.png" alt="QLD" />
                      <p>QLD</hp>
                    </div>
                  </li>
                  <li class="span1">
                    <div class="thumbnail">
                      <img src="img/icons/restaurantIcon-blue.png" alt="NSW" />
                      <p>NSW</p>
                    </div>
                  </li>
                  <li class="span1">
                    <div class="thumbnail">
                      <img src="img/icons/restaurantIcon-cyan.png" alt="ACT" />
                      <p>ACT</p>
                    </div>
                  </li>
                  <li class="span1">
                    <div class="thumbnail">
                      <img src="img/icons/restaurantIcon-green.png" alt="WA" />
                      <p>WA</p>
                    </div>
                  </li>
                  <li class="span1">
                    <div class="thumbnail">
                      <img src="img/icons/restaurantIcon-orange.png" alt="VIC" />
                      <p>VIC</p>
                    </div>
                  </li>
                  <li class="span1">
                    <div class="thumbnail">
                      <img src="img/icons/restaurantIcon-purple.png" alt="SA" />
                      <p>SA</p>
                    </div>
                  </li>
                  <li class="span1">
                    <div class="thumbnail">
                      <img src="img/icons/restaurantIcon-red.png" alt="TAS" />
                      <p>SA</p>
                    </div>
                  </li>
                </ul>

                <div class="restaurantList">

                <?php
                    echo $miggy->getGooglePlaces($_REQUEST['year']);
                ?>

                </div><!--------- RESTAURANT LIST ------------>
        </div>

      </div> <!--------- FINISH ROW ------------>


    </div>

         </div>

         </div>

      <div class="footer">
      	<div class="container">
            <div class="row-fluid">
                <div class="span4">
                	<img src="img/GovHack_logo_GreyScale.png">
                </div>
                <div class="span8">
                	<p>Front-end built with  <a href="http://twitter.github.io/bootstrap/index.html">Twitter Bootstrap</a>, Pattern by <a href="www.subtlepatterns.com">Subtle Patterns</a>, font by <a href="http://www.google.com/fonts#UsePlace:use/Collection:Lato">Google Fonts</a> and on Blood, Sweat and Tears (kinda litterally).</p>
                </div>

            </div>
          </div>
      </div>



    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/script.js"></script>

    <script>
    $( document ).ready(function() {
        $('.datepicker').datepicker()
    });
    </script>

    <script type="text/javascript">
 function showHide() {
   var div = document.getElementById("hidden_div");
   if (div.style.display == 'none') {
     div.style.display = '';
   }
   else {
     div.style.display = 'none';
   }
 }
  <?php
if ($_REQUEST['year']) {
    echo '$("#hidden_div").css("display","block");';
 }else{
    echo '$("#hidden_div").css("display","none");';
 }
 ?>
</script>


<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-41392060-1', 'miggy.com.au');
  ga('send', 'pageview');

</script>



</body></html>