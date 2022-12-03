<?php 

if(!isset($_GET['device_id'])){ ?>
<script>
    var device_id = window.localStorage.getItem('device_id');
    window.location.href = window.location.href + "?device_id=" + device_id+'&trackId='+<?php echo '"'.$_POST['trackId'].'"';?>;
</script>    
<?php
}

session_start();
$_SESSION["device_id"] = $_GET['device_id'];
$device_id = $_SESSION["device_id"];
$uris = "spotify:track:".$_GET['trackId'];
$url = "https://api.spotify.com/v1/me/player/queue?uri=".urlencode($uris)."&device_id=".$device_id;
$accessToken = $_SESSION["spotify_token"]->access_token;

$ch = curl_init();
$header = array();
$header[] = 'Accept: application/json';
$header[] = 'Content-type: application/json';
$header[] = 'Authorization: Bearer '.$accessToken;
$post = [
    'uri' => urlencode($uris),
    'device_id' => $device_id,
];

//die;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

$data = curl_exec($ch);

$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);
if($httpcode>=200 && $httpcode<300){
	header("Location: search.php");
}else{
	echo "EROROR".$httpcode;
}

?>  