<?php
/**
 * @var $params \app\modules\models\Params[]
 * @var $model \app\modules\models\ParamsForm
 */


use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use app\Modules\models\Params;
use yii\bootstrap4\Modal;
use yii\helpers\Url;

?>
<div class="row">
    <div class="col-xs-12 col-md-4">
        <div class="form-group" style="float: left">
            <?php
            Modal::begin([
                'toggleButton' => [
                    'label' => 'Add param',
                    'tag' => 'button',
                    'class' => 'btn btn-primary',

                ],

            ]);
            ?> <?php $form = ActiveForm::begin(['id' => 'param-form', 'action' => ['add-param']]); ?>
            <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
            <?= $form->field($model, 'value')->textInput(['autofocus' => true])?>
            <div class="form-group" >
                <?= Html::submitButton('Add param',
                    ['class' => 'btn btn-primary',
                        'name' => 'param-button',]
                ) ?>
                <?php ActiveForm::end(); ?>
            </div>
            <?php Modal::end(); ?>
            <?= Html::beginForm('edit-params', 'post', ['enctype' => 'multipart/form-data']) ?>

        </div>
        <div class="form-group"  style="float: right" >
            <?= Html::submitButton('Save', ['class' => 'btn btn-mini btn-success']) ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-10">
        <div class="box box-body box-success">
            <div class="box-header">
                <h3 class="box-title">Params list</h3>
            </div>
            <div class="box-body no-padding">
                <div class="table-responsive">
                    <table id="table" class="table table-striped table-hover"  >
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Value</th>
                            <th class="text-left"><i class="fa fa-gear fa-lg"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($params)): ?>
                            <tr>
                                <td colspan="7" class="text-center">No apples was found</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($params as $param): ?>
                                <tr data-id="<?= $param['id'] ?>">
                                    <td> <?= Html::textInput('name'.$param['id'], $param['name'], ['id' => $param['id']]) ?></td>
                                    <td> <?= Html::textInput('value'.$param['id'], $param['value'], ['id' => $param['id']]) ?></td>
                                    <td class="text-left"><?= Html::a(
                                            'Delete',
                                            [
                                                'delete-param',
                                                'id' => $param['id'],

                                            ],

                                            [
                                                'class' => 'btn btn-mini btn-danger',
                                                'data' => [
                                                    'confirm' => 'Are you sure you want to delete this param: ' . $param['id'] . '?',                                                    'method' => 'post',
                                                ],
                                            ])
                                        ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= Html::endForm() ?>




