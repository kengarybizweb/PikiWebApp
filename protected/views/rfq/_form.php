<?php
/* @var $this RfqController */
/* @var $model Rfq */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'rfq-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>


    <div>
        <?php echo $form->labelEx($model, 'products'); ?>
        
        <?php  echo CHtml::activeCheckBoxList(
                $model, // The car model
                'product', // Contains the array of 'options' Id, used by this car model
                CHtml::listData(Product::model()->findAll(), 'id', 'name'), // To get ALL the possible options 
            array(
                'labelOptions'=>array('style'=>'display:inline'),
                'template' => '<div class="check-option">{input} {label}</div>',
                'separator' => '',
               )
                
                );
        ?>
        
        
        
        
        
        
        <?php echo $form->error($model, 'product'); ?>
    </div>




    <!--div class="row">
    <?php /* echo $form->labelEx($model,'userid'); ?>
      <?php echo $form->textField($model,'userid'); ?>
      <?php echo $form->error($model,'userid'); */ ?>
    </div-->

    <!--div class="row">
    <?php /* echo $form->labelEx($model,'created_date'); ?>
      <?php echo $form->textField($model,'created_date'); ?>
      <?php echo $form->error($model,'created_date'); */ ?>
    </div-->

    <div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->