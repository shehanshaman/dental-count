<!DOCTYPE html>
<html>
<body>

<audio id="myAudio1">
  <source src="sound/1.wav" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>

<audio id="myAudio2">
  <source src="sound/2.wav" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>

<p>Click the buttons to play or pause the audio.</p>

<button onclick="playAudio()" type="button">Play Audio</button>
<button onclick="pauseAudio()" type="button">Pause Audio</button> 

<script>
var x = document.getElementById("myAudio2"); 
var y = document.getElementById("myAudio"); 

window.onload = function playAudio() { 
    x.play(); 
} 
setTimeout(function () {
  //do something once
   y.play();
}, 1000);

function pauseAudio() { 
    x.pause(); 
} 
</script>

</body>
</html>