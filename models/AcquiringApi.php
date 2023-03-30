<?php

namespace common\modules\vladbigun\monobank\models;
use yii\helpers\Url;
use Yii;
use yii\base\Model;
use yii\httpclient\Client;
use yii\web\UrlManager;

class AcquiringApi extends Model
{
    private $token = '*';
//    private $token = '*';
    private $api_url = 'https://api.monobank.ua/api/merchant/';
    public function createInvoice($cost, $qr_id = ""){
        $client = new Client();
        $data = [
            'amount' => intval($cost) * 100,
            'ccy' => 980,
            'redirectUrl' => Url::home(true) . 'thanks',
            'qrId' => $qr_id,
            'webHookUrl' => Url::home(true) . 'mono/processing',
        ];

        return $client->createRequest()
            ->setMethod('POST')
            ->addHeaders(['X-Token' => $this->token])
            ->setFormat(Client::FORMAT_JSON)
            ->setUrl($this->api_url . 'invoice/create')
            ->setData($data)
            ->send();
    }
    public function QrList()
    {
        $url = $this->api_url . 'qr/list';
        $client = new Client();

        $response = $client->createRequest()
            ->setMethod('GET')
            ->addHeaders(['X-Token' => $this->token])
            ->setFormat(Client::FORMAT_JSON)
            ->setUrl($url)
            ->send();
        return $response;
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
        ];
    }
}
