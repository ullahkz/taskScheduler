<?php

$list_of_files = scandir('Data/'.date('d-m').'/');

echo count(scandir('Data/'.date('d-m').'/'));
die();
$path= 'Data/'.date('d-m').'/';

foreach($list_of_files as $key=>$file_name){
	if($key>1){
		$find = explode('.',$file_name);
		$suffix = (int)$find[1];
		$suffix = $suffix + 1;
		$new_name = $find[0].'.'.$suffix;
		echo $path.$file_name.'<br>';
		echo $path.$new_name.'<br>';
		// rename($path.$file_name, $path.$new_name);
	}
}

?>