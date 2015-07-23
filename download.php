<?php

// Include Class
include './class.download.php';

// Set files to download
$files_to_download = array(
    "http://lorempixel.com/output/nightlife-q-g-640-480-4.jpg",
    "http://lorempixel.com/output/abstract-q-c-640-222-1.jpg",
    "http://lorempixel.com/output/sports-h-g-640-800-7.jpg"
);

// Initialize
$md = new MultiDownload();

// Set dir/path where you want files to be downloaded
$md->setSavePath("./downloads/");

// Point URLs
$md->setURLs($files_to_download);

// Finally, download files
$md->download();
