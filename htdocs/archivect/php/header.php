
<!-- >web design by Eireni Moutoussi</!-->
<!DOCTYPE html>
<html lang="en-GB">
<head>
<?php 
global $pos, $title;
include($pos.'./php/public_functions.php');

echo '
<script type="text/javascript" src="'.$pos.'./js/jquery-4.0.0.min.js"></script>
<script type="text/javascript" src="'.$pos.'./js/archivect.js"></script>

	<title>archivect - architectural archive</title>
	<link rel="stylesheet" type="text/css" href="'.$pos.'./css/archivect.css"/>
	<script src="'.$pos.'./js/php.js"></script>

<style></style>
'
?>
</head>

<body class='lightmode'>

<button id='mode' class='col'></button>
<div id="header">
	<h1>Archivect<sup class="info">.beta</sup>
		<div class="infobox">
			<p>I'm working on it. It's only a personal project and I'm doing it slowly, for fun. Head to the about page to see some goals.</p>
			<p>Disclaimer: this is not a list of every practice in the country (yet) and lots of this info may be inaccurate as it's just what I've found manually. There will be guaranteed gaps.</p>
		</div>
	</h1>
	<button id='m'>Menu</button>
	<div id="nav">
<?php
	global $pos, $title;
	echo '
		<ul>
		<a href="'.$pos.'./"><li>Search</li></a>
		<a href="'.$pos.'./resources"><li>Resources</li></a>
		<a href="#"><li><s title="under construction">Diary</s></li></a>
		</ul>
		
		<ul>
			<a href="'.$pos.'./soapboxes"><li>Client: Students<p>Please go to sleep and join a union. Im beggin</p></li></a>
			<a href="kofee"><li>Author: Eireni M<p>If you liked this, maybe get me a coffee?</p></li></a>
		</ul>
		<a href="'.$pos.'./about"><ul>
			<li>nts @ screen size</li>
			<li>Drawing: '.$title.'</li>
			<li>Date: 20/11/2026</li>
			<li>Project: Archivect</li>
		</ul></a>'
?>
		<ul>
			<li class='col'>Colour</li>
			<li class='info'>Cookies</li>
	<div class='infobox'><p>I'm not currently storing any cookies or other data. But the free host I'm using, Infinityfree, collects a few cookies. Sorry. If it throws a fit because you've 'disabled cookies' just refresh the page, it does that sometimes. If I upgrade the host I'll see if I can get something else. </p><p>All data used by the site is just for retrieval and is not logged anywhere. This is partly because I can't stand the fact that sites track you everywhere and partly because I'd have to do a <i>lot</i> of work learning more about security before I was happy to do so.</p><p> I will update this when I've set up a Submissions page as that'll require some degree of basic logins.</p></div>

		</ul>
		<h1></h1>
	</div>

	<span id='menupad'></span>
</div>
<div class='content'>
