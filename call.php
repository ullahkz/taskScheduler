<?php

include 'shopwareapi.php';

$client = new ApiClient(
    //URL of shopware REST server
    'http://1-demo-2018.muenzpreis.de/api',
    //Username
    'kazi.riaz.ullah',
    //User's API-Key
    '9u42xgVQ79FoaH7HlkdgpAn9TWr0kmmrxcgh7q9d'
);

function getTheType($artikelNummer){
	global $client;
	ob_start();
	$html = $client->get('articles/'.$artikelNummer.'?useNumberAsId=true');
	ob_end_clean();
	return gettype($html);
}

function getTheCategory($artikelNummer){
    global $client;
    $html = $client->get('articles/'.$artikelNummer.'?useNumberAsId=true');
}

// print_r(@get_headers('http://1-demo-2018.muenzpreis.de/media/image/10133005_5.jpg'));

?>