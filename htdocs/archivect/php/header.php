
<!-- >web design by Eireni Moutoussi</!-->
<!DOCTYPE html>
<html lang="en-GB">
<head>
<?php 
global $pos;
include($pos.'./php/public_functions.php');

echo '
<script type="text/javascript" src="'.$pos.'./js/jquery-4.0.0.min.js"></script>
<script type="text/javascript" src="'.$pos.'./js/archivect.js"></script>

	<title>archivect - architectural archive</title>
	<link rel="stylesheet" type="text/css" href="'.$pos.'./css/archivect.css"/>
	<link rel="stylesheet" type="text/css" href="'.$pos.'./css/lightmode.css"/>
	<script src="'.$pos.'./js/php.js"></script>

<style></style>
'
?>
</head>

<body class='lightmode'>

<button id='mode'></button>
<div id="header">
	<h1>Archivect<sup class="info">.beta</sup>
		<div class="infobox">
			<p>I'm working on it. It's only a personal project and I'm doing it slowly, for fun. Head to the about page to see some goals.</p>
			<p>Disclaimer: lots of this info may be inaccurate as it's just what I've found manually. There will be guaranteed gaps.</p>
		</div>
	</h1>
	<button id='m'>Menu</button>
	<div id="nav">
<?php
	global $pos;
	echo '
		<ul>
		<a href="'.$pos.'./"><li>Search</li></a>
		<a href="'.$pos.'./resources"><li>Resources</li></a>
		<a href="#"><li><s title="under construction">Diary</s></li></a>
		<a href="'.$pos.'./about"><li>about</li></a>
		<a href="https://www.linkedin.com/in/eireni-m/" title="Sorry until I set up an email for this project send me a request with a note or something. Or just duck-duck-go my name"><li>LinkedIn</li></a>
		</ul>
	<div id="footer">
	Enjoy this page? please get some <a href="'.$pos.'./soapboxes#sleep">sleep</a>, join a <a href="'.$pos.'./soapboxes#union">union</a> and maybe buy me a <a href="kofee">coffee</a>. Thanks!		'
?>
	
	<button class='info'>COOKIES?</button>
	<div class='infobox'><p>I'm not currently storing any cookies or other data. But the free host I'm using, Infinityfree, collects a few cookies. Sorry. If I upgrade m host I'll see if I can get something else. All data used by the site is just for retrieval and is not logged anywhere. This is partly because I can't stand the fact that sites track you everywhere and partly because I'd have to do a <i>lot</i> of work learning more about security before I was happy to do so.</p><p> I will update this when I've set up a Submissions page as that'll require some degree of basic logins.</p></div>
	</div></div>
	<span id='menupad'></span>

	
</div>
<div class='content'>
