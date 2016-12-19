<?php
/* @var $this GrupoController */
/* @var $dataProvider CActiveDataProvider */
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>

<?php
$this->breadcrumbs = array(
    'Grupos',
);

$this->menu = array(
    array('label' => 'Create Grupo', 'url' => array('create')),
    array('label' => 'Manage Grupo', 'url' => array('admin')),
);
?>

<h2>Grupos</h2>

<form method="get">
<input type="search" placeholder="Buscar" name="q" 

value="<?=isset($_GET['q']) ? CHtml::encode($_GET['q']) : '' ; 

?>" />
<input type="submit" value="Buscar" />
</form>

<?php
$this->widget('bootstrap.widgets.TbListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
));
?>

<?php
$this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'myModal',
    'footer' => implode(' ', array(
        TbHtml::button('Close', array('data-dismiss' => 'modal')),
    )),
));
?>

<script type="text/javascript">
 
    // this will open the Modal with the given id
    function openModal( id, header, body){
        var closeButton = '<button data-dismiss="modal" class="close" type="button">×</button>';
 
        $("#" + id + " .modal-header").html( closeButton + '<h3>'+ header + '</h3>');
        $("#" + id + " .modal-body").html(body);
     // $("#" + id + " .modal-footer").html(footer data); // you can also change the footer
        $("#" + id).modal("show");
    }
 
</script>