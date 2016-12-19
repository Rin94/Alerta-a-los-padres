<?php
/* @var $this AvisoController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Avisos',
);

$this->menu=array(
	array('label'=>'Create Aviso','url'=>array('create')),
	array('label'=>'Manage Aviso','url'=>array('admin')),
);
?>

<h1>Avisos</h1>


<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>


