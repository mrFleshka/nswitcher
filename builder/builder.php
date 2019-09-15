<?php

function addDir($path){
    if(!is_dir($path)){
        mkdir($path);
    }
}

function process($pathFrom, $pathTo, $config){
    foreach($config as $suffix => $params){
        ob_start();
        include $pathFrom."/test.php";
        $fileTo = $pathTo."/test_".$suffix.".html";
        file_put_contents($fileTo, ob_get_clean());
        echo "File processed: ".$fileTo . PHP_EOL;
    }
}

$config = [
    'RU' => [
        'data' => "РУССКИЙ",
    ],
    'EN' => [
        'data' => "ENGLISH",
    ],
];

$buildPath = dirname(__DIR__) . "/build";
$path = dirname(__DIR__) . "/src";
if ($dirHandle = opendir($path)) {
    while(false !== ($file = readdir($dirHandle))){
        if ($file != '.' && $file != '..'){
            $srcFolder = $path.'/'.$file;
            if(is_dir($srcFolder)){
                $buildFolder = $buildPath."/".$file;
                addDir($buildFolder);
                process($srcFolder, $buildFolder, $config);
            }
        }
    }
    closedir($dirHandle);
}