<?php
/* @var $this GrupoController */
/* @var $model Grupo */


$this->breadcrumbs=array(
	'Grupos'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Grupo', 'url'=>array('index')),
	array('label'=>'Create Grupo', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#grupo-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h2>Ver Grupos</h2>


<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'grupo-grid',
        'type' => TbHtml::GRID_TYPE_CONDENSED,
	'dataProvider'=>$model->searchPorMaestro(),
	'filter'=>$model,
	'columns'=>array(
		'nombre',
		'contrasenia',
		array(
                    'name'=>'grado_id',
                    'value'=>'$data->grado->rango',
                    'filter'=> Grupo::model()->getListGrados(),   
                ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
                        'template'=>'{update}{delete}'
		),
	),
)); ?>