<?

function zeitNormalform($time){
$str = strtotime($time);
return date("H:i", $str);
}


//Funktionen

function zeitDifferenz($time)
{


$now = date("Y-m-d", time())."T".date("H:i:s", time())."+".date("Z", time())/3600;

// convert to unix timestamps
$firstTime=strtotime($now);
$lastTime=strtotime($time);

// perform subtraction to get the difference (in seconds) between times
$timeDiff=($lastTime-$firstTime)/60;
$timeDiff = $timeDiff+1;

if($timeDiff<=1){

	$dauer = round(($timeDiff*60),0)."s";

} elseif ($timeDiff<5 and $timeDiff>1){

	$dauer = "".round($timeDiff,0)."min";

}else {

	/*$stunden = floor($timeDiff/60);
	$minuten = $timeDiff-$stunden*60;
	$dauer = $stunden."h ".$minuten."min";*/
	$dauer = zeitNormalform($time);

}

// return the difference
return $dauer;

}

// Icon
function getIcon($typ){
if(strtolower($typ)=="bus"){$icon="i/bus.png";}
elseif(strtolower($typ)=="tro"){$icon="i/bus.png";}
elseif(strtolower($typ)=="tram"){$icon="i/tram.png";}
else{$icon="i/train.png";}
return $icon;
}


//Farbe bestimmen
function getColor($operator, $number, $category, $cat){
switch($operator){
		
	case "VBSG":
		
		switch($number){
			case "1": return "#FFDD03"; break;
			case "2": return "#D1945E"; break;
			case "3": return "#D0031C"; break;
			case "4": return "#E96FA3"; break;
			case "5": return "#1292CD"; break;
			case "6": return "#A54C93"; break;
			case "7": return "#97BF12"; break;
			case "8": return "#7190A2"; break;
			case "9": return "#EE8028"; break;
			case "10": return "#B3A734"; break;
			case "11": return "#B1A0C9"; break;
			case "12": return "#15A484"; break;
			default: return "#999999"; break;
		
		}			
		
		break;
	
	case "VBZ":
	case "VBZ    F":
		
		switch($number){
			case "2": return "#D8232A"; break;
			case "3": return "#009F4A"; break;
			case "4": return "#3E4085"; break;
			case "5": return "#855B37"; break;
			case "6": return "#DA9F4F"; break;
			case "7": return "#191919"; break;
			case "8": return "#86CD16"; break;
			case "9": return "#3E4085"; break;
			case "10": return "#DA3987"; break;
			case "11": return "#009F4A"; break;
			case "12": return "#7ACAD4"; break;
			case "13": return "#FBD01F"; break;
			case "14": return "#00A4DB"; break;
			case "15": return "#D8232A"; break;
			case "17": return "#CD6090"; break;
			case "S18": return "#D8232A"; break;
			case "31": return "#98A2D1"; break;
			case "31": return "#D6ADD6"; break;
			case "33": return "#E4E19E"; break;
			case "43": return "#000000"; break;
			case "46": return "#B9D8A3"; break;
			case "72": return "#D9AB9F"; break;
			default: return "#999999"; break;
			
		}
		
		break;
		
	case "SBW": // Stadtbus Winterthur
		
		switch($number){
			case "1": return "#000000"; break;
			case "2": return "#E80019"; break;
			case "3": return "#00A548"; break;
			case "4": return "#FEB83F"; break;
			case "5": return "#006AAE"; break;
			case "7": return "#32959E"; break;
			case "8": return "#86CD16"; break;
			case "9": return "#E37C00"; break;
			case "10": return "#133A95"; break;
			case "11": return "#E32E8D"; break;
			case "12": return "#82602E"; break;
			case "14": return "#F8E155"; break;
			default: return "#999999"; break;
			
		}
		
		break;
		
	case "Postauto":
		
		return "#fc0";
		
		break;
		
	default:
	
		break;	
}

switch($cat){
	case "Bus": return "#00ccff"; break;
	case "S-Bahn": return "#003399"; break;
	case "Regio": return "#003399"; break;
	case "Interregio": return "#ff0000"; break;
	case "Intercity": return "#ff0000"; break;
	case "Eurocity": return "#ff0000"; break;
	case "Regioexpress": return "#ff0000"; break;
	case "Postauto": return "#ffbb00"; break;
	case "Luftseilbahn": return "#999999"; break;
	case "Seilbahn": return "#999999"; break;
	case "Tram": return "#666666"; break;
	case "Metro": return "#666666"; break;
	case "Schiff": return "#0088ff"; break;
	case "Bus": return "#00ccff"; break;
	case "Bus": return "#00ccff"; break;
	default: return "#999999"; break;

}

switch($category){
			case "IR": return "#ff0000"; break;
			case "Tram": return "#0066cc"; break;
			case "Tro": return "#0099cc"; break;
			case "Bus": return "#00ccff"; break;
			case "BUS": return "#00ccff"; break;
			case ($category[0]=="S"): return "#003399"; break;
			case (substr($category,0,2)==="SN"): return "#000000"; break;
			default: return "#00ccff"; break;
		}

}


function get_stationid($name) {

$url = "http://transport.opendata.ch/v1/locations?query=".urlencode($name);
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: transport.opendata.ch'));
$value = curl_exec($ch);
curl_close($ch);

$station = json_decode($value);

//var_dump($connection);
 return $station->stations[0]->id;




}


function calculate_distance ($lat_a, $lon_a, $lat_b, $lon_b) {

          $delta_lat = $lat_b - $lat_a ;
          $delta_lon = $lon_b - $lon_a ;

          $earth_radius = 6372795.477598;

          $alpha    = $delta_lat/2;
          $beta     = $delta_lon/2;
          $a        = sin(deg2rad($alpha)) * sin(deg2rad($alpha)) + cos(deg2rad($lat_a)) * cos(deg2rad($lat_b)) * sin(deg2rad($beta)) * sin(deg2rad($beta)) ;
          $c        = asin(min(1, sqrt($a)));
          $distance = 2*$earth_radius * $c;
          $distance = round($distance, 0);

          return $distance;

}

?>