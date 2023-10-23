<?php


namespace app\modules\controllers;


use app\modules\models\Model;
use app\modules\models\Params;
use app\modules\models\ParamsForm;
use Yii;
use yii\base\BaseObject;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\web\HttpException;

class ParamsController extends BasickController
{

    public function actionPushParams()
    {
        $this->view->title = 'Push params';

        $params = Params::find()->all();

        $model = new ParamsForm(new Params());

        return $this->render('index', ['params' => $params,'model'=>$model]);
    }

    /**
     * @throws \ImagickException
     */
    public function actionAddParam()
    {
        $param = new ParamsForm(new Params());

        if ($this->isPost()) {
            if ($param->load($this->post()) && $param->save()) {
                $this->setFlash('success', 'param  ' . Html::encode($param->name) . ' successfully added');
                return $this->redirect(Url::toRoute(['params/push-params']));
            }
            $this->setFlash('error', 'Error parameter names should not be repeated');
            return $this->redirect(Url::toRoute(['params/push-params']));
        }

        return $this->redirect(Url::toRoute(['params/push-params']));
    }

    /**
     * @throws \ImagickException
     */
    public function actionEditParams()
    {
        if($this->isPost()){
            $post_params=$this->post();

            if(ParamsForm::multiUpdate($post_params)){
                $this->setFlash('success', 'Params  successfully edit');
                return $this->redirect(Url::toRoute(['params/push-params']));
            }
            $this->setFlash('error', 'Error parameter names should not be repeated');
            return $this->redirect(Url::toRoute(['params/push-params']));
        }
        $this->setFlash('error', 'Error update');
        return $this->redirect(Url::toRoute(['params/push-params']));
    }

    public function actionDeleteParam()
    {

        $id = $this->getInt('id');
        if (!$id) {
            throw new HttpException(404);
        }
        $param_model = Params::findOne($id);

        if (!$param_model) {
            throw new HttpException(404);
        }

        $count = Params::deleteAll(['id' => $id]);
        if ($count>0){
            $this->setFlash('success', 'param ' . Html::encode($param_model->name) . ' successfully deleted');
            return $this->redirect(Url::toRoute(['params/push-params']));
        }

        $this->setFlash('error', 'Error delete');
        return $this->redirect(Url::toRoute(['params/push-params']));
    }
}