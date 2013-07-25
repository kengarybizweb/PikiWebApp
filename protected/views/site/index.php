<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<h2>User Dashboard</h2>

<div><a href="?r=rfq/create">New RFQ</a></div>
<div><a href="?r=rfq/index">View RFQs History</a></div>
<div><a href="?r=user/addproduct">Edit Product Offering</a></div>
