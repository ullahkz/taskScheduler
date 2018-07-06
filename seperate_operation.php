<?php


// Infinite time limit for the execution of this script.
ini_set('max_execution_time', -1); 

// Set the time zone to get the local time - without any error
date_default_timezone_set('Europe/Berlin');

// included the 'functions.php' - includes classes, functions and methods. 
$date_dir = 'Data/'.date('d-m');

include 'functions.php';


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

?>