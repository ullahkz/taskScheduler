<?php

// Infinite time limit for the execution of this script.
ini_set('max_execution_time', -1); 

// Set the time zone to get the local time - without any error
date_default_timezone_set('Europe/Berlin');

// included the 'functions.php' - includes classes, functions and methods. 
include 'functions.php';

// $file_name = 'data/1804.log';

// (1) The name of the log files includes four (4) digits -> "last two digist of current year"."current month".log
// (2) first two digits are -> the last two digits of current "year" (e.g for 2018 it is = 18)
// (3) last two digits are -> current "month" (e.g for june it is = 06 but for October, November and December = 10, 11 and 12)
// (4) Therefore the logdata name is generated as => "1806.log" 
// *** Note: log data file name is unique for every month. It is newly generated in every month by DuG. ***

// Here, dynamic log data name is created to match with the existing log data. 
$log_data_name = date('ym'); 

// Assigning the log data file name with path
$file_name = 'G:\VS\DG\Ishop\Websale\websale8_shop-service-center\log\\'.$log_data_name.'.log';

/*******************************************************************************************************
********************************************************************************************************
	Operations: Step by step
		(1) Check if log data exists
		(2) Check if export was performed in last one hour or not
		(3) If performed => copy the export data to local folder
		(4) Prepare shopware export data (templates are predefined in the template folder)
		(5) Upload the export data via secure FTP connection
		(6) Import data to shopware via cron JOB

		Note: This program is aumatically executed in every 1 Hour by Task planner(Aufgabeplanner)

********************************************************************************************************
********************************************************************************************************/

