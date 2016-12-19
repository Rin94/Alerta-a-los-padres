<?php
/* @var $this GrupoController */
/* @var $model Grupo */
?>

<?php
$this->breadcrumbs=array(
	'Grupos'=>array('index'),
	'Create',
);

$this->menu=array(
        array('label'=>'Operaciones'),
	array('label'=>'List Grupo', 'url'=>array('index')),
	array('label'=>'Manage Grupo', 'url'=>array('admin')),
);
?>

<h2>Crear Grupo</h2>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>