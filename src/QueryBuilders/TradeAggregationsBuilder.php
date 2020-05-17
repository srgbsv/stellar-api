<?php


namespace ZuluCrypto\StellarSdk\QueryBuilders;


use ZuluCrypto\StellarSdk\Model\Asset;
use ZuluCrypto\StellarSdk\Model\TradeAggregations;
use ZuluCrypto\StellarSdk\Server;

class TradeAggregationsBuilder
{
    private $server;

    /**
     * @var Asset
     */
    protected $baseAsset;

    /**
     * @var Asset
     */
    protected $counterAsset;

    /**
     * @var int
     */
    protected $resolution;
    protected $offset;
    protected $limit;
    protected $cursor;
    protected $order;
    protected $startTime;
    protected $endTime;

    public function __construct(Server $server)
    {
        $this->cursor = 'now';
        $this->order = 'asc';
        $this->server = $server;
    }

    public function assets($baseAsset, $counterAssets)
    {
        $this->baseAsset = $baseAsset;
        $this->counterAsset = $counterAssets;
        return $this;
    }

    public function resolution($resolution)
    {
        $this->resolution = $resolution;
        return $this;
    }

    public function offset($offset)
    {
        $this->offset = $offset;
        return $this;
    }

    public function limit($limit)
    {
        $this->limit;
        return $limit;
    }

    public function cursor($cursor)
    {
        $this->cursor = $cursor;
        return $this;
    }

    public function order($order)
    {
        $this->order = $order;
        return $this;
    }

    public function call()
    {
        $params = [
            'base_asset_type' => $this->baseAsset->isNative ? 'native' : $this->baseAsset->type,
            'counter_asset_code' => $this->counterAsset->isNative ? 'native' : $this->counterAsset->type,
            'cursor' => $this->cursor
        ];
        if (!$this->baseAsset->isNative) {
            $params['base_asset_code'] = $this->baseAsset->code;
            $params['base_asset_issuer'] = $this->baseAsset->issuer;
            $params['base_asset_type'] = $this->baseAsset->type;
        }
        if (!$this->counterAsset->isNative) {
            $params['counter_asset_code'] = $this->counterAsset->code;
            $params['counter_asset_issuer'] = $this->counterAsset->issuer;
            $params['counter_asset_type'] = $this->counterAsset->type;
        }
        if ($this->order) {
            $params['order'] = $this->order;
        }
        if ($this->limit) {
            $params['limit'] = $this->limit;
        }
        if ($this->startTime) {
            $params['startTime'] = $this->startTime;
        }
        if ($this->endTime) {
            $params['endTime'] = $this->endTime;
        }
        if ($this->resolution) {
            $params['resolution'] = $this->resolution;
        }

        $url = "/trade_aggregations?" . http_build_query($params);
        print_r($url);
        $response = $this->server->getApiClient()->get($url);
        return TradeAggregations::getListFromRaw($response);
    }
}
