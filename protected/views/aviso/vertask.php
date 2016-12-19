<?php
/* @var $this AvisoController */
/* @var $model Aviso */


$this->breadcrumbs=array(
	'Manage',
);

$this->menu=array(
	array('label'=>'List Aviso', 'url'=>array('index')),
	array('label'=>'Create Aviso', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#aviso-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h2>Ver Avisos/Tareas</h2>


<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'aviso-grid',
        'type' => TbHtml::GRID_TYPE_CONDENSED,
	'dataProvider'=>$model->searchAvisoPorGrupo(),
	'filter'=>$model,
        //'htmlOptions' => array('color' =>'width: 30px'),
	'columns'=>array(
		'titulo',
		'fecha_publicacion',
		'fecha_entrega',
                array(
                    'name'=>'materia_id',
                    'value'=>'$data->materia->nombre',
                    'filter'=>  Aviso::model()->getListMaterias(),
                    
                ),
               
                  array(
                    'name'=>'grupo_id',
                    'value'=>'$data->grupo->nombre',
                    'filter'=> Grupo::model()->encontrarGrupoPorGeneralAlumno(),  
                ),
		
		/*
		'grupo_id',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>