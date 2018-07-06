<?php

function full_copy( $source, $target ) {
    if ( is_dir( $source ) ) {
        @mkdir( $target );
        $d = dir( $source );
        while ( FALSE !== ( $entry = $d->read() ) ) {
            if ( $entry == '.' || $entry == '..' ) {
                continue;
            }
            $Entry = $source . '/' . $entry; 
            if ( is_dir( $Entry ) ) {
                full_copy( $Entry, $target . '/' . $entry );
                continue;
            }
            copy( $Entry, $target . '/' . $entry );
        }

        $d->close();
    }else {
        copy( $source, $target );
    }
}


include 'shopwareapi.php';

class exportArtikelData {
    
    private $_date;
    private $_fl_nummer;

    public function __construct($datum, $order){
        $this->_date = $datum;
        $this->_fl_nummer = $order;
        // $this->_order_nummer = $order;
    }

    public function getTemplate($tp_var, $tp_name){
        $template_folder = $tp_var;
        $template_file_path = 'Templates/'.$template_folder;
        $template = $template_file_path.'/'.$tp_name;
        $exist = file_exists($template);

        if($exist){
            $handle = fopen($template,'r');
            // $content = fread($handle, 1024);
            $title_array = fgets($handle, 1024);
            return $title_array;
        }
        else{
            echo 'Vorlage nicht existiert';
        }
    }

    public function getEmptyTableForArtikel($id){
        $template_array = ['default.articles.complete','default.articles.categories','default.articles.imageURLs','default_articlesInStock','default_article_images_minimal','default_article_prices'];
        $import_name_array = ['import.default_articles_complete','import.default_article_categories','import.default_article_images_url','import.default_article_in_stock','import.default_article_images','import.default_article_prices'];
        $template_name = $template_array[$id];

            $new_dir = 'Export/'.date('d-m');
            if(!is_dir($new_dir)){
                mkdir('Export/'.date('d-m'));    
            }
            
            $data_name = 'Templates/articles/'.$template_name.'.csv';
            $new_data_name = 'Export/'.date('d-m').'/'.$template_name.'.csv';
            if(file_exists($data_name)){
                copy($data_name, $new_data_name);
                rename($new_data_name, 'Export/'.date('d-m').'/'.$import_name_array[$id].'.csv');
                return $import_name_array[$id].'.csv';
            }
            else{
                echo $data_name.' nicht existiert!';
                die('Error!');
            }           
    }

    public function getSupplier($nummer){
        $wb_50 = range(80500056, 80500171);
        $wb_51 = range(80510135, 80510221);
        $wb_52 = range(80520035, 80520046);
        $wb_53 = range(80530120, 80530208);
        $wb_54 = range(80540161, 80540241);
        $wb_55 = range(80555601, 80557629);
        $wb_56 = range(80560024, 80560076);
        $wb_57 = range(80570034, 80570219);

        $leuchttrum_artikel = array_merge($wb_50, $wb_51, $wb_52, $wb_53, $wb_54, $wb_55, $wb_56, $wb_57);

        if(in_array($nummer, $leuchttrum_artikel)){
            return 'Leuchtturm';
        }
        else{
            return 'Primus';
        }        
    }

    public function getNumberofArticle($id){
        if($id == 1){
            $data_path = 'Data/directimport.1/01-aa/wpupdate.csv';
            if(!file_exists($data_path)){
                $data_path = 'Data/directimport.1/01-aa/wpcomplete.csv';
            }
        }
        else if ($id == 4){
            $data_path = 'Data/directimport.1/amountupdate.csv';
        }
        
        $content = fopen($data_path, 'r');

        $j=0;

        while (($row = fgetcsv($content, 0, "\t")) != FALSE) {
            $j++;
        }
        return $j.' Artikel';
    }

