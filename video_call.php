<?php
session_start();
if(!isset($_SESSION['user_id'])) { header('Location: login.php'); exit(); }
$partner_id = isset($_GET['partner_id']) ? intval($_GET['partner_id']) : 0;
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Videochamada</title>
<style>
video { width: 45%; border: 1px solid #ccc; border-radius: 8px; margin: 5px; }
body { display: flex; flex-direction: row; justify-content: center; align-items: center; height: 100vh; }
</style>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
<video id="localVideo" autoplay muted></video>
<video id="remoteVideo" autoplay></video>

<script>
let localVideo = document.getElementById('localVideo');
let remoteVideo = document.getElementById('remoteVideo');
let localStream, pc;

navigator.mediaDevices.getUserMedia({video:true,audio:true})
.then(stream => {
    localVideo.srcObject = stream;
    localStream = stream;
    startCall();
}).catch(err => console.error(err));

function startCall() {
    pc = new RTCPeerConnection();

    // Adiciona a stream local ao peer connection
    localStream.getTracks().forEach(track => pc.addTrack(track, localStream));

    // Quando o parceiro enviar stream remota
    pc.ontrack = e => { remoteVideo.srcObject = e.streams[0]; };

    // ICE candidates
    pc.onicecandidate = e => {
        if(e.candidate) {
            $.post('signaling.php', {
                sender_id: <?=$user_id?>,
                receiver_id: <?=$partner_id?>,
                type: 'candidate',
                data: JSON.stringify(e.candidate)
            });
        }
    };

    // Cria offer
    pc.createOffer().then(offer => {
        pc.setLocalDescription(offer);
        $.post('signaling.php', {
            sender_id: <?=$user_id?>,
            receiver_id: <?=$partner_id?>,
            type: 'offer',
            data: JSON.stringify(offer)
        });
    });

    // Polling para receber signaling do parceiro
    setInterval(checkSignaling, 2000);
}

function checkSignaling() {
    $.post('get_signaling.php', {
        user_id: <?=$user_id?>,
        partner_id: <?=$partner_id?>
    }, function(res) {
        res = JSON.parse(res);
        res.forEach(msg => {
            if(msg.type === 'offer' && !pc.currentRemoteDescription) {
                pc.setRemoteDescription(new RTCSessionDescription(JSON.parse(msg.data)))
                  .then(() => pc.createAnswer())
                  .then(answer => pc.setLocalDescription(answer))
                  .then(() => {
                      $.post('signaling.php', {
                          sender_id: <?=$user_id?>,
                          receiver_id: <?=$partner_id?>,
                          type: 'answer',
                          data: JSON.stringify(pc.localDescription)
                      });
                  });
            } else if(msg.type === 'answer') {
                pc.setRemoteDescription(new RTCSessionDescription(JSON.parse(msg.data)));
            } else if(msg.type === 'candidate') {
                pc.addIceCandidate(new RTCIceCandidate(JSON.parse(msg.data)));
            }
        });
    });
}
</script>
</body>
</html>

