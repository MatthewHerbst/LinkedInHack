<?php


$data = $_GET;


foreach($data as $package) {

    if(file_exists('./packages.'.$package)) {
        print_r($package);
    }

}




?>
