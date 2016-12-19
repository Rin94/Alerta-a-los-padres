<?php
/* @var $this AvisoController */
/* @var $model Aviso */


$this->breadcrumbs = array(
    'Grupo' => array('index'),
    'inscritos'=>array('viewal'),
    'tareas',$model->id,
);

$this->menu = array(
    array('label' => 'List Aviso', 'url' => array('index')),
    array('label' => 'Create Aviso', 'url' => array('create')),
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


<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'aviso-grid',
    'type' => TbHtml::GRID_TYPE_CONDENSED,
    'dataProvider' => Aviso::model()->searchAvisoPorGrupo($model->id),
    //'htmlOptions' => array('color' =>'width: 30px'),
    'columns' => array(
        'titulo',
        'fecha_publicacion',
        'fecha_entrega',
        array(
            'name' => 'materia_id',
            'value' => '$data->materia->nombre',
            'filter' => Aviso::model()->getListMaterias(),
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{add}',
            'buttons' => array(
                
                'add' => array
                    (
                    'label' => 'ver tareas',
                    'icon' => 'plus',
                    'url' => 'Yii::app()->createUrl("aviso/view", array("id"=>$data->id))',
                    'options' => array(
                        'class' => 'btn btn-small',
                    ),
                ),
            )
        ),
    ),
));
?>