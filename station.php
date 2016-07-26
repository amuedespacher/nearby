<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="apple-touch-icon" sizes="114x114" href="i/touch-icon.png" />
<meta name="format-detection" content="telephone=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name = "viewport" content = "width = 320, initial-scale = 1.0, user-scalable = no">
<link rel="stylesheet" href="style.css" />
<link rel="apple-touch-icon" href="/i/apple-touch-icon.png" />
 <link rel="shortcut icon" href="i/favicon.ico" type="image/x-icon" /> 

 <script type="text/javascript">
function uhrzeit(anzeige) {
Heute = new Date();//Es wird ein neues Datum angelegt.
Stunde  = Heute.getHours();//Die Variable Stunde wird erstellt
Minute  = Heute.getMinutes();//Die Variable Minute wird erstellt
Sekunde = Heute.getSeconds();//Die Variable Sekunde wird erstellt
document.getElementById("uhr").innerHTML=((Stunde<=9)?"0"+Stunde:Stunde)+":"+((Minute<=9)?"0"+Minute:Minute)+":"+((Sekunde<=9)?"0"+Sekunde:Sekunde)+"";
//Die Ausgabe ist so eingestellt, dass wenn die Minuten oder Sekunden niedriger als 10 sind, automatisch eine 0 vorrangestellt wird.
}</script>

<script>
function getLocation()
  {
  if (navigator.geolocation)
    {
    navigator.geolocation.getCurrentPosition(showPosition);
    }
  else{alert("Dein Browser unterstützt keine Lokalisierungsfunktionen. Deshalb kannst du diesen Dienst leider nicht nutzen.");}
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
<body onLoad="uhrzeit('jetzt'); setInterval('uhrzeit()', 1000)">

<?

include("functions.php");


$lat = $_GET["lat"];
$lng = $_GET["lng"];

if($lat=="" or $lng==""){echo "<meta http-equiv='refresh' content='0; URL=index.php'>";} else{

$url = "http://transport.opendata.ch/v1/locations?x=".$lat."&y=".$lng."";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: transport.opendata.ch'));
$value = curl_exec($ch);
curl_close($ch);


$station_arr = json_decode($value);

//var_dump($station_arr);

echo "<div id='header'><h1 onclick='getLocation()'><img src='i/gps.png'> ".round($lat,3).", ".round($lng,3)."</h1></div>";
echo "<script>document.title='".round($lat,3).", ".round($lng,3)."';</script>";

/*<h3 id='uhr'></h3>*/

echo "<table id='tabl'>";

	echo "<tr>";
	echo "<td class='kl'>Station</td>";
	echo "<td class='kl'>Distanz</td>";
	echo "</tr>";
	


for($i = 0; $i < count($station_arr->stations); $i++ ){
	$latb = $station_arr->stations[$i]->coordinate->y;
	$lngb = $station_arr->stations[$i]->coordinate->x;
	echo "<tr onclick='self.location.href=\"board.php?id=".$station_arr->stations[$i]->id."\"' class='clic'>";
	echo "<td >".$station_arr->stations[$i]->name."</td>";
	echo "<td onclick='self.location.href=\"http://maps.apple.com/maps?q=".$lat.",".$lng."\"' style='cursor:pointer;'>".calculate_distance($lat, $lng, $lngb, $latb)."m</a></td>";
	echo "</tr>";

} 

echo "</table>";
echo "<div id='header2'><h1>Top 10</h1></div>";
echo "<table id='tabl'>";


	echo "<tr><td onclick='self.location.href=\"board.php?id=008503000\"' class='clic'>Z&uuml;rich HB</td></tr>";
	echo "<tr><td onclick='self.location.href=\"board.php?id=008501008\"'class='clic'>Genf</td></tr>";
	echo "<tr><td onclick='self.location.href=\"board.php?id=000000129\"'class='clic'>Basel SBB</td></tr>";
	echo "<tr><td onclick='self.location.href=\"board.php?id=008507000\"'class='clic'>Bern</td></tr>";	
	echo "<tr><td onclick='self.location.href=\"board.php?id=008501120\"'class='clic'>Lausanne</td></tr>";
	echo "<tr><td onclick='self.location.href=\"board.php?id=008505000\"'class='clic'>Luzern</td></tr>";
	echo "<tr><td onclick='self.location.href=\"board.php?id=008506302\"'class='clic'>St. Gallen</td></tr>";
	echo "<tr><td onclick='self.location.href=\"board.php?id=008506000\"'class='clic'>Winterthur</td></tr>";
	echo "<tr><td onclick='self.location.href=\"board.php?id=008505300\"'class='clic'>Lugano</td></tr>";
	echo "<tr><td onclick='self.location.href=\"board.php?id=008505004\"'class='clic'>Arth-Goldau</td></tr>";
	

echo "</table>";

echo "<div id='header2'><h1 onclick='getLocation()'>Locate me!</h1></div>";

}

?></body></html>