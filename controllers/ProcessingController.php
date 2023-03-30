<?php

namespace common\modules\vladbigun\monobank\controllers;

use dvizh\order\models\Order;
use Yii;
use yii\rest\Controller;

/**
 * Default controller for the `api` module
 */
class ProcessingController extends Controller
{
    /**
     * Renders the index view for the module
     * @return boolean
     */
    public function actionIndex()
    {
        $post = Yii::$app->request->post();

        if ($post['status'] == 'success') {
            $order = Order::find()->andWhere(['address' => $post['invoiceId']])->one();
            $order->payment = "yes";
            $order->save();
        }
        return true;
    }
}
