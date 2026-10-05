<?php
$pos ='.';
//sudo /opt/lampp/manager-linux-x64.run
include('../php/header.php');


?>

<?php


include('../php/public_functions.php');
echo "<script src='../js/inputs.js'></script>";

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$precs = 64;
$offset = ($page-1) * $precs; 

echo $offset;

$pageSQL = "SELECT * FROM ".$primaryTable;
	$pagequery = $conn->query($pageSQL);
	$pages = ceil($pagequery->num_rows / $precs);

echo $pages;
?>
<ul class="pagination">
    <li><a href="?page=1">First</a></li>
    <li class="<?php if($page <= 1){ echo 'disabled'; } ?>">
        <a href="<?php if($page <= 1){ echo '#'; } else { echo "?page=".($page - 1); } ?>">Prev</a>
    </li>
    <li><?php echo $page; ?> <li>
    <li class="<?php if($page >= $pages){ echo 'disabled'; } ?>">
        <a href="<?php if($page >= $pages){ echo '#'; } else { echo "?page=".($page + 1); } ?>">Next</a>
    </li>
    <li><a href="?page=<?php echo $pages; ?>">Last</a></li>
</ul>
<?php
$limits = "LIMIT $offset,$precs";
Companydeets('',$limits);
?>

<?php
include('../php/footer.php');
?>