/*******************
	Operation (1)
********************/
if(file_exists($file_name)){ 

	$handle = fopen($file_name, 'r');

	$i = 1;

	$date = date('Y-m-d'); 

	$time_minus = date('H:i:s', time()-(1 * 60 * 60)); 

	$time_plus = date('H:i:s', time()); 

	$flag = 0; 

	$service_info = [];

	while(($result = fgets($handle)) != FALSE){
	  
	  $content = preg_split('/[\s]+/', $result); 

	  $content_time = date('H:i:s',strtotime($content[1]));

	/*******************
		Operation (2)
	********************/
		if($content[count($content)-2] == 'beendet' && $content[count($content)-3]  == '"service-center"' && $content[0] == $date && $content_time>$time_minus && $content_time<$time_plus){
		array_push($service_info, $content_time); 
		$flag = 1; // Confirmation flag from Operation (2) 
		}

	    $i++;
	}

	$last_export = 'last-export.txt';
	$last_export_file = fopen($last_export, 'r');
	$check_last_export_time = fgets($last_export_file);

	if($check_last_export_time == end($service_info)){
		$flag = 0;
		echo 'Old export Data.<br>';
		fclose($last_export_file);
	}
	else{
		$flag = 1;
		echo 'New Export Data found.<br>';
		$new_export_time = fopen($last_export, 'w');
		fputs($new_export_time, end($service_info));
		fclose($new_export_time);
	}

	/**********************
		Operation (2) End
	***********************/

	fclose($handle);

	$operation = [0];

	if($flag == 0){ 

			$operation[0] = 0;

			$file = fopen('DuG-Export-log.txt', 'a');

			$info = $date.'	'.$time_plus.'	'.'No data found to export!';
			echo $info.'<br>';

			fwrite($file, $info."\n");
			fclose($file);

	}
	else{

		$operation_flag = [];

		$path = 'G:\VS\DG\Ishop\Websale\websale8_shop-service-center\data-exchange\archiv\\'; 

		if(is_dir($path)){

			$file = fopen('DuG-Export-log.txt', 'a');
			
			$start_info =  $date."	".$time_plus."	".'Export Starts'.'	';

			fwrite($file, $start_info."\n");

			$directory_list = scandir($path); 

	    	$_minus =  date('H:i:s', strtotime(end($service_info))-(5*60));

		    for($j=2;$j<sizeof($directory_list);$j++){ 
		    	
		    	if(date('H:i:s', filemtime($path.$directory_list[$j])) < date('H:i:s',strtotime(end($service_info))) &&  date('H:i:s', filemtime($path.$directory_list[$j])) > $_minus || ($directory_list[$j] == 'customerimport.1' || $directory_list[$j] == 'directimport.1')){

		    		$string = $date."	".$time_plus."	".$directory_list[$j].' erzeugt um '.date('H:i:s', filemtime($path.$directory_list[$j])).'  ';

		    		echo $string;

		    		fwrite($file, $string."\n");

		    		$operation[0] = 1; 
		    	}
		    
		    }

	    	fwrite($file, "\n");
		    fclose($file);

		}
	}

/*******************
	Operation (3)
********************/
    
    if($operation[0] == 1){
    	// Do the Copy     

        $source1 = 'G:\VS\DG\Ishop\Websale\websale8_shop-service-center\data-exchange\archiv\directimport.1';
        // $source2 = 'G:\VS\DG\Ishop\Websale\websale8_shop-service-center\data-exchange\archiv\customerimport.1';

        if(file_exists($source1)){ // && file_exists($source2)

            $date_dir = 'Data/'.date('d-m');

            if(!is_dir($date_dir)){
                mkdir('Data/'.date('d-m'));    
            }       	

	        $target1 = $date_dir.'/directimport.1';
            // $target2 = $date_dir.'\customerimport.1';

			// if(file_exists($target1)){
			// 	include 'changefilename.php';
			// }

	        full_copy($source1, $target1);
	        // full_copy($source2, $target2);

	  	}
	  	else{
	  		$file = fopen('DuG-Export-log.txt', 'a');
	  		
			$error_info = $date.'	'.$time_plus.'	'.'Error while copying data!';
			echo $error_info.'<br>';
			
			fwrite($file, $error_info."\n");
			fclose($file);	  		
	  	}

    	// when copy is finished
    		// Do the Conversion
	  	if(file_exists($target1)){

	  		echo '<br>Files are successfully copied!<br>';
        	$data_path = $date_dir.'/directimport.1/01-aa/wpupdate.csv';
        	$data_path_2 = $date_dir.'/directimport.1/01-aa/wpcomplete.csv';

        if(!file_exists($data_path) && !file_exists($data_path_2)){
        	$file = fopen('DuG-Export-log.txt', 'a');
			$file_not_exists = $date.'	'.$time_plus.'	'.'This Export is not for Primus SHOP! May be for another SHOP, because no file exists because no file exists under 01-aa folder!!';
			fwrite($file, $file_not_exists."\n");
	  		fclose($file);        	
            die('This Export is not for Primus SHOP! May be for another SHOP, because no file exists because no file exists under 01-aa folder!!');
        }	  		

/***********************
	Operation (3) End
************************/

	    $date_today = date('Ymd');

	    $datum = date('YmdG'); // date('YmdGis');

	    $minute = '01'; 
	    
	    $second = '01';

	    $complete_date = $datum.$minute.$second;

	    $folder_order = 1;

/*******************
	Operation (4)
********************/

		// creating export data for SHOPWARE

	  		$artikel_data_export = new exportArtikelData($complete_date, $folder_order);

	  		$operation1 = $artikel_data_export->getArtikelExportData();	 // Methods to generate 'import.default_articles_complete.csv' & 'import.default_article_categories.csv'
	  		// $operation2 = $artikel_data_export->getCategorieData(); // This method was inside the Artikel ExportData function - now its here to check if article
	  		$operation3 = $artikel_data_export->getImageMinimal();		 // Methods to generate 'import.default_articles_images_url.csv'
	  		$operation4 = $artikel_data_export->getArtikelStockInfo();   // Methods to generate 'import.default_article_in_stock.csv'
	  		// $operation5 = $artikel_data_export->getArtikelPreisUpdate(); // Methods to generate 'import.default_article_prices'

	  	}

    	// available predefined templates
    	
    	$import_name_array = ['import.default_articles_complete.csv','import.default_article_in_stock.csv','import.default_article_images_url.csv','import.default_article_images.csv','import.default_article_prices.csv','import.default_article_categories.csv'];

/***********************
	Operation (4) End
************************/    	

    	$file_availability_array = [0,0,0,0,0,0];

    	$i = 0;

    	foreach($import_name_array as $import_files){
    		if(file_exists('Export/'.date('d-m').'/'.$import_files)){
    			$file_availability_array[$i] = 1;
    		}
    		$i++;
    	}

/*******************
	Operation (5)
********************/

    	// Upload the file to SHOP
		// die('died before upload to ftp');

		$cron_message = "Cron Message: "."<br>";
		
		$j = 0;
		$file = fopen('DuG-Export-log.txt', 'a');
    	foreach($file_availability_array as $flag){
    		if($flag == 1){    			
	    		$file_path = 'Export/'.date('d-m').'/';    		
	    		$artikel_data_export->uploadToShopware($file_path, $import_name_array[$j]);
	    		$cron_text = file_get_contents('http://1-demo-2018.muenzpreis.de/backend/SwagImportExportCron/cron');
	    		$cron_message = $cron_message." ".$cron_text;
				echo $cron_text.'<br>';				
				fwrite($file, $date."	".$time_plus."	".$cron_text);
				rename($file_path.$import_name_array[$j], $file_path.'done_'.date('dmY_Hi').'_'.$import_name_array[$j]);
    		}
    		$j++;
    	}
		fwrite($file, "Shopware Import is done!"."\n");
		fclose($file);

/******************************************
	Email - it will not work in localhost -> to activate this function we need -> email server details for email@gavia.de [z.B smtp server, port, email , password]
*******************************************/   

		// $to      = 'kazi.riaz.ullah@gavia.de';
		// $subject = 'Export beendet um Tag: '.date('d-m-Y').' und '.date('H-i-00').' Uhr.';
		// $message = $cron_message
		// $headers = 'From: kazi.riaz.ullah@gavia.com' . "\r\n" .
		//     'Reply-To: kazi.riaz.ullah@gavia.com' . "\r\n" .
		//     'X-Mailer: PHP/' . phpversion();

		// mail($to, $subject, $message, $headers); 

/************************
	Email function End - Need to activate in future
*************************/   


/************************
	Operation (5) End
*************************/    	

/*******************
	Operation (6) ------------------------------------- Optional
********************/

		// Do the cron job
			die('Cron Job done!');
	  		$file = fopen('DuG-Export-log.txt', 'a');
	  		$cron_text = file_get_contents('http://1-demo-2018.muenzpreis.de/backend/SwagImportExportCron/cron');
	  		$finished = 'Import finished!.<br>';
	  		echo $cron_text;
	  		fwrite($file, $cron_text."\n");
	  		fwrite($file, $finished."\n");
	  		fclose($file);

/************************
	Operation (6) End
*************************/    
    }
}



?>