<?php
/* @var $this RfqController */
/* @var $model Rfq */

$this->breadcrumbs=array(
	'Rfqs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Rfq', 'url'=>array('index')),
	array('label'=>'Manage Rfq', 'url'=>array('admin')),
);
?>

<h1>New Rfq</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>