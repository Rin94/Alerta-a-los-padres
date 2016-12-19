<?php
/* @var $this GrupoController */
/* @var $model Grupo */


$this->breadcrumbs = array(
    'Grupos' => array('index'),
    'inscritos',
);

$this->menu = array(
    array('label' => 'List Grupo', 'url' => array('index')),
    array('label' => 'Create Grupo', 'url' => array('create')),
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

<h2>Grupos que está inscrito</h2>

</div><!-- search-form -->

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'grupo-grid',
    'type' => TbHtml::GRID_TYPE_CONDENSED,
    'dataProvider' => $model->searchPorAlumno(),
    'filter' => $model,
    'columns' => array(
        'nombre',
        array(
            'name' => 'grado_id',
            'value' => '$data->grado->rango',
            'filter' => Grado::model()->getListGrado(),
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{add}',
            'buttons' => array(
        'add' => array
            (
            'label' => 'ver tareas',
            'icon' => 'plus',
            'url' => 'Yii::app()->createUrl("grupo/vertask", array("id"=>$data->id))',
            'options' => array(
                'class' => 'btn btn-small',
            ),
        ),
                ),
    
        ),
    ),
));
?>