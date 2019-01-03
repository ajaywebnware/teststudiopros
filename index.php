<?php
	$zip = new ZipArchive;
	$res = $zip->open('sourcezip/backup source.zip');
	if ($res === TRUE) {
	  $zip->extractTo('source/');
	  $zip->close();
	  //echo 'woot!';
	}


	header('Location:process.php');
	exit();

//////////////////////////////////////////////////////////////////////////////////////////////////////


	//AAAAAAAAAAAAAAAAAAAAAAAAAA

	//AAAAAAAAAAAAAAAABBBBBBBBBBBBBBBBBBBBBBBBBCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDD

?>
