<?php error_reporting(0);
	require('spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
	require('spreadsheet-reader-master/SpreadsheetReader.php');
	
	////////////////////////
	
	$size = 2500;
	$pageIndex = 0;
	
	
	if(isset($_REQUEST['pageIndex']) && $_REQUEST['pageIndex']!=''){
		$pageIndex = $_REQUEST['pageIndex'];
	}
	
	
	$seekval = $size*$pageIndex+1;
	$totSize = $seekval+($size-1);
	
	/////////////
	$delimiter = ",";
	ob_start();
	ob_clean();
	////////////
	$Reader = new SpreadsheetReader('Categories-Mercari.xlsx');
	
	
	$newArr = array();
	foreach($Reader as $Row)
	{
		
		if($Row[0]!='ID' && $Row[0]!='Level0'&& $Row[1]!='NULL' && $Row[2]!='NULL' && $Row[0]!=''  && $Row[0]!=NULL  && $Row[1]!=''  && $Row[1]!=NULL   && $Row[2]!=''  && $Row[2]!=NULL  && $Row[3]!=''  && $Row[3]!=NULL  && $Row[4]!=''  && $Row[4]!=NULL && $Row[5]!=''  && $Row[5]!=NULL )
		{
			$newArr[$Row[0]][$Row[1]][$Row[2]] = $Row[5];
		}
	} 
	
	//////////////////////////////////////////////////////////////////
	
	if($pageIndex==0){
		
		$folder='source/';
		$filename='';
		if ($dir = opendir($folder))
		{
			echo $cnt = count(glob($folder."*"));
			echo "<br>";
			if($cnt>0)
			{
				while(($file = readdir($dir)) !== false){
					
					if($file!='..' && $file!='.' && !is_dir($folder.$file)){
						$filename=$file;
						
						rename('source/'.$filename , 'processing/'.$filename );
						break;
					}
				}
			}
			else
			{
				header('Location:done.php');
				exit();
			}
		}
	}
	
	
	//////////////////////////////////////////////////
	
	
	$folderProcess = 'processing/';
	if (is_dir($folderProcess))
	{
		if($dh = opendir($folderProcess))
		{
			
				while(($filer = readdir($dh)) !== false)
				{
					if($filer!='..' && $filer!='.')
					{
						$filenameProcess=$filer;
						
						$fullfileName = basename('processing/'.$filenameProcess);
						$fileNameNoExtension = preg_replace("/\.[^.]+$/", "", $fullfileName);
						
						$fp = fopen('results/res_'.$fileNameNoExtension.'.csv', 'a+');
						$fp1 = fopen('log/log.txt', 'a+');
						if($pageIndex==0){
							
						$fields = array('Account', 'Campaign', 'Ad Group', 'Link Text', 'Destination URL', 'Final URL');
							fputcsv($fp, $fields, $delimiter);
						}
		
						
						
						
						$Reader1 = new SpreadsheetReader('processing/'.$filenameProcess);
						
						$key =0;
						
							try{
									
									$Reader1->seek($seekval);
									$keyy =$Reader1->key();
									$text = "counter is on ".$filenameProcess.' = '.$keyy.PHP_EOL;
									
									fwrite($fp1,$text);
									
									$recordProcessed = 0 ;
									while($Reader1->valid() && $recordProcessed < $size)
									{
										
										$Row1 = $Reader1->current() ;
										if (strpos($Row1[2], 'c0') !== false)
										{
											$stArr = explode(';',$Row1[2]);
											
											$stArr1  = explode('(',$stArr[0]);
											$strC1Arr = explode('=',$stArr1[0]);
											$strC1 = (int)$strC1Arr[1];
											
											$stArr2  = explode('(',$stArr[1]);
											$strC2Arr = explode('=',$stArr2[0]);
											$strC2 = (int)$strC2Arr[1];
											
											
											foreach($newArr[$strC1][$strC2] as $nwdx => $nwVal)
											{
												
												$finalUrl = 'https://www.mercari.com/search/?sort_order=like_desc&keyword=&category_root='.$strC1.'&category_child='.$strC2.'&category_grand_child%5B'.$nwdx.'%5D=1&brand_name=&brand_id=&size_group=&price_min=&price_max=&status_on_sale=1';
												
												
												
												$data = array($Row1[3],$Row1[0],$Row1[1],$nwVal,'',$finalUrl);
												fputcsv($fp, $data, $delimiter);
												
												
											}
										}
											$Reader1->next();
											$recordProcessed++;
											
									}
									fclose($fp);
									$pageIndex =$pageIndex +1;
									//header('Location:process.php?pageIndex='.$pageIndex);
									//exit();
									?>
									<meta http-equiv="refresh" content="0;URL='<?php echo 'process.php?pageIndex='.$pageIndex ; ?>'" />
									<?php
									
								}catch(Exception $e)
								{
									fclose($fp);
									fclose($fp1);
									rename('processing/'.$filenameProcess, 'done/'.$filenameProcess);
									
									
									//header('Location:process.php');
									//exit();
									?>
									<meta http-equiv="refresh" content="0;URL='<?php echo 'process.php'; ?>'" />
									<?php
								}
									
							fclose($fp);
							fclose($fp1);
			
					
					}
				}
			
					 closedir($dh);
		}
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
?>