<?php
namespace common\modules\vladbigun\monobank\widgets;

use common\modules\vladbigun\monobank\models\AcquiringApi;
use Yii;

class MonoPay extends \yii\base\Widget
{
    public $autoSend = true;
    public $orderModel;
    public $description = '';

    public function init()
    {
        parent::init();

        return true;
    }

    public function run()
    {
        $monoApi = new AcquiringApi();
        $request =  $monoApi->createInvoice($this->orderModel->cost);
        $data = $request->getData();
        if ($data['invoiceId']) {
            $jsonOrderInfo = $this->orderModel->order_info ? json_decode($this->orderModel->order_info, true) : [];

            $array_merge = array_merge($jsonOrderInfo, [
                'monoPayId' => $data['invoiceId'],
            ]) ;
            $this->orderModel->address = $data['invoiceId'];
            $this->orderModel->order_info = json_encode($array_merge);
            $this->orderModel->save();
        }
        if($data['pageUrl']){
            Yii::$app->response->redirect($data['pageUrl']);
        } else{
            return 'error generate payment';
        }
        return true;
    }
}
