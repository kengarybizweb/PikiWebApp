<?php
/* @var $this ProductController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Products',
);

$this->menu=array(
	//array('label'=>'Create Product', 'url'=>array('create')),
	//array('label'=>'Manage Product', 'url'=>array('admin')),
);

if(Yii::app()->user->checkAccess('createProduct')){
    $this->menu[] = array('label'=>'Create Product', 'url'=>array('create'));
}
?>

<h1>Products</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
