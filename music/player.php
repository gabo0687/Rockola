<script src="https://sdk.scdn.co/spotify-player.js"></script>
<script>
window.onSpotifyWebPlaybackSDKReady = () => {
   const token = 'BQCsqw6o4ftyeOFFeSgCFd1GdfyNgO940oVGEpbqZqYKXs_yDvt_tVxkYevOU-FB55lkxR_VAoe6x627rBIN5k7-hYoiQZBzZx4AvQcjU0pFlukpKcw6JBDxvymFYifvRtNQr6V-Do0oGS9o9ln0d2He00sE381-dWOiuf4SDRPe-JPP_mMTNAg';
   const player = new Spotify.Player({
     name: 'Web Playback SDK Quick Start Player',
     getOAuthToken: cb => { cb(token); }
   });
 }
</script>