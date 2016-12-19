<?php
/* @var $this AvisoController */
/* @var $model Aviso */
?>

<?php
$this->breadcrumbs=array(
	'Avisos'=>array('index'),
	' '.$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Aviso', 'url'=>array('index')),
	array('label'=>'Create Aviso', 'url'=>array('create')),
	array('label'=>'View Aviso', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Aviso', 'url'=>array('admin')),
);
?>

    <h2>Editar Aviso <?php echo $model->id; ?></h2>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>