<?php
require 'function.php';
echo "Split (Produits/Declinaisons)";
echo "<br>";
echo '<br>';
echo"<a href='mascot'><input value='MASCOT SPLIT' type='submit' id='' name=''> </input></a><br>";
echo '<br>';
echo"---------------------------------------";
echo "<br>";
echo"Copie des images de produits";
echo "<br>";

?>
<!-- FORM SUBMIT POST -->
<link href="style.css" rel="stylesheet">
<br>
<form action="" method="post">
    <input value="Inject All" type="submit" id="envoyer" name="envoyer"> </input>
</form>
</br>  
<?php
echo '<br>';
echo"---------------------------------------";
echo "<br>";
echo"Truncate Table :";
echo "<br>";

/////////////////////
//LOCALHOST DB USER//
$db_host = "localhost";
$db_name = "demo_serimeca";
$db_username = "root";
$db_password = "";
/////////////////////

////////////////
//PROD DB USER//
// $db_host = "cloud100.nevasystems.be";
// $db_name = "serimeca";
// $db_username = "serimeca";
// $db_password = "gadYK9C24AvGFTr";
////////////////


//////////////////
//DATABASE CONN.//
$mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
//////////////////

///////////////////////
//OPEN FILE FOR SPLIT//
$file = fopen('./local_test/dbmascot_product.csv', 'r');
///////////////////////

/////////////
//READ FILE//
while (($line = fgetcsv($file, 0, ';')) !== FALSE) {
    
    //DATA STORED ON ARRAY//
    $data[] = $line;
    
}
/////////////

///////////////////////////////
//nb_product GET THE LAST ROW//
$nb_produit = array_key_last($data);
///////////////////////////////

$nb_col = reset($data);

////////////////////////////////
//last_col GET THE LAST COLUMN//
$last_col = array_key_last($nb_col);
////////////////////////////////

//////////////////////////////////////////////////
//GET COUNT OF ROW IN ps_cdesigner_cfields TABLE//
$query = 'SELECT COUNT(id_product) as id FROM ps_cdesigner_cfields';
$results = $mysqli->query($query);
$ligne = mysqli_fetch_assoc($results);
echo"<br>";
echo"ps_cdesigner_cfields : ";
print_r($ligne['id']);
echo " ligne(s)<br>";
//////////////////////////////////////////////////

if ($ligne['id'] > 0){
    
    echo"<br>";
    echo"<form action='' method='post'><input value='clear cdesigner_cfields' type='submit' id='cdesigner_cfields' name='cdesigner_cfields'> </input></form>";
    
    ///////////////////////////////////////////////////
    //IF BUTTON PRESSED TRUNCATE ps_cdesigner_cfields//
    if(!empty($_POST['cdesigner_cfields'])){
        $query = 'TRUNCATE TABLE ps_cdesigner_cfields';
        $mysqli->query($query);
        header("refresh: 1");
        
    }
    ///////////////////////////////////////////////////

}

///////////////////////////////////////////////////
//GET COUNT OF ROW IN ps_product_customized TABLE//
$query = 'SELECT COUNT(id_product) as id FROM ps_product_customized';
$results = $mysqli->query($query);
$ligne = mysqli_fetch_assoc($results);
echo"<br>";
echo"ps_product_customized : ";
print_r($ligne['id']);
echo " ligne(s)<br>";
///////////////////////////////////////////////////

if ($ligne['id'] > 0){
    
    echo"<br>";
    echo"<form action='' method='post'><input value='clear product_customized' type='submit' id='product_customized' name='product_customized'> </input></form>";
    
    ////////////////////////////////////////////////////
    //IF BUTTON PRESSED TRUNCATE ps_product_customized//
    if(!empty($_POST['product_customized'])){
        $query = 'TRUNCATE TABLE ps_product_customized';
        $mysqli->query($query);
        header("refresh: 1");
    }
    ////////////////////////////////////////////////////

}

