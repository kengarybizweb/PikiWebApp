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


    <div class="row">
        <?php echo $form->labelEx($model, 'products'); ?>


        <br/><br/>

        <?php
        $tabArray = array();
        foreach ((Product::model()->listParentChild(0)) as $productparent) {
            array_push($tabArray, array(
                'label' => $productparent['name'],
                'content' => CHtml::activeCheckBoxList(
                        $model, 'products', CHtml::listData(Product::model()->listParentChild($productparent['id']), 'id', 'name'), array(
                    'labelOptions' => array('style' => 'display:inline'),
                    'template' => '<div class="check-option">{input} {label}</div>',
                    'separator' => '',
                        )
                ), 'active' => ($productparent['id'] == 1 ? true : false),
            ));
        }
        ?>   

        <?php
        $this->widget('bootstrap.widgets.TbTabs', array(
            'type' => 'tabs', // 'tabs' or 'pills'
            'placement' => 'left',
            'tabs' => $tabArray,
        ));
        ?>

        <?php
        echo $form->error($model, 'product');
        ?>
    </div>

    <div class="row buttons">
        <br/><br/>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->