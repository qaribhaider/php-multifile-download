# php-multifile-download
PHP based multiple files download from URL class 

Use this class to download multiple files from remote URLs to a directory, in a single request. The class uses cURL, so make sure it is installed

### Usage
Include Class
```sh
include './class.download.php';
```
Set files to download
```sh
$files_to_download = array(
    "http://lorempixel.com/output/nightlife-q-g-640-480-4.jpg",
    "http://lorempixel.com/output/abstract-q-c-640-222-1.jpg",
    "http://lorempixel.com/output/sports-h-g-640-800-7.jpg"
);
```
Download Files
```sh
$md = new MultiDownload();
$md->setSavePath("./downloads/");
$md->setURLs($files_to_download);
$md->download();
```
