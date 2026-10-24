
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
	<h1>Archivect<sub class="info">.beta</sub>
	<div class="infobox">I'm working on it. It's only a personal project. I'm not using any AI cause I dun wanna, I'm having fun, slowly. Head to the about page to see some goals.</div>
</h1>

<div id="nav">
	<button>Menu</button>
	<ul>
		<?php

echo '
	<li><a href="'.$pos.'./">Search</a></li>
	<li><a href="'.$pos.'./projects"><s title="under construction">wiki</s></a></li>
	<li><a href="'.$pos.'./calendar"><s title="under construction">diary</s></a></li>
	<li><a href="'.$pos.'./digital"><s title="under construction">digital</s></a></li>
	<li><a href="'.$pos.'./about">about</a></li>
	</ul>
	'
?>
</div>
</div>
