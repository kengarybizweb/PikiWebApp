<?php
/* @var $this RfqController */
/* @var $model Rfq */

$this->breadcrumbs=array(
	'Rfqs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Rfq', 'url'=>array('index')),
	array('label'=>'Create Rfq', 'url'=>array('create')),
	array('label'=>'Update Rfq', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Rfq', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Rfq', 'url'=>array('admin')),
);
?>

<h1>View Rfq #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'userid',
		'created_date',
	),
)); ?>
