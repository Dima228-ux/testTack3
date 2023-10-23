<?php


namespace app\modules\models;

use yii\db\ActiveRecord;

/**
 * Class Params
 * @package app\models
 * @property int $id [int(11)]
 * @property string $name [varchar(255)]
 *  @property string $value[varchar(255)]
 */
class Params extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'params';
    }
}