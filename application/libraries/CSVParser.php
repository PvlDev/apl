<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CSVParser {
    private $_file_handle;
    private $_delimiter = ";";

    function __construct($fileName = "")
    {
        if (empty($fileName))
            return;
        $this->_file_handle = @fopen($fileName, "r");
        if ($this->_file_handle === false)
            throw new Exception('Error! Cannot open file!');
        return true;
    }

    public function setDelimiter($str)
    {
        $this->_delimiter = $str;
    }

    public function getRow()
    {
        if ($data = fgetcsv($this->_file_handle, 1000, $this->_delimiter)) {
            return $data;
        } else {
            fclose($this->_file_handle);
            return false;
        }
    }
}