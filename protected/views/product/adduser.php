<?php
$this->pageTitle = Yii::app()->name . ' - Add User To Product';
$this->breadcrumbs = array(
    $model->product->name => array('view', 'id' => $model->product->id), 'Add User',);
$this->menu = array(
    array('label' => 'Back To Product', 'url' => array('view', 'id' => $model->product->id)),);
?>
<h1>Add User To <?php echo $model->product->name; ?></h1>
<?php if (Yii::app()->user->hasFlash('success')): ?>
    <div class="successMessage">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>
<div class="form">
    <?php $form = $this->beginWidget('CActiveForm'); ?>
    <p class="note">Fields with <span class="required">*</span> are
        required.</p>
    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
            'name' => 'email',
            'source' => $model->createEmailList(),
            'model' => $model,
            'attribute' => 'email',
            'options' => array(
                'minLength' => '2',
            ),
            'htmlOptions' => array(
                'style' => 'height:20px;'
            ),
        ));
        ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'role'); ?>
        <?php
        echo $form->dropDownList($model, 'role', Product::getUserRoleOptions());
        ?>
        <?php echo $form->error($model, 'role'); ?>
    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Add User'); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>