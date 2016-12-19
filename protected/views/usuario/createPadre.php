<?php
/* @var $this UsuarioController */
/* @var $model Usuario */
?>

<?php
$this->breadcrumbs=array(
	
	'Create',
);

$this->menu=array(
        array('label' => 'Operaciones'),
	array('label'=>'List Usuario', 'url'=>array('index')),
	array('label'=>'Manage Usuario', 'url'=>array('admin')),
);
?>

<h2>Registrarte</h2>


<?php $this->renderPartial('_form_1', array('model'=>$model)); ?>

