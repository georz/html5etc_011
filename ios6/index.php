<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>iOS 6 Demo (beta)</title>
<meta name='viewport' content='width=device-width, user-scalable=no'>
<link rel="stylesheet" type="text/css" href="colors.css" media="all">
<style>

html {
	width: 320px;
}

h1 {
	margin: 5px;
}

figure {
	margin: 0px;
}

fieldset {
	margin-bottom: 10px;
}

pre {
	overflow: scroll;
}

a {
	color: black;
}

.box {
	display: -webkit-box;
}

.vbox {
	display: -webkit-box;
	-webkit-box-orient: vertical;
	-webkit-box-align: stretch;
}

.boxcenter {
	-webkit-box-pack: center;
}

.center {
	text-align: center;
}

.display_none {
	display: none;
}

.fontSmall {
	font-size: 0.8em;
}

.playAudio, #btnSubmit, #btnSubmit2 {
	font-family: sans-serif;
	font-size: 16px;
}

#playKick, #playSnare, #playHihat {
	width: 70px;
	height: 70px;
	margin: 5px;
	border-radius: 35px;
}

#playRhythm, #btnSubmit, #btnSubmit2 {
	width: 230px;
	height: 50px;
	margin: 5px;
	border-radius: 35px;
}

#score {
	width: 200px;
}

#form2 {
	position: relative;
}

#btnFakeFile {
	position: relative;
	width: 120px;
	z-index: 10;
}

#fileUpload2 {
	position: absolute;
	top: -38px;
	z-index: 1;
}

</style>
</head>
<body>
<h1><a href="<?= $_SERVER['PHP_SELF'] ?>">iOS 6 Demo</a></h1>

<fieldset>
	<!-- http://www.html5rocks.com/en/tutorials/webaudio/intro/ -->
	<legend>Web Audio API</legend>
	<div class="box boxcenter">
		<div id="playKick"  class="playAudio vbox boxcenter center green" data-buffer="0" data-display="Kick">Loading</div>
		<div id="playSnare" class="playAudio vbox boxcenter center orange"   data-buffer="1" data-display="Snare">Loading</div>
		<div id="playHihat" class="playAudio vbox boxcenter center pink"   data-buffer="2" data-display="Hihat">Loading</div>
	</div>
	<figure class="center">
		<img id="score" src="image/drum.png" alt="drumkit">
		<figcaption>A simple rock drum pattern</figcaption>
	</figure>
	<div class="box boxcenter">
		<div id="playRhythm" class="playAudio vbox boxcenter center blue" data-buffer="" data-display="Rhythm">Loading</div>
	</div>
</fieldset>

<fieldset id="fileFieldset">
	<legend>Photo/Video Upload</legend>
	<form id="form" action="./index.php" method="post" enctype="multipart/form-data" class="center">
		<input type="file" id="fileUpload" name="fileUpload"><br>
		<input type="submit" id="btnSubmit" class="blue display_none" value="Submit">
	</form>
</fieldset>

<fieldset id="fileFieldset2" class="display_none">
	<legend>Photo/Video Upload <span class="fontSmall">(CSS custom)</span></legend>
	<div class="center">
		<img id="btnFakeFile" src="image/camera.png" alt="Select upload file.">
	</div>
	<form id="form2" action="./index.php" method="post" enctype="multipart/form-data" class="center">
		<input type="file" id="fileUpload2" name="fileUpload2" class="display_none">
		<input type="submit" id="btnSubmit2" class="blue display_none" value="Submit">
	</form>
</fieldset>
<?php
if ($_FILES) {
?>

<hr>

<pre>
<?php
	print_r($_FILES[key($_FILES)]);
?>
</pre>
<?	
}
?>

<script src="buffer-loader.js"></script>
<script>

var userAgent = navigator.userAgent;

var handleEvent = 'click';
if (userAgent.indexOf('iP') != -1) {
	handleEvent = 'touchstart';
	document.querySelector('#fileFieldset2').classList.remove('display_none');
}

var context;
var bufferLoader;

var playAudio = document.querySelectorAll('.playAudio');

window.onload = init;

document.querySelector('#fileUpload').addEventListener('change', function(){
	document.querySelector('#btnSubmit').classList.remove('display_none');
}, false);

document.querySelector('#btnFakeFile').addEventListener(handleEvent, function(){
	document.querySelector('#fileUpload2').click();
}, false);

document.querySelector('#fileUpload2').addEventListener('change', function(){
	document.querySelector('#btnFakeFile').style.left = '-75px';
	document.querySelector('#fileUpload2').classList.remove('display_none');
	document.querySelector('#btnSubmit2').classList.remove('display_none');
}, false);

function init() {
	try {
		context = new webkitAudioContext();
		bufferLoader = new BufferLoader(
			context,
			[
				'audio/kick.wav',
				'audio/snare.wav',
				'audio/hihat.wav',
				],
				RhythmSample.ready
		);
		bufferLoader.load();
	} catch(e) {
		alert('Web Audio API is not supported in this browser.');
	}
}

function playSound(buffer, time) {
	if (!time) {
		time = 0;
	}
	var source = context.createBufferSource();
	source.buffer = buffer;
	source.connect(context.destination);
	source.noteOn(time);
}

var RhythmSample = {};

RhythmSample.ready = function(bufferList) {
	[].forEach.call(playAudio, function(el) {
		el.addEventListener(handleEvent, function(e){
			var index = el.getAttribute('data-buffer');
			if (index) {
	    		playSound(bufferLoader.bufferList[index]);
	    	} else {
		    	RhythmSample.play(bufferLoader.bufferList);
	    	}
		}, false);
		el.textContent = el.getAttribute('data-display');
	});
};

RhythmSample.play = function(bufferList) {
	var kick  = bufferList[0];
	var snare = bufferList[1];
	var hihat = bufferList[2];
	
	// We'll start playing the rhythm 100 milliseconds from "now"
	var startTime = context.currentTime + 0.100;
	var tempo = 80; // BPM (beats per minute)
	var eighthNoteTime = (60 / tempo) / 2;
	
	// Play 2 bars of the following:
	for (var bar = 0; bar < 2; bar++) {
		var time = startTime + bar * 8 * eighthNoteTime;
		// Play the bass (kick) drum on beats 1, 5
		playSound(kick, time);
		playSound(kick, time + 4 * eighthNoteTime);
	
		// Play the snare drum on beats 3, 7
		playSound(snare, time + 2 * eighthNoteTime);
		playSound(snare, time + 6 * eighthNoteTime);
	
		// Play the hi-hat every eighthh note.
		for (var i = 0; i < 8; ++i) {
			playSound(hihat, time + i * eighthNoteTime);
		}
	}
};

</script>
</body>
</html>