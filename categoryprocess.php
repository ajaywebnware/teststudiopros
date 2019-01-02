<?php error_reporting(0);
	require('spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
	require('spreadsheet-reader-master/SpreadsheetReader.php');
	
	////////////////////////
	
	
	$Reader = new SpreadsheetReader('Categories-Mercari.xlsx');
	
	
	$newarrr = array();
	foreach($Reader as $Row)
	{
		if($Row[0]!='ID' && $Row[0]!='Level0'&& $Row[1]!='NULL' && $Row[2]!='NULL' && $Row[0]!=''  && $Row[0]!=NULL  && $Row[1]!=''  && $Row[1]!=NULL   && $Row[2]!=''  && $Row[2]!=NULL  && $Row[3]!=''  && $Row[3]!=NULL  && $Row[4]!=''  && $Row[4]!=NULL && $Row[5]!=''  && $Row[5]!=NULL )
		{
			$newarrr[] = $Row[5];
		}
	}
	
	/* echo "<pre>";
	print_r($newarrr);
	echo "</pre>"; */
	
	
	//exit;
	
	
	
	
	
	
	$delimiter = ",";
	$fp = fopen('results/categoryprocess.csv', 'a+');
	
	$fields = array('', 'ID', '', '','', 'Name', '');
	fputcsv($fp, $fields, $delimiter);
	
	$fields1 = array('Level0', 'Level1', 'Level2', 'Level0','Level1', 'Level2', '');
	fputcsv($fp, $fields1, $delimiter);
	
	$newArr = array();
	$i=1;
	$xx= 'X';
	foreach($Reader as $Row)
	{
		
		
		if($i>2 && $Row[0]!='Level0' &&  $Row[1]!='NULL' && $Row[2]!='NULL' && $Row[0]!=''  && $Row[0]!=NULL  && $Row[1]!=''  && $Row[1]!=NULL   && $Row[2]!=''  && $Row[2]!=NULL  && $Row[3]!=''  && $Row[3]!=NULL  && $Row[4]!=''  && $Row[4]!=NULL && $Row[5]!=''  && $Row[5]!=NULL )
		{
			$cnt=0;
			//echo $Row[5]." ". count(array_keys($newarrr, $Row[5]));
			$cnt= count(array_keys($newarrr, $Row[5]));
			
			if($cnt>1)
			{
				$fields2 = array();
				$newVal='';
				$newVal=$Row[3]."'s ".$Row[4]." ".$Row[5];
				
				$fields2 = array($Row[0], $Row[1], $Row[2], $Row[3],$Row[4], $newVal, $xx);
				fputcsv($fp, $fields2, $delimiter);
			}
			else
			{
				$fields3 = array();
				$fields3 = array($Row[0], $Row[1], $Row[2], $Row[3],$Row[4], $Row[5], '');
				fputcsv($fp, $fields3, $delimiter);
			}
			
			
		}
		
	
		
		$i++;
	} 
	
	
	/* echo "<pre>";
	print_r($newArr);
	echo "</pre>"; */
	
	
	
	
	//////////////////////////////////////////////////////////////////
	
	///////////////////////////////////////////////////////////////////////////////////////
	
	
?>