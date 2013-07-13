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


$puppet_file = './temp/'.$id.'.pp';

file_put_contents($puppet_file, $manifest);


$final_script = file_get_contents('installer');
$final_script = str_replace('{id}', $id, $final_script);

file_put_contents('./temp/'.$id, $final_script);

$final_file = "curl -s http://174.34.170.64/temp/$id > /tmp/wingscript; sudo bash /tmp/wingscript";


print_r($final_file);



?>
