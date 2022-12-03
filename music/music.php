<?php
var_dump($_SESSION);
die;
// Create a curl handle
$Search = $_POST['search'];
$url = "https://api.spotify.com/v1/search?q=".urlencode($Search)."&type=track";

$ch = curl_init();
$header = array();
$header[] = 'Content-length: 0';
$header[] = 'Content-type: application/json';
$header[] = 'Authorization: Bearer BQCAaZhn914rfJ3XZ8rMB2G1nAuXGcbqZzORLXScVU8pfFpusQKPbXH4DctEazJp6yQ6lYXzvoKCJqjCZlX5tAugCsevsPqvejdrGNGoqtJ60u2usYLxulvsbNA4lGyBZgeIADodojsDbY624Jx3PzsphVnLDUPLELOmfU5PCxja885CqzuRR0M';

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
$data = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
echo '<pre>';
$array = (array)json_decode($data, true);
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
        <form action="addTrack.php" method="post">
       
      
         
<?php
//echo ($httpcode>=200 && $httpcode<300) ? $data : false;
foreach( $array["tracks"]["items"] as $track ){ ?>
 <tr>
            <td>
                 <div class="radio">
                      <label><input type="radio" name="trackId" id="trackId" value="<?php echo $track["id"];?>" /></label>
                 </div>
            </td>
            <td>
                  <img src="<?php echo $track["album"]["images"][1]['url'];?>" />
	
            </td>
			<td>
                
	<label><?php echo $track["name"];?></label>
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