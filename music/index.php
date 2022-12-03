
<!DOCTYPE html>
<html>
<head>
    <title>Spotify Web Playback SDK Quick Start</title>
</head>
<body>
    <h1>Spotify Web Playback SDK Quick Start</h1>
    <button id="togglePlay">Toggle Play</button>

    <script src="https://sdk.scdn.co/spotify-player.js"></script>
    <script>
        window.onSpotifyWebPlaybackSDKReady = () => {
            const token = 'BQCbvljuLISLTbvqIsLEakmPGEV24VMX_eu5vqUSAEypNFllkSKmkDrUL0LAXBPxpfI5QObGWCgZ78HxMU35vStMiQadONUgvsj1QC5h2R3VEcEmSvc-4VEACKU572NTyha3hYOnD3M2zRCNGsBw_ISLpbsn9RtZKlNA_-lsiy4MqSRAZ0StB5-GSIu9K8qKxzX5id_uDCTIQFaG5finyIs';
            const player = new Spotify.Player({
                name: 'Web Playback SDK Quick Start Player',
                getOAuthToken: cb => { cb(token); },
                volume: 0.5
            });

            // Ready
            player.addListener('ready', ({ device_id }) => {
                console.log('Ready with Device ID', device_id);
            });

            // Not Ready
            player.addListener('not_ready', ({ device_id }) => {
                console.log('Device ID has gone offline', device_id);
            });

            player.addListener('initialization_error', ({ message }) => {
                console.error(message);
            });

            player.addListener('authentication_error', ({ message }) => {
                console.error(message);
            });

            player.addListener('account_error', ({ message }) => {
                console.error(message);
            });

            document.getElementById('togglePlay').onclick = function() {
              player.togglePlay();
            };

            player.connect();
        }
    </script>
</body>
</html>
