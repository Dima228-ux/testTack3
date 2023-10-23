<?php

namespace app\modules;

use app\modules\models\Params;
use yii\base\BootstrapInterface;

/**
 * param module definition class
 */
class Param extends \yii\base\Module implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $params=Params::find()->all();
        foreach ($params as $param){
            $app->params[$param['name']]=$param['value'];
        }

        $app->getUrlManager()->addRules(
            [
                'params'=>'param/params/push-params',
                'add-param' => 'param/params/add-param',
                'delete-param'=>'param/params/delete-param',
                'edit-params'=>'param/params/edit-params'

            ],false
        );
    }
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
