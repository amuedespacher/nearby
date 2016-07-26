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
 
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-26576750-3', 'auto');
  ga('send', 'pageview');

</script>

</head>
<body>

<?
$from = $_GET["from"];
$to = $_GET["to"];
//$date = $_GET["date"];
$time = $_GET["time"];

include("functions.php");

$to = urldecode($to);
$to = get_stationid($to);

$url = "http://transport.opendata.ch/v1/connections?from=".$from."&to=".$to."&time=".$time."&limit=1&direct=1";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: transport.opendata.ch'));
$value = curl_exec($ch);
curl_close($ch);


$connection = json_decode($value);

//var_dump($connection);

echo "<div id='header'><h1  onclick='window.location.reload()'>".$connection->connections[0]->from->station->name." &rarr; ".$connection->connections[0]->to->station->name."</h1></div>";


echo "<table id='tabl'>";

	echo "<tr>";
	echo "<td class='kl'>Station</td>";
	echo "<td class='kl'>Ankunft</td>";
	echo "<td class='kl'>Abfahrt</td>";	
	echo "</tr>";
	


for($i = 0; $i < count($connection->connections[0]->sections[0]->journey->passList); $i++ ){
	$statid = $connection->connections[0]->sections[0]->journey->passList[$i]->station->id;
	$stat = $connection->connections[0]->sections[0]->journey->passList[$i]->station->name;
	$arr = zeitNormalform($connection->connections[0]->sections[0]->journey->passList[$i]->arrival);
	$dep = zeitNormalform($connection->connections[0]->sections[0]->journey->passList[$i]->departure);
	if(($arr==$dep) and ($i<count($connection->connections[0]->sections[0]->journey->passList)-1)){$arr="";}
	if($i==count($connection->connections[0]->sections[0]->journey->passList)-1){$dep=""; $arr="<b>$arr</b>";}
	if($i==0){$arr=""; $dep="<b>$dep</b>";}
	echo "<tr onclick='self.location.href=\"board.php?id=$statid\"'class='clic'>";
	echo "<td>".$stat."</td>";
	echo "<td>".$arr."</td>";
	echo "<td>".$dep."</td>";
	echo "</tr>";

} 

echo "</table>";

echo "<div id='header2'><h1 onclick='window.history.back()'>Zur&uuml;ck</h1></div>";

?>

</body></html>