<?php 
	 $folder = $_SERVER['DOCUMENT_ROOT'] . '/newwabhub/results/';
	 $folder2 = $_SERVER['DOCUMENT_ROOT'] . '/newwabhub/done/';
	
	$zip_file = $_SERVER['DOCUMENT_ROOT'] . '/newwabhub/downloads/results'.time().'.zip';
	
//////////////////////////////////////////////////////////////////////////////////////////////////////
	$rootPath = realpath($folder);

		// Initialize archive object
		$zip = new ZipArchive();
		$zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

		// Create recursive directory iterator
		/** @var SplFileInfo[] $files */
		$files = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($rootPath),
			RecursiveIteratorIterator::LEAVES_ONLY
		);

		foreach ($files as $name => $file)
		{
			// Skip directories (they would be added automatically)
			if (!$file->isDir())
			{
				// Get real and relative path for current file
				$filePath = $file->getRealPath();
				$relativePath = substr($filePath, strlen($rootPath) + 1);

				// Add current file to archive
				$zip->addFile($filePath, $relativePath);
			}
		}

		// Zip archive will be created only after closing object
		$zip->close();
 
 
 
 ///////////////////////////////////////////////////////////////////////////
 
 $files = glob($folder.'*'); // get all file names
	foreach($files as $file){ // iterate files
	  if(is_file($file))
		unlink($file); // delete file
	}
	
	$files = glob($folder2.'*'); // get all file names
	foreach($files as $file){ // iterate files
	  if(is_file($file))
		unlink($file); // delete file
	}
 
 ////////////////////////////////////////////////////////////////////////////


	
	
	
	//$zip_path = $zip->get_zip_path();
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename='.basename($zip_file));
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($zip_file));
	readfile($zip_file);

	
?>