////////////////////////////////////////////////////////////
//GET COUNT OF ROW IN ps_product_customized_settings TABLE//
$query = 'SELECT COUNT(id_product) as id FROM ps_product_customized_settings';
$results = $mysqli->query($query);
$ligne = mysqli_fetch_assoc($results);
echo"<br>";
echo"ps_product_customized_settings : ";
print_r($ligne['id']);
echo " ligne(s)<br>";
////////////////////////////////////////////////////////////

if ($ligne['id'] > 0){
    
    echo"<br>";
    echo"<form action='' method='post'><input value='clear ps_product_customized_settings' type='submit' id='ps_product_customized_settings' name='ps_product_customized_settings'> </input></form><br>";
    
    /////////////////////////////////////////////////////////////
    //IF BUTTON PRESSED TRUNCATE ps_product_customized_settings//
    if(!empty($_POST['ps_product_customized_settings'])){
        
        $query = 'TRUNCATE TABLE ps_product_customized_settings';
        $mysqli->query($query);
        header("refresh: 1");
    }
    /////////////////////////////////////////////////////////////

}

////////////////////////////////////////////////////
//GET COUNT OF ROW IN ps_customization_field TABLE//
$query = 'SELECT COUNT(id_product) as id FROM ps_customization_field';
$results = $mysqli->query($query);
$ligne = mysqli_fetch_assoc($results);
echo"<br>";
echo"ps_customization_field : ";
print_r($ligne['id']);
echo " ligne(s)<br>";
////////////////////////////////////////////////////

if ($ligne['id'] > 0){
    
    echo"<br>";
    echo"<form action='' method='post'><input value='clear customization_field' type='submit' id='customization_field' name='customization_field'> </input></form>";

    /////////////////////////////////////////////////////
    //IF BUTTON PRESSED TRUNCATE ps_customization_field//
    if(!empty($_POST['customization_field'])){
        
        $query = 'TRUNCATE TABLE ps_customization_field';
        $mysqli->query($query);
        header("refresh: 1");
    }
    /////////////////////////////////////////////////////

}


echo '<br>';
echo"---------------------------------------";
echo "<br>";

//////////
//TOPTEX//
//////////

