<?php


namespace ZuluCrypto\StellarSdk\Model;


use ZuluCrypto\StellarSdk\Model\AssetAmount;

class Asset
{
    public $type;
    public $code;
    public $issuer;
    public $isNative;

    public function __construct($code = null, $issuer = null)
    {
        if ($code) {
            $this->type = strlen($code) > 4 ? AssetAmount::ASSET_TYPE_CREDIT_ALPHANUM12
                : AssetAmount::ASSET_TYPE_CREDIT_ALPHANUM4;
            $this->code = $code;
            $this->issuer = $issuer;
        } else {
            $this->isNative = true;
            $this->code = 'XLM';
        }
    }
}