    public function getArtikelStockInfo(){
        // $operation = $this->getEmptyTableForArtikel(3);

        // $file_name = 'import.default_article_in_stock.csv';

        global $date_dir;

        $file_name = $this->getEmptyTableForArtikel(3);

        $file_path = 'Export/'.date('d-m').'/'.$file_name;

        $handle = fopen($file_path, 'a');

        $test = fgetcsv($handle, '1024', ';');

        $data_path = $date_dir.'/directimport.1/amountupdate.csv';

        $content = fopen($data_path, 'r');

        $j=0;

        // include 'artikel_database_array.php';

        while (($row = fgetcsv($content, 0, "\t")) != FALSE) {
            if($j!=0 && $row[1] != 0){
                $input_data = array_fill(0, 5, '');
                $input_data[0] = explode('-', $row[0], 2)[1];
                $input_data[1] = $row[1];
                $input_data[3] = $this->getSupplier($row[0]);
                // if(in_array($input_data[0], $artikel_database_array)){
                    fputcsv($handle, $input_data, ';');    
                // }                
            }
            $j++;
        }
        fclose($handle);
        fclose($content);                
    }

    public function getImageName($artikelNumber){
        $number = $artikelNumber;
        if(strpos($number, '.')){
            $array = explode('.', $number);
            $newArticleNumber = 'g'.$array[0].$array[2];
            return $newArticleNumber;
        }
        else{
            return $number;
        }
    }

    public function getImageMinimal(){

        global $date_dir;

        // $operation = $this->getEmptyTableForArtikel(4);

        // $file_name = 'default_article_images_minimal.csv';

        $file_name = $this->getEmptyTableForArtikel(4);

        $file_path = 'Export/'.date('d-m').'/'.$file_name;

        $handle = fopen($file_path, 'a');

        $test = fgetcsv($handle, '1024', ';');

        $data_path = $date_dir.'/directimport.1/01-aa/wpupdate.csv';
        
        if(!file_exists($data_path)){
            $data_path = $date_dir.'/directimport.1/01-aa/wpcomplete.csv';                
        }

        $content = fopen($data_path, 'r');

        $j=0;

        // include 'artikel_image_available.php';
        // include 'artikel_database_array.php';

        while (($row = fgetcsv($content, 0, "\t")) != FALSE) {

            if($j!=0){
                $input_data = array_fill(0, 4, '');

                $input_data[0] = $row[0];
                $input_data[1] = '';
                $input_data[2] = '';
                
        // if(in_array($row[0], $artikel_database_array)){
                // $web_path = 'http://testshop2.muenzpreisvergleich.de/artikelbilder/gross/';
                $web_path = 'https://www.primus-muenzen.com/$WS/service-center/websale8_shop-service-center/produkte/medien/bilder/gross/';

                $shopware_path = 'http://1-demo-2018.muenzpreis.de/media/image/';

                $large_image = $web_path.$row[65];
                $bild_gross_1 = $web_path.$row[69];
                $bild_gross_2 = $web_path.$row[73];
                $bild_gross_3 = $web_path.$row[77];
                $bild_gross_4 = $web_path.$row[81];

                $sw_large_image = $shopware_path.$row[65];
                $sw_bild_gross_1 = $shopware_path.$row[69];
                $sw_bild_gross_2 = $shopware_path.$row[73];
                $sw_bild_gross_3 = $shopware_path.$row[77];
                $sw_bild_gross_4 = $shopware_path.$row[81];                

                if(!empty($row[65])){
                    $input_data[1] = $large_image;
                    $input_data[2] = 1;
                    // $input_data[4] = 1;

                    $file_headers = @get_headers($large_image);
                    $sw_file_headers = @get_headers($sw_large_image);

                    if($file_headers[0] == 'HTTP/1.1 200 OK' && $sw_file_headers[0]  == 'HTTP/1.1 404 Not Found'){
                        fputcsv($handle, $input_data, ';');
                    }
                }
                if(!empty($row[69])){
                    $input_data[1] = $bild_gross_1;
                    $input_data[2] = '2';
                    // $input_data[4] = 2;
                    $file_headers = @get_headers($bild_gross_1);
                    $sw_file_headers = @get_headers($sw_bild_gross_1);
                    if($file_headers[0] == 'HTTP/1.1 200 OK' && $sw_file_headers[0]  == 'HTTP/1.1 404 Not Found'){                    
                        fputcsv($handle, $input_data, ';');
                    }
                }
                if(!empty($row[73])){
                    $input_data[1] = $bild_gross_2;
                    $input_data[2] = '3';
                    // $input_data[4] = 3;
                    $file_headers = @get_headers($bild_gross_2);
                    $sw_file_headers = @get_headers($sw_bild_gross_2);
                    if($file_headers[0] == 'HTTP/1.1 200 OK' && $sw_file_headers[0]  == 'HTTP/1.1 404 Not Found'){                    
                        fputcsv($handle, $input_data, ';');
                    }
                }               
                if(!empty($row[77])){
                    $input_data[1] = $bild_gross_3;
                    $input_data[2] = '4';
                    // $input_data[4] = 4;
                    $file_headers = @get_headers($bild_gross_3);
                    $sw_file_headers = @get_headers($sw_bild_gross_3);
                    if($file_headers[0] == 'HTTP/1.1 200 OK' && $sw_file_headers[0]  == 'HTTP/1.1 404 Not Found'){                    
                        fputcsv($handle, $input_data, ';');
                    }
                }                
                if(!empty($row[81])){
                    $input_data[1] = $bild_gross_4;
                    $input_data[2] = '5';
                    // $input_data[4] = 5;
                    $file_headers = @get_headers($bild_gross_4);
                    $sw_file_headers = @get_headers($sw_bild_gross_4);
                    if($file_headers[0] == 'HTTP/1.1 200 OK' && $sw_file_headers[0]  == 'HTTP/1.1 404 Not Found'){                    
                        fputcsv($handle, $input_data, ';');
                    }
                }               
                // fputcsv($handle, $input_data, ';');

    // }                              
            }
            $j++;
        }
        fclose($handle);           
    }

