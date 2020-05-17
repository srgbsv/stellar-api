<?php

namespace ZuluCrypto\StellarSdk\Model;

use ZuluCrypto\StellarSdk\Horizon\Api\HorizonResponse;

class TradeAggregations
{
    private $timestamp;
    private $trade_count;
    private $base_volume;
    private $counter_volume;
    private $avg;
    private $high;
    private $low;
    private $open;
    private $close;

    /**
     * @param array
     * @return TradeAggregations
     */
    public static function fromHorizonResponse($response)
    {
        $object = new TradeAggregations();
        $object->timestamp = $response['timestamp'];
        $object->trade_count = $response['trade_count'];
        $object->base_volume = $response['base_volume'];
        $object->counter_volume = $response['counter_volume'];
        $object->avg = $response['avg'];
        $object->high = $response['high'];
        $object->low = $response['low'];
        $object->open = $response['open'];
        $object->close = $response['close'];
        return $object;
    }

    /**
     * @param $response
     *
     * @return array
     */
    public static function getListFromRaw(HorizonResponse $response)
    {
        $rawData = $response->getRawData();

        // 404 means the account does not currently exist (it may have been merged)
        if (isset($rawData['status']) && $rawData['status'] == 404) {
            throw new \InvalidArgumentException('Resource not found');
        }
        if (isset($rawData['status']) && $rawData['status'] == 400) {
            if (isset($rawData['extras']) && isset($rawData['extras']['reason'])) {
                throw new \InvalidArgumentException($rawData['extras']['reason']);
            }
            throw new \InvalidArgumentException('Unexpected error');
        }

        $records = $rawData['_embedded']['records'];
        $result = [];
        foreach ($records as $record) {
            print_r($record);
            $result[] = self::fromHorizonResponse($record);
        }
        return $result;
    }


}
