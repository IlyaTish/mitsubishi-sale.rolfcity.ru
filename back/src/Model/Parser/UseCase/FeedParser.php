<?php


namespace App\Model\Parser\UseCase;

use App\Core\Storage\Storage;
use App\Exception\ParserException;
use App\Model\Parser\Service\ImgSaver;
use SimpleXMLElement;

/**
 * Class FeedParser
 * @package App\Model\Parser\UseCase
 */
abstract class FeedParser {

    /**
     * @var Storage
     */
    protected $storage;

    /**
     * @var ImgSaver
     */
    protected $imageSaver;

    /**
     * FeedParser constructor.
     * @param Storage $storage
     * @param ImgSaver $imageSaver
     */
    public function __construct(Storage $storage, ImgSaver $imageSaver) {
        $this->storage = $storage;
        $this->imageSaver = $imageSaver;
    }

    /**
     * @return mixed
     */
    abstract public function handle();

    /**
     * @param $feedPath
     * @return SimpleXMLElement
     */
    protected function getXml($feedPath) {
        if(!$xmlString = file_get_contents($feedPath))
            throw new ParserException('Фид не доступен или пуст');

        return simplexml_load_string($xmlString);
    }

    /**
     * @param $fileName
     * @param $items
     */
    protected function saveJson($fileName, $items) {
        $this->storage->save('parser/' . $fileName, json_encode($items, JSON_UNESCAPED_UNICODE));
    }
}