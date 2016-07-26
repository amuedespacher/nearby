<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="apple-touch-icon" sizes="114x114" href="i/touch-icon-station.png" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="format-detection" content="telephone=no">
<meta name = "viewport" content = "width = 320, initial-scale = 1.0, user-scalable = no">
<!--<meta http-equiv="refresh" content="20" />!-->
<link rel="stylesheet" href="style.css" />
<link rel="apple-touch-icon" href="/i/apple-touch-icon.png" />
<link rel="shortcut icon" href="i/favicon.ico" type="image/x-icon" /> 
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
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-26576750-3', 'auto');
  ga('send', 'pageview');

</script>
  	



<?

$id = $_GET["id"];

include("functions.php");

if($id==""){echo "<meta http-equiv='refresh' content='0; URL=index.php'>";} else{

$url = "http://transport.opendata.ch/v1/stationboard?id=".$id."&limit=25";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: transport.opendata.ch'));
$value = curl_exec($ch);
curl_close($ch);


$station_arr = json_decode($value);

//var_dump($station_arr);

?>

<meta name="description" content="Haltestellenfahrplan <? echo $station_arr->station->name;?>">



</head>
<body onLoad="uhrzeit('jetzt'); setInterval('uhrzeit()', 1000)">

<?

echo "<div id='header'><h1  onclick='window.location.reload()'>".$station_arr->station->name."</h1></div>";
echo "<script>document.title='".$station_arr->station->name."';</script>";


/*<h3 id='uhr'></h3>*/



echo "<table id='tabl'";

	echo "<tr>";
	echo "<td class='kl'>Linie</td>";
	echo "<td class='kl'>Ziel</td>";
	
	echo "<td class='kl' align='right'>Abfahrt</td>";
	echo "<td class='kl' align='right'>Gl.</td>";
	echo "</tr>";

for($j = 0; $j < count($station_arr->stationboard); $j++ ){

	echo "<tr onclick='self.location.href=\"connection.php?from=".$station_arr->stationboard[$j]->stop->station->id."&to=". urlencode($station_arr->stationboard[$j]->to)."&time=".zeitNormalform($station_arr->stationboard[$j]->stop->departure)."\"' class='clic'>";
	$operator = $station_arr->stationboard[$j]->operator;
	$number = $station_arr->stationboard[$j]->number;
	$category = $station_arr->stationboard[$j]->category;
	$delay = $station_arr->stationboard[$j]->stop->delay;
	if($delay!=""){$delay="<span style='color:#ff0000'>+".$delay."'</span>";} else {$delay="";}
	
	switch($operator){
		case "": $linie = $category; break;
		case "VBZ": $linie = $number; break;
		case "VBZ    F": $linie = $number; break;
		case "VBSG":$linie = $number; break;
		case "PAG":$operator="Postauto";$category="PA"; break;
		case "SOB-sob":$operator="SOB";break;
		default: $linie = $number; break;
	}
	
	switch($category){
		case "NFO": $linie = $number; $cat='Bus'; break;
		case "NFB": $linie = $number; $cat='Bus'; break;
		case "BUS": $linie = $number; $cat='Postauto'; break;
		case "TRO": $linie = $number; $cat='Bus'; break;
		case "BAT": $linie = $number; $cat='Schiff'; break;
		case "PA": $linie = $number; $cat='Postauto'; break;
		case "LB": $linie = $number; $cat= 'Luftseilbahn'; break;
		case "FUN": $linie = $number; $cat='Seilbahn'; break;
		case "R": $linie = $number; $cat='Regio'; break;
		case "NFT": $linie = $number; $cat='Tram'; break;
		case "T": $linie = $number; $cat='Tram'; break;
		case "IR": $linie = $category." ".$number; $cat='Interregio'; break;
		case "IC": $linie = $category." ".$number; $cat='Intercity'; break;
		case "ICN": $linie = $category." ".$number; $cat='Intercity'; break;
		case "TGV": $linie = $category." ".$number; $cat='Intercity'; break;
		case "EC": $linie = $category." ".$number; $cat='Eurocity'; break;
		case "RE": $linie = $category." ".$number; $cat='Regioexpress'; break;
		case "M": $linie = $number; $cat='Metro'; break;
		case "Regio": $linie = $category." ".$number; $cat='Regio'; break;
		default: $linie = $category; $cat='andere'; break;
	}
	
	if(substr($category,0,1)=="S"){
		$linie = $category." ".$number;
		$cat='S-Bahn';
	}
	
	if(substr($category,0,2)=="S"){
		$linie = $category." ".$number;
		$cat='S-Bahn';
	}
	
	//if($linie==$category){$cat="";} else{$cat=$category;}
	
	//echo "<td width='0%'><img src='".getIcon($station_arr->stationboard[$j]->category)."' title='".$station_arr->stationboard[$j]->category." ".$operator."'></td>";
	echo "<td bgcolor='".getColor($operator, $number, $category, $cat)."' class='schild'>".$linie."<br><small>".$cat."</small></td>";
	echo "<td>".$station_arr->stationboard[$j]->to."</td>";
	
	echo "<td align='right'>".zeitDifferenz($station_arr->stationboard[$j]->stop->departure)." ".$delay."</td>";
	echo "<td align='right'>".$station_arr->stationboard[$j]->stop->platform."</td>";
	echo "</tr>";

}

echo "</table>";

echo "<div id='header2'><h1 onclick='getLocation()'>Locate me!</h1></div>";

}




?>




</body>
</html>