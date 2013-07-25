<?php
$this->pageTitle = Yii::app()->name . ' - Add Products To User';
?>
<h1>Add Product To</h1>
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
        <?php echo $form->labelEx($model, 'products'); ?>
        <?php
        echo CHtml::activeCheckBoxList(
                $model, 'preselectedproductids', CHtml::listData(Product::model()->findAll(), 'id', 'name'), array(
            'labelOptions' => array('style' => 'display:inline'),
            'template' => '<div class="check-option">{input} {label}</div>',
            'separator' => '',
                )
        );
        // echo CHtml::checkBoxList(
        //'selectedproductids',
        //array_keys($model->products),
        //Chtml::listData(Product::model()->findAll(),'id','name')
        //);
        ?>
    </div>   
    <div class="row buttons">
<?php echo CHtml::submitButton('Submit Products'); ?>
    </div>
        <?php $this->endWidget(); ?>
</div>