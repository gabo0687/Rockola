<?php
include 'html/header.inc.php';

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
<div class="container" id="home_container">
    <p><img src="../images/logo.png" alt="Music Utopia Logo"></p>
    <p><button onclick="userLogInRequest();">Log In User</button></p>
</div>
<?php
    $placeId = base64_decode(base64_decode($_GET['place']));
    $conn = connect();
    $sql = "SELECT client_id,client_secret,id FROM places where id=".$placeId;
	$result = mysqli_query($conn,$sql);

	if (mysqli_num_rows($result) > 0) {
	  // output data of each row
	  $data = mysqli_fetch_assoc($result);
	} else {
	  return "0";
	}
 ?>
 <script>
   localStorage.setItem("placeId", "<?php echo $_GET['place']; ?>");
</script>
 <?php 
 $__app_client_id = $data['client_id'];
 $__redirect_uri = 'http://localhost/rockola/spotify-master/_inc/requestLogIn.inc.php';
 session_start();
 $_SESSION['client_id'] = $data['client_id'];
 $_SESSION['secret_id'] = $data['client_secret'];
 $_SESSION['place_id'] = $data['id'];
?>

<script>
    // User log in request on button click
   
     const userLogInRequest = () => {
        let logInUri = 'https://accounts.spotify.com/authorize' +
            '?client_id=<?php echo $__app_client_id; ?>' +
            '&response_type=code' +
            '&redirect_uri=<?php echo $__redirect_uri; ?>' +
            '&scope=app-remote-control user-top-read user-read-currently-playing user-read-recently-played streaming app-remote-control user-read-playback-state user-modify-playback-state' +
            '&show_dialog=true';
        // Debug
        //console.log(logInUri);
        
        // Open URL to request user log in from Spotify
        window.open(logInUri, '_self');
    }
</script>
<?php
// Include page footer
include 'html/footer.inc.php';
