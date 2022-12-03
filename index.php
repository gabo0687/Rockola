
<form action="" method="post">
<label>Search Song</label>
<input name="search" id="seach" value="" type="text" />
<input value="Search" type="submit">

</form>

<?php
//Token
function accessToken(){
	$client_id = "e8892ac2628746728f99fe12091ad3c5";
	$client_secret = "4e603bafe26c4ffc911a8fa258e600c2";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://accounts.spotify.com/api/token');
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
	  'Content-Type: application/x-www-form-urlencoded',
	  'Authorization: Basic ' . base64_encode($client_id.':'.$client_secret)
	]);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
	  'grant_type' => 'client_credentials'
	]));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = json_decode(curl_exec($ch), true);
	curl_close($ch);
	saveToken($result["access_token"],$result["token_type"],$client_id,$client_secret); 
	return $result;
}


$token = accessToken();
$accesToken = $token["access_token"];

$url = 'https://api.spotify.com/v1/playlists/5hndl8wCW65hxLz9e8OAC2';

$ch = curl_init();
$header = array();
$header[] = 'Content-length: 0';
$header[] = 'Content-type: application/json';
$header[] = 'Authorization: Bearer '.$accesToken;

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
$data = curl_exec($ch);

$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

$array = (array)json_decode($data, true);

$infoToken = getToken();
if( $infoToken == '0' ){
	$Token = accessToken();
	$accessToken = $Token["token_type"].' '.$Token["access_token"];
}else{
	$date = new DateTime();
    $currenTimeStamp = $date->getTimestamp();
	if( $currenTimeStamp >= $infoToken['expire']){
		$Token = accessToken();
		$accessToken = $Token["token_type"].' '.$Token["access_token"];
	}else{
		$accessToken = $infoToken["token_type"].' '.$infoToken["access_token"];
	}
	
}
?>
<table class="table table-responsive">
    <thead>
        <tr>
            <th></th>
            <th>image</th>
			
            <th>Name</th>
        </tr>
     </thead>
     <tbody>
        <form action="music/addTrack.php" method="post">
       
      <input type="hidden" name="accessToken" id="accessToken" value="<?php echo $accessToken;?>" />
         
<?php

foreach( $array["tracks"]["items"] as $track ){
    
    $shareLink  = $track["track"]["external_urls"]["spotify"];
    $trackId    = $track["track"]["id"];
    $trackImage = $track["track"]['album']["images"][2]['url'];
    $trackName  = $track["track"]["name"];
    ?>
<tr>
    <td>
            <div class="radio">
                <label><input type="radio" name="trackId" id="trackId" value="<?php echo $trackId;?>" /></label>
            </div>
    </td>
    <td>
            <img src="<?php echo $trackImage;?>" />

    </td>
    <td>
                
	<label><?php echo $trackName;?></label>
            </td>
         </tr>
	
    <?php
}

?>

<tr>
<td>
<input value="Add track" type="submit">
</td>
</tr>
</form>
     </tbody>
 </table>
 <?php

function saveToken($accessToken,$tokenType,$clientId,$clientSecret){
	$conn = connect();
	// Check connection
	if (!$conn) {
	  die("Connection failed: " . mysqli_connect_error());
	}
	$date = new DateTime();
	$currentTimeStamp =  $date->getTimestamp(). "<br>";
	$date->add(new DateInterval('PT3600S')); // adds 674165 secs
	$newTimeStamp= $date->getTimestamp();
	
	$sql = "INSERT INTO tokens (access_token, token_type, expire,client_id,client_secret)
			VALUES ('".$accessToken."', '".$tokenType."', ".$newTimeStamp.", '".$clientId."', '".$clientSecret."')";

			if ($conn->query($sql) === TRUE) {
			  return 1;
			} else {
				return 0;
			  //echo "Error: " . $sql . "<br>" . $conn->error;
			}
}
function getToken(){
	
	$conn = connect();
	// Check connection
	if (!$conn) {
	  die("Connection failed: " . mysqli_connect_error());
	}
	$sql = "SELECT access_token, expire, client_id,client_secret,token_type FROM tokens";
	$result = mysqli_query($conn,$sql);

	if (mysqli_num_rows($result) > 0) {
	  // output data of each row
	  return mysqli_fetch_assoc($result);
	} else {
	  return "0";
	}
}
	function connect(){
		$servername = "localhost";
		$username = "root";
		$password = "";

		$dbname = "eibyz";

		// Create connection
		$conn = mysqli_connect($servername, $username, $password, $dbname);
		return $conn;
	}
 ?>


