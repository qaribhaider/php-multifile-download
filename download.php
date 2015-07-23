<?php

include './class.download.php';

$files_to_download = array(
    "http://lorempixel.com/output/nightlife-q-g-640-480-4.jpg",
    "http://lorempixel.com/output/abstract-q-c-640-222-1.jpg",
    "http://lorempixel.com/output/sports-h-g-640-800-7.jpg"
);

$md = new MultiDownload();
$md->setSavePath("./downloads/");
$md->setURLs($files_to_download);
$md->download();