if($data[0][1] == "SKU"){
    echo 'USE A MASCOT FILES';
    
    
    //////////    
    //MASCOT//
    //////////
    
    //////////////////////////////////////////
    //If COLUMN 2 CORRESPONDS TO NumÃ©ro EAN//
}elseif($data[0][1] = "NumÃ©ro EAN"){
    //////////////////////////////////////////
    

    echo 'DBMASCOT';
    echo '<br>';
    echo '<pre style="display: flex;flex-wrap: wrap;margin-top:50px;justify-content: center;">';
    
    date_default_timezone_set('Europe/Paris');
    $type = ['status', 'pdf', 'pdf_orientation', 'selected_materials'];
    $nbid = 1;
    
    // ////////////////////
    // //CREATE LOGS FILE//
    // $fichier = fopen('logs/log.txt', 'c+b');
    // //RESET LOGS FILE ON REFRESH//
    // file_put_contents('logs/log.txt', ' ');
    // ////////////////////

    $count = 1;
    $a = 5;

    for ($cpt = 1; $cpt <= $nb_produit; $cpt++) {
            
            //////////////////////////////
            //PUT DATA'S COLUMN ON A VAR//
            $id = $data[$cpt][0];
            $ref = $data[$cpt][3];
            $string = $data[$cpt][26];
            //////////////////////////////
            
            /////////////////////////////////////////////////
            //QUERY FOR GET THE id_product FROM A reference//
            $query = 'SELECT id_product FROM `ps_product` WHERE reference ="'.$ref.'"';
            $results = $mysqli->query($query);
            $results = $results->fetch_assoc();
            //STORE id_product ON A VAR//
            $id_product = $results['id_product'];
            /////////////////////////////////////////////////

            /////////////////////////////
            //WRITE QUERY INTO LOG FILE//
            if(isset($id_product)){
                
                $echo = '('.$nbid.') id => '.$id.' id_product => ' . $id_product . ' ref => '.$ref.''; 
                Addlog($echo);
                
                
            }else{
                
                $echo  = ' ('.$nbid.') id => '.$id.' id_product => NO ID_PRODUCT LINKED ref => '.$ref.'';
                Addlog($echo);
                
            }
            /////////////////////////////


            //////////////            
            //REGEX PROD//
            //$regex = '#https://serimeca-print.be/shop/images_new/#m';
            //////////////
            
            ///////////////
            //REGEX LOCAL//
            $regex = '#http://localhost/www/new/images_new/#m';
            ///////////////

            ////////////////////////
            //FORMATING STRING VAR//
            $string = preg_replace($regex, '', $string);
            $string = explode(',', $string);
            $last_key = array_key_last($string);
            ////////////////////////

            $compteur = 1;
            
            foreach ($string as $images) {
                
                ////////////////////////////////////
                //IF THERE ARE A LINKED id_product//
                if(isset($id_product)){
                ////////////////////////////////////

                    if(isset($_POST['number'])){
                        if($cpt <= $_POST['number']){
                            echo '<div style="display:flex;flex-direction: column;border:1px solid black;justify-content:center;">';
                            echo '<div class="cont">('.$nbid.') id => '.$id.' id_product => ' . $id_product . ' ref => '.$ref.'</div>';
                            echo '<div class="img"><img src="'.$images.'" ></div>';
                            echo '<br>';
                            echo '<br>';
                        }
                    }
                    $count++;
                    if ($compteur <= 1){
                        
                        /////////////////////////////////
                        //IF FORM'S SUBMIT BUTTON PRESS//
                        if (!empty($_POST['envoyer'])) {	
                        /////////////////////////////////
                            
                            /////////////////////////////////////////////
                            //GET COUNT OF ROW IN ps_product_customized//
                            $query = 'SELECT count(id_product) as id FROM ps_product_customized WHERE id_product = '.$id_product.'';
                            $results = $mysqli->query($query);
                            $row = mysqli_fetch_assoc($results);
                            /////////////////////////////////////////////
                            
                            echo '<br>';

                            ////////////////////////////////////////////
                            //GET COUNT OF ROW IN ps_cdesigner_cfields//
                            $query = 'SELECT count(id_product) as num FROM ps_cdesigner_cfields WHERE id_product = '.$id_product.'';
                            $results = $mysqli->query($query);
                            $ligne = mysqli_fetch_assoc($results);
                            ////////////////////////////////////////////

                            if($row != 0){
                                
                                ///////////////////////////////////////////////////////////////
                                //IF THERE ARE ROW IN ps_product_customized EXEC UDPATE ON DB//
                                echo'<br>';
                                $query = 'UPDATE `ps_product_customized` SET `active`= 1,`path`="'.$images.'",`date_upd`="'.date('Y-m-d H:i:s').'" WHERE id_product = "'.$id_product.'"';
                                $mysqli->query($query);
                                ob_start();
                                print_r($query);
                                echo'<br>';
                                ob_end_clean();
                                ///////////////////////////////////////////////////////////////                        

                                //////////////////////////////////
                                //WRITE THE QUERY INTO LOGS FILE//
                                Addlog($query);
                                // ///////////////////////////////
                                                                
                            }else{
                                
                                echo'<br>';

                                ///////////////////////////////////////////////////////////////////
                                //IF THERE ARE NOT ROW IN ps_product_customized EXEC INSERT ON DB//
                                //FORMATED QUERY//
                                $query = 'INSERT INTO `ps_product_customized` (`id_product`, `id_attribute_product`, `active`, `path`, `width`, `height`, `left`, `top`, `position`, `date_add`, `date_upd`)';
                                //CONCAT WITH QUERY//
                                $query .= "VALUES(" . $id_product . ", '0', '1', '" . $images . "', '100', '100', '0', '2', '".$compteur."', '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "')";
                                //EXEC QUERY//
                                $mysqli->query($query);
                                //////////////////////////////////////////////////////////////////

                                ob_start();
                                print_r($query);
                                echo'<br>';
                                ob_end_clean();

                                //////////////////////////////////
                                //WRITE THE QUERY INTO LOGS FILE//
                                Addlog($query);
                                //////////////////////////////////
                                
                            }
                            if ($ligne > 0){
                                
                                echo'<br>';

                                //////////////////////////////////////////////////////////////
                                //IF THERE ARE ROW IN ps_cdesigner_cfields EXEC UDPATE ON DB//
                                //FORMATED QUERY//
                                $query2 = 'UPDATE `ps_cdesigner_cfields` SET `id_product`= '.$id_product.',`image`="'.$images.'" WHERE id_product = "'.$id_product.'"';
                                //EXEC QUERY
                                $mysqli->query($query2);
                                //////////////////////////////////////////////////////////////

                                ob_start();
                                print_r($query2);
                                echo'<br>';   
                                ob_end_clean();

                                //////////////////////////////////
                                //WRITE THE QUERY INTO LOGS FILE//
                                Addlog($query);
                                //////////////////////////////////
                                
                            }else{
                                
                                //////////////////////////////////////////////////////////////////
                                //IF THERE ARE NOT ROW IN ps_cdesigner_cfields EXEC UDPATE ON DB//
                                echo'<br>';
                                $query2 = "INSERT INTO `ps_cdesigner_cfields` (`id_product`, `type_layout`, `type_color`, `type_image`, `type_perso`, `textarea`, `image`, `mask`, `active`, `image_2`, `mask_2`, `zone_1`, `zone_2`, `fonts`, `design_pre`, `design_pre_2`, `price_per_side`, `price_per_image`, `price_per_text`, `active_2`, `active_design`, `active_bg`, `allow_upload`, `allow_help`, `required_field`, `allow_zone`, `allow_comb`) ";
                                $query2 .= "VALUES (" . $id_product . ", 'free', 'all', 'all', '0', '', '" . $images . "', 'masque.png', 1, '', '', '0;0;100;100', '0;0;100;100', 'all', '', '', '0', '50', '50', 0, 0, 1, 1, 1, 0, 0, 0)";
                                $mysqli->query($query2);
                                ob_start();
                                print_r($query2);
                                echo'<br>';
                                ob_end_clean();
                                /////////////////////////////////////////////////////////////////

                                //////////////////////////////////
                                //WRITE THE QUERY INTO LOGS FILE//
                                Addlog($query);
                                //////////////////////////////////
                                
                            }
                            
                        }
                        $compteur++;
                    }
                    
                }else {}
            } 
            $nbid++;

            ///////////////////////////
            //IF THERE ARE id_product//
            if(isset($id_product)){
            ///////////////////////////

            ////////////////////////////////////////
            //GET ALL TYPE'S DATA OF AN id_product//  
            $query = 'SELECT type FROM `ps_product_customized_settings` WHERE id_product = '.$id_product.'';
            $results = $mysqli->query($query);
            ////////////////////////////////////////

                /////////////////////////////////
                //IF FORM'S SUBMIT BUTTON PRESS//
                if(!empty($_POST['envoyer'])){
                /////////////////////////////////

                    foreach ($type as $ty) {
                        if($row <= 0){

                            /////////////////////
                            //PREFORMATED QUERY//
                            $query = 'INSERT INTO `ps_product_customized_settings` (`id_product`, `id_attribute_product`, `type`, `value`, `date_add`, `date_upd`)';
                            /////////////////////
                            
                            if ($ty == 'pdf_orientation'){
                                ob_start();
                                echo'<pre>';
                                echo'pdf_orient : ';

                                /////////////////////
                                //CONCAT WITH QUERY//
                                $query .= "VALUES(" . $id_product . ", '0', '" . $ty . "', 'p', '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "')";
                                /////////////////////

                                echo $query;
                                ob_end_clean();

                                //////////////////////////////////
                                //WRITE THE QUERY INTO LOGS FILE//
                                Addlog($query);
                                //////////////////////////////////
                                
                            }if($ty == 'selected_materials') {
                                $mats = '["1","2"]';
                                ob_start();
                                echo'<pre>';
                                echo'mats : ';
                                
                                /////////////////////
                                //CONCAT WITH QUERY//
                                $query .= "VALUES(" . $id_product . ", '0', '" . $ty . "', '".$mats."' , '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "')";
                                /////////////////////
                                
                                echo $query;
                                ob_end_clean();
                                
                                //////////////////////////////////
                                //WRITE THE QUERY INTO LOGS FILE//
                                Addlog($query);
                                //////////////////////////////////
                                
                            }if ($ty == 'pdf'){
                                ob_start();
                                echo'<pre>';
                                echo'pdf :';
                                /////////////////////
                                //CONCAT WITH QUERY//
                                $query .= "VALUES(" . $id_product . ", '0', '" . $ty . "', 1, '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "')";
                                ////////////////////

                                echo $query;
                                ob_end_clean();
                                
                                //////////////////////////////////
                                //WRITE THE QUERY INTO LOGS FILE//
                                Addlog($query);
                                //////////////////////////////////
                                
                            }if ($ty == 'status' ){
                                ob_start();
                                echo'<pre>';
                                echo'status : ';
                                
                                /////////////////////
                                //CONCAT WITH QUERY//
                                $query .= "VALUES(" . $id_product . ", '0', '" . $ty . "', 1, '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "')";
                                ////////////////////
                                
                                echo $query;
                                ob_end_clean();

                                //////////////////////////////////
                                //WRITE THE QUERY INTO LOGS FILE//
                                Addlog($query);
                                //////////////////////////////////

                            }

                            ////////////////
                            //EXEC QUERIES//
                            $mysqli->query($query);                
                            ////////////////

                        }else{

                            /////////////////////
                            //PREFORMATED QUERY//
                            $query = 'UPDATE `ps_product_customized_settings` ';
                            /////////////////////
                            
                            if ($ty == 'pdf_orientation'){
                                ob_start();
                                echo'<pre>';
                                echo'pdf_orient : ';

                                /////////////////////
                                //CONCAT WITH QUERY//
                                $query .= "SET `type`=".$ty.",`value`='p',`date_add`='" . date('Y-m-d H:i:s') . "',`date_upd`='" . date('Y-m-d H:i:s') . "' WHERE id_product = ".$id_product." ";
                                /////////////////////
                                
                                echo $query;
                                ob_end_clean();

                                //////////////////////////////////
                                //WRITE THE QUERY INTO LOGS FILE//
                                Addlog($query);
                                //////////////////////////////////
                                
                            }if($ty =='selected_materials') {
                                ob_start();
                                echo'<pre>';
                                echo'mats : ';

                                /////////////////////
                                //CONCAT WITH QUERY//
                                $query .= "SET `type`=".$ty.",`value`='['1','2']',`date_add`='" . date('Y-m-d H:i:s') . "',`date_upd`='" . date('Y-m-d H:i:s') . "' WHERE id_product = ".$id_product." ";
                                /////////////////////
                                
                                echo $query;
                                ob_end_clean();
                                
                                //////////////////////////////////
                                //WRITE THE QUERY INTO LOGS FILE//
                                Addlog($query);
                                //////////////////////////////////
                                
                            }if($ty == 'pdf'){
                                ob_start();
                                echo'<pre>';
                                echo'pdf : ';

                                /////////////////////
                                //CONCAT WITH QUERY//
                                $query .= "SET `type`=".$ty.",`value`='1',`date_add`='" . date('Y-m-d H:i:s') . "',`date_upd`='" . date('Y-m-d H:i:s') . "' WHERE id_product = ".$id_product." ";
                                /////////////////////
                                
                                echo $query;
                                ob_end_clean();

                                //////////////////////////////////
                                //WRITE THE QUERY INTO LOGS FILE//                        
                                Addlog($query);
                                //////////////////////////////////
                                
                            }if($ty == 'status'){
                                ob_start();
                                echo'<pre>';
                                echo'status : ';

                                /////////////////////
                                //CONCAT WITH QUERY//
                                $query .= "SET `type`=".$ty.",`value`='1',`date_add`='" . date('Y-m-d H:i:s') . "',`date_upd`='" . date('Y-m-d H:i:s') . "' WHERE id_product = ".$id_product." ";
                                /////////////////////

                                echo $query;
                                ob_end_clean();

                                //////////////////////////////////
                                //WRITE THE QUERY INTO LOGS FILE//
                                Addlog($query);
                                //////////////////////////////////
                                
                            }

                            ////////////////
                            //EXEC QUERIES//
                            $mysqli->query($query);
                            ////////////////

                        }
                    }
                }
            }

            

            ////////////////////////////////////////////////////
            //GET ALL TYPE'S DATA OF AN id_customization_field//             
            $query = 'SELECT id_customization_field FROM ps_customization_field';
            $result = $mysqli->query($query);
            $ligne = mysqli_num_rows($result);
            ////////////////////////////////////////////////////

            /////////////////////
            //IF THERE ARE ROW//
            if ($ligne > 0) {
            /////////////////////
                
                while ($row = $result->fetch_assoc()) {

                    /////////////////
                    //FORMATE QUERY//
                    $sql = "INSERT INTO `ps_customization_field_lang` (`id_customization_field`, `id_lang`, `id_shop`, `name`)";
                    $sql .= "VALUES (" . $row['id_customization_field'] . ", '1', '1', 'test_text')";
                    /////////////////

                    //////////////////////////////////
                    //WRITE THE QUERY INTO LOGS FILE//
                    Addlog($sql);
                    //////////////////////////////////

                    /////////////////////////////////
                    //IF FORM'S SUBMIT BUTTON PRESS//
                    if(!isset($_POST['envoyer'])){
                        
                        //EXEC QUERIES//
                        $mysqli->query($sql);
                        
                        
                    }
                    /////////////////////////////////

                }
            }else{}   
            echo '</div>';
            unset($img);
            
        }

        if(isset($_POST['loadmore'])){ 
            $_POST['number'] += 5;                     
        }

        echo '</pre>';
        echo '<br>';

        if(isset($_POST['number'])){

            if($_POST['number'] >= $count ){
                
                echo 'NO MORE LINKED PRODUCT';
                
            }else{
            echo '<br>';
            echo '<div class="load" style="display:flex;justify-content:center;">';
            echo '<form action="" method="post"><input type="text" name="number" value="'. (isset($_POST['number']) ? $_POST['number'] : $a) .'" hidden ><input class="loadmore" type="submit" name="loadmore" value=""/></form>';
            echo '</div>';
            echo '<br>';
            }
        
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<pre>';
        echo 'log -> C:\wamp64\host\inject\logs.txt ';
        }else{
            echo '<br>';
            echo '<div class="load" style="display:flex;justify-content:center;">';
            echo '<form action="" method="post"><input type="text" name="number" value="'. (isset($_POST['number']) ? $_POST['number'] : $a) .'" hidden ><input class="loadmore" type="submit" name="loadmore" value=""/></form>';
            echo '</div>';
            echo '<br>';
            echo '<br>';
            echo '<br>';
            echo '<br>';
            echo '<pre>';
            echo 'log -> C:\wamp64\host\inject\logs.txt ';
        }
        fclose($file);
        unset($file);
        unset($data);
    }
        