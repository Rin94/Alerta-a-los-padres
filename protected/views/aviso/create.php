<?php
/* @var $this AvisoController */
/* @var $model Aviso */
?>

<?php
$this->breadcrumbs=array(
	
	'Create',
);

$this->menu=array(
	array('label'=>'List Aviso', 'url'=>array('index')),
	array('label'=>'Manage Aviso', 'url'=>array('admin')),
);
?>

<h2>Crear Aviso/Tarea</h2>




<?php $this->renderPartial('_form', array('model'=>$model)); ?>