<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Users', 'url'=>array('index')),
	//array('label'=>'Manage User', 'url'=>array('admin')),
);
?>

<h1>Register an account</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>