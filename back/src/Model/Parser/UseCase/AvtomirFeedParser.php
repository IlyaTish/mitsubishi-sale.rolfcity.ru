<?php


namespace App\Model\Parser\UseCase;

use SimpleXMLElement;

/**
 * Class AvtomirFeedParser
 * @package App\Model\Parser\UseCase
 */
class AvtomirFeedParser extends FeedParser {

    public function handle() {

        $xml = $this->getXml('http://www.avtomir.ru/skoda_xml/ready_155.xml');

        $items = [
            'brand' => (string) $xml->brand->attributes()->name,
            'models' => []
        ];

        /** @var SimpleXMLElement $model */
        foreach ($xml->brand->model as $model) {

            $modelName = (string) $model->attributes()->name;

            /** @var SimpleXMLElement $auto */
            foreach ($model->auto as $auto) {
                $items['models'][] = [
                    'id'         => (string) $auto->attributes()->id,
                    'name'       => $modelName,
                    'package'    => (string) $auto->attributes()->package,
                    'body'       => (string) $auto->attributes()->body,
                    'transm'     => (string) $auto->attributes()->transm,
                    'patrol'     => (string) $auto->attributes()->patrol,
                    'volume'     => (string) $auto->attributes()->volume,
                    'hp'         => (string) $auto->attributes()->hp,
                    'year'       => (string) $auto->attributes()->year,
                    'price'      => (string) $auto->attributes()->price,
                    'price_base' => (string) $auto->price_base,
                    'price_dop'  => (string) $auto->price_dop,
                    'color'      => [
                        'code' => (string) $auto->color->attributes()->code,
                        'name' => (string) $auto->color->attributes()->name
                    ]
                ];
            }
        }

        $this->saveJson('feed.json', $items);
    }
}