    public function getImageURL(){

        global $date_dir;
        
        // $operation = $this->getEmptyTableForArtikel(2);

        // $file_name = 'default.articles.imageURLs.csv';

        $file_name = $this->getEmptyTableForArtikel(2);

        $file_path = 'Export/'.date('d-m').'/'.$file_name;

        $handle = fopen($file_path, 'a');

        $test = fgetcsv($handle, '1024', ';');

        $data_path = $date_dir.'/directimport.1/01-aa/wpupdate.csv';
        
        if(!file_exists($data_path)){
            $data_path = $date_dir.'/directimport.1/01-aa/wpcomplete.csv';                
        }

        $content = fopen($data_path, 'r');

        $j=0;

        // include 'artikel_image_available.php';
        // include 'artikel_database_array.php';

        while (($row = fgetcsv($content, 0, "\t")) != FALSE) {
            if($j!=0){
                $input_data = array_fill(0, 4, '');

                $input_data[0] = $row[0];
                $input_data[1] = $row[0];
                $input_data[2] = '';
                $input_data[3] = '';
                
        // if(in_array($row[0], $artikel_database_array)){
                // $web_path = 'http://testshop2.muenzpreisvergleich.de/artikelbilder/gross/';
                $web_path = 'https://www.primus-muenzen.com/$WS/service-center/websale8_shop-service-center/produkte/medien/bilder/gross/';
                
                $large_image = $web_path.$row[65];
                $bild_gross_1 = $web_path.$row[69];
                $bild_gross_2 = $web_path.$row[73];
                $bild_gross_3 = $web_path.$row[77];
                $bild_gross_4 = $web_path.$row[81];

                $file_headers = @get_headers($large_image);                
                if($file_headers[0] !== 'HTTP/1.1 404 Not Found'){
                    $large_image = $web_path.$row[65];
                }
                else{
                    $large_image = '';
                }
                //
                $file_headers = @get_headers($bild_gross_1); 
                if($file_headers[0] !== 'HTTP/1.1 404 Not Found'){
                    $bild_gross_1 = $web_path.$row[69];
                }
                else{
                    $bild_gross_1 = '';
                }
                //
                $file_headers = @get_headers($bild_gross_2); 
                if($file_headers[0] !== 'HTTP/1.1 404 Not Found'){
                    $bild_gross_2 = $web_path.$row[73];
                }
                else{
                    $bild_gross_2 = '';
                }
                //
                $file_headers = @get_headers($bild_gross_3); 
                if($file_headers[0] !== 'HTTP/1.1 404 Not Found'){
                    $bild_gross_3 = $web_path.$row[77];
                }
                else{
                    $bild_gross_3 = '';
                } 
                //
                $file_headers = @get_headers($bild_gross_4); 
                if($file_headers[0] !== 'HTTP/1.1 404 Not Found'){
                    $bild_gross_4 = $web_path.$row[81];
                }
                else{
                    $bild_gross_4 = '';
                } 
                
                $main_number = 1;

                if(!empty($row[65]) && $large_image!== ''){
                    $input_data[2] = $large_image;
                    $input_data[3] = '1';
                    // $input_data[4] = 1;
                    // fputcsv($handle, $input_data, ';');
                }
                else{
                    echo $row[0].'<br>';
                }
                if(!empty($row[69]) && $bild_gross_1 !== ''){
                    $input_data[2] = $bild_gross_1.'|'.$input_data[2];
                    $input_data[3] = $input_data[3].'|2';
                    // $input_data[4] = 2;
                    // fputcsv($handle, $input_data, ';');
                }
                if(!empty($row[73]) && $bild_gross_2 !== ''){
                    $input_data[2] = $bild_gross_2.'|'.$input_data[2];
                    $input_data[3] = $input_data[3].'|3';
                    // $input_data[4] = 3;
                    // fputcsv($handle, $input_data, ';');
                }
                if(!empty($row[77]) && $bild_gross_3 !== ''){
                    $input_data[2] = $bild_gross_3.'|'.$input_data[2];
                    $input_data[3] = $input_data[3].'|4';
                    // $input_data[4] = 4;
                    // fputcsv($handle, $input_data, ';');
                }
                if(!empty($row[81]) && $bild_gross_4 !== ''){
                    $input_data[2] = $bild_gross_4.'|'.$input_data[2];
                    $input_data[3] = $input_data[3].'|5';
                    // $input_data[4] = 5;
                    // fputcsv($handle, $input_data, ';');
                }
                fputcsv($handle, $input_data, ';');
                             
            }
            $j++;
        }
        fclose($handle);       
    }

