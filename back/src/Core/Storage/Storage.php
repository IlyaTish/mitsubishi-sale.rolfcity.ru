<?php


namespace App\Core\Storage;


/**
 * Class Storage
 * @package App\Core\Storage
 */
class Storage {

    protected $storagePath;

    /**
     * Storage constructor.
     */
    public function __construct() {
        $this->storagePath = storage_path();
    }

    /**
     * @param $path
     * @return false|string
     */
    public function get($path) {
        return file_get_contents($this->getPath($path));
    }

    /**
     * @param $path
     * @return string
     */
    public function getPath($path) {
        return $this->storagePath . DIRECTORY_SEPARATOR . $path;
    }

    /**
     * @param $path
     * @param $data
     * @return bool|int
     */
    public function save($path, $data) {
        return file_put_contents($this->getPath($path), $data);
    }

}