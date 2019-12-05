<?php

include ('config/database.php');

// cheking for errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// $newemail = $_SESSION['mail'];
// echo $newemail;

/*
// using datetime for image naming
$filename = time() . 'jpg';
$filepath = 'webcam/';

move_uploaded_file($_FILES['webcam']['tmp_name'], $filepath.$filename);

echo $filepath.$filepath;
*/




?>
<!DOCTYPE  html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="">
        <meta name="viewport" content="width=device-width, initial-scale">

        <meta name="description" content="">

        <title></title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    
    <body>
      <div >  
        <div class="camera">
            <video id="video" width="400" heigth="300" ></video>
        </div>
            <img src="stickers/512fx512f.png" id="stick" width="400" heigth="300">
            <button id="stickbtn" onclick="">Add Sticker</button>
        
            <img src="stickers/images (5).jpeg" id="stick2" width="400" heigth="300">
            <button id="stickbtn2" onclick="">Add Sticker2</button>

            <img src="stickers/images (6).jpeg" id="stick3" width="400" heigth="300">
            <button id="stickbtn3" onclick="">Add Sticker3</button>

            <img src="stickers/t-shirt-sunglasses-thug-life-t-shirt.jpg" id="stick4" width="400" heigth="300">
            <button id="stickbtn4" onclick="">Add Sticker4</button>
        <div>
        </div>

            <br/>
        <div> 
            <input id="capture" type="submit" name="camera-button" value="Take Photo"/>
            <!--  <a href="#" id="capture" class="camera-button"> Take photo </a> -->        
        </div>
            <br>
        <div>
            <canvas id="canvas" class="canvas-container"> 
            </canvas>
        </div>
    <div>

<div>
        <form method="post" action="saveimage.php" >
            <div>
                <input id="webimage" name="savedata" type="">
                <br/>
                <input id="save" type="submit" name="save-button" value="Save"/>
            </div>
        </form>
</div>

    </body>
    <script>
        (function() {
        var video = document.getElementById('video'),
            canvas = document.getElementById('canvas'),
            context = canvas.getContext('2d'),
            photo = document.getElementById('photo'),
            image = document.getElementById('image'),
            videoUrl = window.URL || window.webwebkitURL;
        


        navigator.getMedia =    navigator.getUserMedia ||
                                navigator.webkitGetUserMedia ||
                                navigator.mozGetUserMedia ||
                                navigator.msGetUserMedia;

        navigator.getMedia({
            image: true,
            video: true,
            audio: false
        }, function(stream) {
            video.srcObject = stream;
            video.play();
        }, function(error) {
            // An error occured
            // error.code
        });

        document.getElementById('capture').addEventListener('click', function() {
            context.drawImage(video, 0, 0, 300, 200);

            //photo.setAttribute('src', canvas.toDataURL('image/png'));

        document.getElementById('stickbtn').addEventListener('click', function() {
            context.drawImage(document.getElementById('stick'), 0, 0, 100, 50);
        })

        document.getElementById('stickbtn2').addEventListener('click', function() {
            context.drawImage(document.getElementById('stick2'), 0, 0, 150, 100);
        })

        document.getElementById('stickbtn3').addEventListener('click', function() {
            context.drawImage(document.getElementById('stick3'), 0, 0, 150, 100);
        })

        document.getElementById('stickbtn4').addEventListener('click', function() {
            context.drawImage(document.getElementById('stick4'), 0, 0, 150, 100);
        })

        });


        })();

        document.getElementById('save').addEventListener('click', function() {

        document.getElementById('webimage').value = canvas.toDataURL('image/png');

});

    </script>
    </html>
