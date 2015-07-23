<?php

class MultiDownload {

    private $urls;
    private $save_to = './downloads/';
    private $conn = array();
    private $fp = array();
    private $handle;

    public function __construct() {
        $this->handle = curl_multi_init();
    }

    public function setSavePath($path) {
        $this->save_to = $path;
    }

    public function setURLs($urls = array()) {
        $this->urls = $urls;
    }

    public function download() {
        $this->_prepare();

        do {
            $n = curl_multi_exec($this->handle, $active);
        } while ($active);

        $this->_clear();
    }

    private function _prepare() {
        foreach ($this->urls as $i => $url) {
            $save_file = $this->save_to . basename($url);
            $this->conn[$i] = curl_init($url);
            $this->fp[$i] = fopen($save_file, "wb");
            curl_setopt($this->conn[$i], CURLOPT_SSL_VERIFYPEER, FALSE);    // No certificate
            curl_setopt($this->conn[$i], CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($this->conn[$i], CURLOPT_FILE, $this->fp[$i]);
            curl_setopt($this->conn[$i], CURLOPT_HEADER, 0);
            curl_setopt($this->conn[$i], CURLOPT_CONNECTTIMEOUT, 60);
            curl_setopt($this->conn[$i], CURLOPT_MAXCONNECTS, 10);
            curl_multi_add_handle($this->handle, $this->conn[$i]);
        }
    }

    private function _clear() {
        foreach ($this->urls as $i => $url) {
            curl_multi_remove_handle($this->handle, $this->conn[$i]);
            curl_close($this->conn[$i]);
            fclose($this->fp[$i]);
        }
        curl_multi_close($this->handle);
    }

}
