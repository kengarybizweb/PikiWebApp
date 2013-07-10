<?php
/* @var $this RfqController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Rfqs',
);

$this->menu=array(
	array('label'=>'Create Rfq', 'url'=>array('create')),
	array('label'=>'Manage Rfq', 'url'=>array('admin')),
);
?>

<h1>Rfqs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
