<?php


namespace app\modules\models;


use app\modules\models\Model;
use Yii;
use yii\base\BaseObject;
use yii\base\BootstrapInterface;
use yii\db\Query;
use yii\web\UrlManager;

class ParamsForm extends Model
{
    public $name;
    public $value;

    public static function getParams(){
       $params=Params::find()->all();
       foreach ($params as $param){
           Yii::$app->params[$param['name']]=$param['value'];
       }

    }


    /**
     *  constructor.
     *
     * @param Params $param
     */

    public function __construct(Params $param)
    {
        parent::__construct($param);
        $this->setAttributes($this->_entity->getAttributes(), false);
    }

    public function rules()
    {
        return [
            [['name', 'value'], 'required'],
            ['name', 'string', 'length' => [3, 30]],
            [['name'], 'unique', 'targetAttribute' => 'name', 'targetClass' => Params::class,
                'message' => 'This {attribute} is already exists',
                'when' => function ($model) {
                    $count = Params::find()->where(['name' => $model->name])->count();

                    if ($count > 1 && !$this->isNewRecord) {
                        return true;
                    } elseif (Params::find()->where(['name' => $model->name])->exists() && $this->isNewRecord) {
                        return true;
                    }
                    return false;
                }
            ],
        ];
    }

    public function save()
    {

        if (!$this->validate()) {
            return false;
        }

        /** @var Params $param */
        $param = $this->_entity;
        $param->name = $this->name;
        $param->value = $this->value;

        if ($param->save()) {
            return true;
        }

        return false;
    }

    public static function multiUpdate($post_params)
    {

        $id_params = Params::find()->select(['id'])->all();
        $check_name_params = [];
        $sql = '';

        foreach ($id_params as $id_param) {
            $name = $post_params['name' . $id_param['id']];
            if (in_array($name, $check_name_params)) {
                return false;
            }
            $value=$post_params['value' . $id_param['id']];
           if (empty(str_replace(' ', '',$value))|| empty(str_replace(' ', '',$name))){
              return false;
           }
            $check_name_params[] = $name;
            $name = '"' . $name . '"';
            $value = '"' . $post_params['value' . $id_param['id']] . '"';
            $sql .= 'UPDATE params SET `name` = ' . $name . ',' . '`value`= ' . $value . ' WHERE `id` =' . $id_param['id'] . ';';
        }

        $result = Yii::$app->db->createCommand($sql)->execute();

        return true;
    }
}