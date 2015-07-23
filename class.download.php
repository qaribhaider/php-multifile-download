<?php

/**
 * PHP based multiple files download from URL class
 * 
 * Use this class to download multiple files from remote URLs to a directory, 
 * in a single request. The class uses cURL, so make sure it is installed
 * 
 * Copyright (C) 2015  Syed Qarib
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
class MultiDownload {

    private $urls;
    private $save_to = './downloads/';
    private $conn = array();
    private $fp = array();
    private $handle;

    public function __construct() {
        $this->handle = curl_multi_init();
    }

    /**
     * Set the dir where files should be downloaded
     * 
     * @param string $path Directory / Path
     */
    public function setSavePath($path) {
        $this->save_to = $path;
    }

    /**
     * Set URLs of the files to be downloaded
     * 
     * @param array $urls Links of files
     */
    public function setURLs($urls = array()) {
        $this->urls = $urls;
    }

    /**
     * Download the files
     */
    public function download() {
        $this->_prepare();

        do {
            $n = curl_multi_exec($this->handle, $active);
        } while ($active);

        $this->_clear();
    }

    /**
     * Loop through files array and prepare files to be 
     * downloaded
     */
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

    /**
     * Clear files handlers after download complete
     */
    private function _clear() {
        foreach ($this->urls as $i => $url) {
            curl_multi_remove_handle($this->handle, $this->conn[$i]);
            curl_close($this->conn[$i]);
            fclose($this->fp[$i]);
        }
        curl_multi_close($this->handle);
    }

}
