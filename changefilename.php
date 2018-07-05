<?php

$list_of_files = scandir('Data/'.date('d-m').'/'); // '.date('d-m').'

$path= 'Data/'.date('d-m').'/';

$available_files = [];

foreach($list_of_files as $key=>$file_name){ 
	if($key>1){
		array_push($available_files, $file_name);
	}
}

for($j=sizeof($available_files)-1;$j>=0;$j--){
	$data_path = $path.$available_files[$j];
	$array = explode('.', $available_files[$j]);
	$fl_number = $array[1];
	$new_fl_number = (int)$fl_number+1;
	$new_data_name = $array[0].'.'.$new_fl_number;
	$new_data_path = $path.$new_data_name;
	rename($data_path,$new_data_path);
}

?>
