
<!-- >web design by Eireni Moutoussi</!-->
<!DOCTYPE html>
<html lang="en-GB">
<head>
<?php include('./php/public_functions.php');?>
<?php

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

<body>

<div id="header">
	<h1 class="boxed">Archivect<sup class="info">.beta</sup>
	<div class="infobox">
		<p>I'm working on it. It's only a personal project and I'm doing it slowly, for fun. Head to the about page to see some goals.</p>
		<p>Disclaimer: lots of this info may be inaccurate as it's just what I've found manually. There will be guaranteed gaps.</p>
	</div>
</h1>

<div id="nav" >
	<button>Menu</button>
	<ul class="boxed">
		<?php

echo '
	<li><a href="'.$pos.'./">Search</a></li>
	<li><a href="#"><s title="under construction">Sumbit</s></a></li>
	<li><a href="#"><s title="under construction">Resources</s></a></li>
	<li><a href="#"><s title="under construction">Diary</s></a></li>
	<li><a href="'.$pos.'./about">about</a></li>
	</ul>
	'
?>
</div>
</div>