    public function getShopwareCategoryId($_id){
        require 'db_connect.php';

        $sql = "SELECT * FROM kat_index WHERE VS4_KAT_ID = $_id";

        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)){
                $shopware_id = $row['SHOPWARE_ID'];
                return $shopware_id;                
            }
        }
        else {
            return null;
        }
    }

    public function getCategorieDatabase(){
        $final_file_name = 'Templates/articles/database/categories.info.shopware.csv';

        $contend = fopen($final_file_name, 'r');

        $dug_categorie_id = [];
        $sw_categorie_id = [];

        $j=0;

        while(($row = fgetcsv($contend, 2048, ';'))!=false){
            if($j!= 0){
                array_push($dug_categorie_id, $row[0]);
                array_push($sw_categorie_id, $row[1]);
            }
            $j++;
        }

        fclose($contend);

        return array($dug_categorie_id,$sw_categorie_id);
    }

    public function getCategorieData(){

        global $date_dir;
        
        // $operation = $this->getEmptyTableForArtikel(1);

        // $file_name = 'default.articles.categories.csv';

        $file_name = $this->getEmptyTableForArtikel(1);

        $file_path = 'Export/'.date('d-m').'/'.$file_name;

        $handle = fopen($file_path, 'a');

        $test = fgetcsv($handle, '1024', ';');

        $data_path = $date_dir.'/directimport.1/01-aa/catcomplete.csv';

        $content = fopen($data_path, 'r');

        // $database = $this->getCategorieDatabase();

        include 'available_articles_in_shopware.php';

        $j=0;

        // $list_of_article = [];
        // $list_of_article_category = [];

        while (($row = fgetcsv($content, 0, "\t")) != FALSE) {
            
            if($j!=0 && !in_array($row[0],$available_artikel_in_shopware)){
                $input_data = [];
                $input_data[0] = $row[1];
                $input_data[1] = $row[1];                
                // $input_data[2] = $database[1][array_search($row[0], $database[0])];
                $input_data[2] = $this->getShopwareCategoryId($row[0]);   
                                
                // array_push($list_of_article, $row[1]);
                // array_push($list_of_article_category, $row[0]);
                fputcsv($handle, $input_data, ';');
            }
            else{
                echo "I am inside ".$row[0];
            }
            $j++;
        }
        fclose($handle);        

    }

    public function getCategorieDataforNewArticle($newarray, $availablearray){

        // $operation = $this->getEmptyTableForArtikel(1);

        // $file_name = 'default.articles.categories.csv';

        global $date_dir;

        $file_name = $this->getEmptyTableForArtikel(1);

        $file_path = 'Export/'.date('d-m').'/'.$file_name;

        $handle = fopen($file_path, 'a');

        $test = fgetcsv($handle, '1024', ';');

        $data_path = $date_dir.'/directimport.1/01-aa/catcomplete.csv';

        $content = fopen($data_path, 'r');

        // $database = $this->getCategorieDatabase();

        $new_articles = $newarray;
        $available_articles = $availablearray;

        $j=0;

        // $list_of_article = [];
        // $list_of_article_category = [];

        while (($row = fgetcsv($content, 0, "\t")) != FALSE) {

            if($j!=0 && in_array($row[1], $new_articles)){
                
                $input_data = [];
                $input_data[0] = $row[1];
                $input_data[1] = $row[1];                
                // $input_data[2] = $database[1][array_search($row[0], $database[0])];
                $input_data[2] = $this->getShopwareCategoryId($row[0]);   
                                
                // array_push($list_of_article, $row[1]);
                // array_push($list_of_article_category, $row[0]);
                fputcsv($handle, $input_data, ';');
        
            }
            if($j!=0 && in_array($row[1], $available_articles)){
                $input_data = [];
                $input_data[0] = $row[1];
                $input_data[1] = $row[1];                
                // $input_data[2] = $database[1][array_search($row[0], $database[0])];
                $input_data[2] = $this->getShopwareCategoryId($row[0]);   
                                
                // array_push($list_of_article, $row[1]);
                // array_push($list_of_article_category, $row[0]);
                fputcsv($handle, $input_data, ';');
            }
            $j++;
        }
        fclose($handle);        

    }

    public function getTheType($artikelNummer){

        $client = new ApiClient(
            //URL of shopware REST server
            'http://1-demo-2018.muenzpreis.de/api',
            //Username
            'kazi.riaz.ullah',
            //User's API-Key
            '9u42xgVQ79FoaH7HlkdgpAn9TWr0kmmrxcgh7q9d'
        );

        ob_start();
        $html = $client->get('articles/'.$artikelNummer.'?useNumberAsId=true');
        ob_end_clean();
        return gettype($html);
    }                   

    public function getArtikelExportData(){

        global $date_dir;

        $file_name = $this->getEmptyTableForArtikel(0);

        $file_path = 'Export/'.date('d-m').'/'.$file_name;

        $handle = fopen($file_path, 'a');

        $test = fgetcsv($handle, '1024', ';');
        
        
        $data_path = $date_dir.'/directimport.1/01-aa/wpupdate.csv';
        $data_path_2 = $date_dir.'/directimport.1/01-aa/wpcomplete.csv';

        // Check if none of the file exists - may be this export is for another shop
        if(!file_exists($data_path) && !file_exists($data_path_2)){
            die('This Export is not for Primus! May be for another SHOP because no file exists!');
        }

        if(!file_exists($data_path)){        
            $data_path = $date_dir.'/directimport.1/01-aa/wpcomplete.csv';
            $type = null;
            
        }        

        $content = fopen($data_path, 'r');

        // include 'available_articles_in_shopware.php';

        $new_article_array = [];

        $available_csv_article_array = [];

        $j=0;

        while (($row = fgetcsv($content, 0, "\t")) != FALSE) {

            if($j!=0){
                array_push($available_csv_article_array, (string)$row[0]);        
                if($this->getTheType($row[0]) == 'NULL'){
                    array_push($new_article_array, (string)$row[0]);
                }    

                    $number_of_items = 71;

                    $artikel_data = array_fill(0,$number_of_items, '');

                    if($row[5] == 1){
                        $tax = 19;    
                    }
                    else{
                        $tax = 0;
                    }

                    if(strpos($row[0], '.')){
                        $propertyGroupName = 'Briefmarken';
                        $propertyValue = 'Land:'.$row[102].'|Jahr:'.$row[114].'|Erhaltung:'.$row[115].'|Material:'.$row[116].utf8_decode('|Gewicht/Füllmenge:').$row[117].'|Veredelung:'.$row[137].'|Michel-Nr.:'.$row[106].'|Michel Kat.-Wert.:'.$row[107];
                    }
                    else{
                        $propertyGroupName = 'Münzen';
                        $propertyValue = 'Land:'.$row[102].'|Nominal:'.$row[103].'|Jahr:'.$row[114].'|Erhaltung:'.$row[115].'|Material:'.$row[116].utf8_decode('|Gewicht / Füllmenge:').$row[117].utf8_decode('|Maße:').$row[127].'|Auflage:'.$row[136].'|Veredelung:'.$row[137].'|Nominal:'.$row[103];   
                    }

                    $artikel_data[0] = $row[0];
                    $artikel_data[1] = $row[0];
                    $artikel_data[2] = $row[1];
                    $artikel_data[4] = $this->getSupplier($row[0]);
                    $artikel_data[5] = $tax;
                    $artikel_data[6] = number_format((float)$row[6], 2, '.', '');
                    $artikel_data[7] = number_format((float)$row[27], 2, '.', '');
                    $artikel_data[16] = 1;
                    $artikel_data[18] = 1;
                    $artikel_data[20] = str_replace("?", "", $row[11]);
                    $artikel_data[25] = 0;
                    $artikel_data[26] = 0;
                    $artikel_data[39] = $row[14];
                    $artikel_data[40] = $row[93];
                    $artikel_data[49] = utf8_decode($propertyGroupName);
                    $artikel_data[50] = str_replace("?", "", $propertyValue);

                    fputcsv($handle, $artikel_data, ';');
                
            }
            $j++;
        }

        fclose($handle);
        fclose($content);
        // echo $j.' no of items!';
        // print_r($new_article_array);die();
        $this->getCategorieDataforNewArticle($new_article_array, $available_csv_article_array);
    }

    public function getArtikelPreisUpdate(){

        global $date_dir;

        $file_name = $this->getEmptyTableForArtikel(5);

        $file_path = 'Export/'.date('d-m').'/'.$file_name;

        $handle = fopen($file_path, 'a');

        $test = fgetcsv($handle, '1024', ';');
        
        
        $data_path = $date_dir.'/directimport.1/01-aa/wpupdate.csv';
        
        if(!file_exists($data_path)){
            $data_path = $date_dir.'/directimport.1/01-aa/wpcomplete.csv';                
        }        

        $content = fopen($data_path, 'r');

        $j=0;

        while (($row = fgetcsv($content, 0, "\t")) != FALSE) {
            if($j!=0){

                $number_of_items = 10;

                $artikel_data = array_fill(0,$number_of_items, '');

                $artikel_data[0] = $row[0];
                $artikel_data[1] = number_format((float)$row[6], 2, '.', '');
                $artikel_data[2] = "EK";
                $artikel_data[3] = 1;
                $artikel_data[4] = "bleibig";
                $artikel_data[5] = number_format((float)$row[27], 2, '.', '');
                $artikel_data[6] = 0;
                $artikel_data[7] = str_replace('&nbsp;', ' ', $row[1]);
                $artikel_data[8] = "";
                $artikel_data[9] = $this->getSupplier($row[0]);            

                fputcsv($handle, $artikel_data, ';');

            }
            $j++;
        }

        fclose($handle);
        fclose($content);
        // echo $j.' no of items!';
    }


    public function uploadToShopware($path, $name){

        $file_name = $name;

        $file = $path.$name;

        $remote_path = 'shopware/files/import_cron/';

        $remote_file = $remote_path.$file_name;

        $ftp_server = 'home741197394.1and1-data.host';

        $conn_id = ftp_connect($ftp_server);

        $username = 'u93885614';

        $password = 'tG7m%AFzs*SmnZzdq';

        $login_result = ftp_login($conn_id, $username, $password);

        ftp_pasv($conn_id, true);

        // upload a file
        if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
         echo "successfully uploaded $file\n";
        } else {
         echo "There was a problem while uploading $file\n";
        }

        // close the connection
        ftp_close($conn_id);

    }    

}

?>