<?php
/* @var $this RfqController */
/* @var $model Rfq */

$this->breadcrumbs=array(
	'Rfqs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Rfq', 'url'=>array('index')),
	array('label'=>'Create Rfq', 'url'=>array('create')),
	array('label'=>'View Rfq', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Rfq', 'url'=>array('admin')),
);
?>

<h1>Update Rfq <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>