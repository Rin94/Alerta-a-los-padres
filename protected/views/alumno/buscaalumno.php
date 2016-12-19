<?php
$this->breadcrumbs=array(
	'Alumnos',
);
?>
<form method="get">
<input type="search" placeholder="Buscar" name="q" 

value="<?=isset($_GET['q']) ? CHtml::encode($_GET['q']) : '' ; 

?>" />
<input type="submit" value="Buscar" />
</form>

<?php
//El objetivo va ser encontrar el alumno por el nombre,apellidos y que se muestren en el widget
$this->widget('bootstrap.widgets.TbListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
));

?>