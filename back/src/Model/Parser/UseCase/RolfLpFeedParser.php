<?php

namespace App\Model\Parser\UseCase;

use SimpleXMLElement;

/**
 * Class RolfLpFeedParser
 * @package App\Model\Parser\UseCase
 */
class RolfLpFeedParser extends FeedParser {

    public function handle() {

        /** @var SimpleXMLElement $xml */
        $xml = $this->getXml('https://jlr-connect.com/carstock-export/api/v1/tandem_34638b88.xml');

        $items = [];

        /** @var SimpleXMLElement $offer */
        foreach ($xml->offers->offer as $offer) {

            $mark = (string) $offer->brand;
            $imgUrl = (string) $offer->images->image[0];
            $vin = (string) $offer->vin;

            if($mark !== 'LandRover' || empty($imgUrl) || empty($vin)) continue;

            $savedImageUrl = $this->imageSaver->saveByUrl(
                $imgUrl,
                $vin,
                $this->storage->getPath('parser/image'),
                null,
                177
            );

            if(empty($savedImageUrl)) continue;

            $items[] = [
                'mark' => $mark,
                'model' => (string) $offer->model,
                'complectation' => (string) $offer->complectation,
                'year' => (int) $offer->year,
                'body_type' => (string) $offer->body,
                'price' => (int) $offer->price,
                'transmission' => (string) $offer->transmission,
                'fuel' => (string) $offer->engine,
                'drive' => (string) $offer->drive,
                'horse_power' => (int) $offer->power,
                'volume' => (string) $offer->volume,
                'color' => (string) $offer->color,
                'vin' => (string) $offer->vin,
                'img' => $savedImageUrl
            ];
        }

        $this->saveJson('feed.json', $items);
    }
}