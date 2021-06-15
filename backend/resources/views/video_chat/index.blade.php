<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../_shared/style.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    </head>
    <body style="background: linear-gradient(25deg, #331392, #4557ac, #4494c6, #16d3e0) fixed; color: white;">
        <div class="container">
            <!--p class="note">
                Change Room mode (before join in a room):
                <a href="#">mesh</a> / <a href="#sfu">sfu</a>
            </p-->
            <div style="margin: 5vh 0;">
                <input type="text" placeholder="ルーム名" id="js-room-id" style="height: 3vh; width: 40vw; ">
                    <button id="js-join-trigger">Join</button>
                    <button id="js-leave-trigger">Leave</button>
            </div>
            <div class="room">
                <div>
                    <video id="js-local-stream"></video>
                    <i class="fas fa-microphone fa-2x"></i>
                    <button id="audio-mute">OFF</button>
                    <button id="audio-on">ON</button>

                    <i class="fas fa-desktop fa-2x"></i>
                    <button id="video-mute">OFF</button>
                    <button id="video-on">ON</button>
                    <span id="js-room-mode"  style="visibility:hidden"></span>
                </div>

                <div class="remote-streams" id="js-remote-streams"></div>
                <div>
                    <pre class="messages" id="js-messages"></pre>
                    <input type="hidden" id="js-local-text">
                    <!--button id="js-send-trigger"></button-->
                    <input type="hidden" id="js-send-trigger">
                </div>
            </div>
            <p class="meta" id="js-meta"></p>
        </div>
        <script src="//cdn.webrtc.ecl.ntt.com/skyway-4.4.1.js"></script>
    </body>
</html>




<script>
  const Peer = window.Peer;

(async function main() {
  const localVideo = document.getElementById('js-local-stream');
  const joinTrigger = document.getElementById('js-join-trigger');
  const leaveTrigger = document.getElementById('js-leave-trigger');
  const remoteVideos = document.getElementById('js-remote-streams');
  const roomId = document.getElementById('js-room-id');
  const roomMode = document.getElementById('js-room-mode');
  const localText = document.getElementById('js-local-text');
  const sendTrigger = document.getElementById('js-send-trigger');
  const messages = document.getElementById('js-messages');
  const meta = document.getElementById('js-meta');
  const sdkSrc = document.querySelector('script[src*=skyway]');
  const micMute = document.getElementById('audio-mute');
  const micOn = document.getElementById('audio-on');
  const videoMute = document.getElementById('video-mute');
  const videoOn = document.getElementById('video-on');

  //meta.innerText = `
    //UA: ${navigator.userAgent}
    //SDK: ${sdkSrc ? sdkSrc.src : 'unknown'}
  //`.trim();

  // 同時接続モードがSFUなのかMESHなのかをここで設定
  const getRoomModeByHash = () => (location.hash === '#sfu' ? 'sfu' : 'mesh');
  // divタグに接続モードを挿入
  roomMode.textContent = getRoomModeByHash();
  // 接続モードの変更を感知するリスナーを設置
  window.addEventListener(
    'hashchange',
    () => (roomMode.textContent = getRoomModeByHash())
  );

  // 自分の映像と音声をlocalStreamに代入   ※ getUserMediaというブラウザ標準APIを利用
  const localStream = await navigator.mediaDevices.getUserMedia({
      audio: true,
      video: true,
    })
    .catch(console.error);

  // localStreamをdiv(localVideo)に挿入
  localVideo.muted = true;
  localVideo.srcObject = localStream;
  localVideo.playsInline = true;
  await localVideo.play().catch(console.error);

  // Peerのインスタンス作成
  const peer = (window.peer = new Peer({
    key: '{{ $my_api_key }}',
    debug: 3,
  }));

  //「div(joinTrigger)が押される & 既に接続が始まっていなかったら接続」リスナーを設置
  joinTrigger.addEventListener('click', () => {
    if (!peer.open) {
      return;
    }

    // 部屋に接続するメソッド（joinRoom）
    const room = peer.joinRoom(roomId.value, {
      mode: getRoomModeByHash(),
      stream: localStream,
    });

    // 部屋に接続できた時（open）に一度だけdiv(messages)に'入室しました'を表示
    room.once('open', () => {
      messages.textContent += '入室しました\n';
    });
    // 通話相手が入室してきた時(peerJoin)、いつでもdiv(messages)に下記のテキストを表示
    room.on('peerJoin', peerId => {
      messages.textContent += `=== ${peerId} joined ===\n`;
    });

    // 重要：streamの内容に変更があった時（stream）videoタグを作って流す
    room.on('stream', async stream => {
      const newVideo = document.createElement('video');
      newVideo.srcObject = stream;
      newVideo.playsInline = true;
      // 誰かが退出した時どの人が退出したかわかるように、data-peer-idを付与
      newVideo.setAttribute('data-peer-id', stream.peerId);
      remoteVideos.append(newVideo);
      await newVideo.play().catch(console.error);
    });

    //重要： 誰かがテキストメッセージを送った時、messagesを更新
    room.on('data', ({ data, src }) => {
      messages.textContent += `${src}: ${data}\n`;
    });

    // 誰かが退出した場合、div（remoteVideos）内にある、任意のdata-peer-idがついたvideoタグの内容を空にして削除する
    room.on('peerLeave', peerId => {
      const remoteVideo = remoteVideos.querySelector(
        `[data-peer-id="${peerId}"]`
      );
      // ??
      remoteVideo.srcObject.getTracks().forEach(track => track.stop());
      remoteVideo.srcObject = null;
      remoteVideo.remove();

      messages.textContent += `=== ${peerId} left ===\n`;
    });

    // 自分が退出した場合の処理
    room.once('close', () => {
      // メッセージ送信ボタンを押せなくする
      sendTrigger.removeEventListener('click', onClickSend);
      // messagesに下記のテキストを表示
      messages.textContent += '退出しました';
      Array.from(remoteVideos.children).forEach(remoteVideo => {
        remoteVideo.srcObject.getTracks().forEach(track => track.stop());
        remoteVideo.srcObject = null;
        remoteVideo.remove();
      });
    });

    // ボタン(sendTrigger)を押すとonClickSendを発動
    sendTrigger.addEventListener('click', onClickSend);
    // ボタン(leaveTrigger)を押すとroom.close()を発動
    leaveTrigger.addEventListener('click', () => room.close(), { once: true });

    // テキストメッセージを送る処理
    function onClickSend() {
      room.send(localText.value);
      messages.textContent += `${peer.id}: ${localText.value}\n`;
      localText.value = '';
    }

    // 画面オフ
    videoMute.addEventListener('click', () => {
      localStream.getVideoTracks().forEach((track) => (track.enabled = false));
      //var videoTrack = localStream.getVideoTracks()[0];
      //videoTrack.enabled = false
      console.log('video-OFF')
    });
    
    // 画面オン
    videoOn.addEventListener('click', () => {
      localStream.getVideoTracks().forEach((track) => (track.enabled = true));
      console.log('video-ON')
    });
    
    // マイクオフ
    micMute.addEventListener('click', () => {
      localStream.getAudioTracks().forEach((track) => (track.enabled = false));
      console.log('mic-OFF')
    });

    // マイクオン
    micOn.addEventListener('click', () => {
      localStream.getAudioTracks().forEach((track) => (track.enabled = true));
      console.log('mic-ONN')
    });
  });

  peer.on('error', console.error);
})();
</script>

