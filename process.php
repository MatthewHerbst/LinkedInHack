<?php


$data = $_POST['packages'];
$id   = $_POST['id'];


$manifest = '';

foreach($data as $package) {

    if(file_exists('./packages/')) {
	$read_file = file_get_contents('./packages/'.$package.'.pp');
	$manifest .= $read_file."\n\n";
    }

}


$puppet_file = './'.$id.'.pp';

file_put_contents($puppet_file, $manifest);


print_r($puppet_file);



?>
