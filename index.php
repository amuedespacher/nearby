<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="apple-touch-icon" sizes="114x114" href="i/touch-icon.png" />
<meta name="format-detection" content="telephone=no">
<meta name = "viewport" content = "width = 320, initial-scale = 1.0, user-scalable = no">
<meta http-equiv="content-language" content="en, fr, de">
<link rel="stylesheet" href="style.css" />
<link rel="apple-touch-icon" href="/i/apple-touch-icon.png" />
 <link rel="shortcut icon" href="i/favicon.ico" type="image/x-icon" /> 
<title>Nearby - finde die n&auml;chste Zug-, Tram- oder Busverbindung</title>
<meta name="description" content="'Nearby' zeigt dir, wo und wann der n&auml;chste Bus, Zug oder das n&auml;chste Tram in deiner N&auml;he abf&auml;hrt.">
<script>
function getLocation()
  {
  if (navigator.geolocation)
    {
    navigator.geolocation.getCurrentPosition(showPosition);
    }
  else{
  	document.getElementById("locerror").innerHTML ="Dein Browser unterstützt keine Lokalisierungsfunktionen. Deshalb kannst du diesen Dienst leider nicht nutzen.";
  	alert("Dein Browser unterstützt keine Lokalisierungsfunktionen. Deshalb kannst du diesen Dienst leider nicht nutzen.");}
  }
function showPosition(position)
  {
  self.location.href = "station.php?lat=" + position.coords.latitude.toFixed(9) + "&lng=" + position.coords.longitude.toFixed(9);
  }
  	</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-26576750-3', 'auto');
  ga('send', 'pageview');

</script>

</head>
<body bgcolor="#dddddd">

<div id="headerhome"><h1>Nearby <sup>beta</sup></h1></div>
<div id="resthome">
	<div width="100%" style="height:20px"></div>
	<div width="100%" style="text-align:center; color: grey; padding-left:60px; padding-right:60px;">'Nearby' zeigt dir, wo und wann der n&auml;chste Bus, Zug oder das n&auml;chste Tram in deiner N&auml;he abf&auml;hrt.</div>
	<div width="100%" style="height:20px"></div>
	<div width="100%" style="text-align:center"><div id="button" onclick="getLocation()"><img src='i/gps_red.png'> Locate me!</div></div>
	<div width="100%" style="height:20px" id="locerror"></div>
	<div width="100%" style="height:20px"></div>
	<div width="100%" style="text-align:center; color: grey; padding-left:60px; padding-right:60px;"><small>Optimiert f&uuml;r mobile Ger&auml;te</small></div>
	
	
	<div id="header2" style="bottom:0px; position:fixed;" onclick="document.getElementById('footer').style.display='block'"><h2>Impressum - Datenschutz</h2></div>
	<div id="footer" onclick="document.getElementById('footer').style.display='none'" style="padding:5px;">
	<h2>Impressum - Datenschutz</h2>
	<p>Concept & Realisation: <a href="http://www.alexandermuedespacher.ch">Alexander M&uuml;despacher</a></p>
	<p>Fahrplandaten: Transport API by <a href="http://transport.opendata.ch">opendata.ch</a></p>

	<p>Daten werden mit <a href="http://www.google.com/analytics/">Google Analytics</a> analysiert. Es werden jedoch keine personenbezogenen Daten auf dem Webserver gespeichert.</p>
	</div>
	
</div>

</body>
</html>
