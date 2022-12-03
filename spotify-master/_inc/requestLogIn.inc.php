<?php

// Include required files
//require '../_private/global.inc.php';
require 'curl.class.php';
 session_start();

 $__app_client_id = $_SESSION['client_id'];
 $__redirect_uri = 'http://localhost/rockola/spotify-master/_inc/requestLogIn.inc.php';
 $__app_secret = $_SESSION['secret_id'];
 $__base_url = 'https://accounts.spotify.com';
 $__app_url = 'http://localhost/rockola/spotify-master/index.php';
// Start new instance of CurlServer object
$__cURL = new CurlServer();

// Set URL for request to obtain the user token
$url = $__base_url . '/api/token';

// Set required Post fields to send to Spotify
$submit_post_fields = 'grant_type=authorization_code&code=' . $_GET['code'];
$submit_post_fields .= "&redirect_uri=$__redirect_uri";

// Application access token needs to be Base64 Encoded
// The content of it will be = Client ID:Client Secret
$access_token = "Basic " . base64_encode("$__app_client_id:$__app_secret");

// Start cURL Post request to obtain user tokens
$used_token_data = $__cURL->post_request($url, $submit_post_fields, $access_token);

// Debug 
// echo '<pre>';
// print_r($used_token_data);
// echo '</pre>';

// Store user token in Session

// server should keep session data for AT LEAST 1 hour
ini_set('session.gc_maxlifetime', 36000);

// each client should remember their session id for EXACTLY 1 hour
session_set_cookie_params(36000); 
session_start();
$_SESSION['spotify_token'] = $used_token_data;

header("Location: $__app_url");