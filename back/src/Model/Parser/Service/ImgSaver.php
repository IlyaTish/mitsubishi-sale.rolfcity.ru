<?php


namespace App\Model\Parser\Service;

use \Exception;
use Intervention\Image\Constraint;
use Intervention\Image\ImageManager;

class ImgSaver {

    private $imageManager;

    public function __construct(ImageManager $imageManager) {
        $this->imageManager = $imageManager;
    }

    public function saveByUrl($url, $name, $path, $width = null, $height = null, $ext = 'png') {

        try {
            $image = $this->imageManager->make($url);
        } catch (Exception $exception) {
            return null;
        }

        if($width || $height)
            $image->resize($width, $height, function (Constraint $constraint) {
                $constraint->aspectRatio();
            });

        if(!file_exists($path)) mkdir($path, 0777);

        $image->save($path . '/' . $name . '.' . $ext);
        return env('URL') .  '/back/image/' . $name;
    }
}