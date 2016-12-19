<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->breadcrumbs=array(
	'Grupos'=>array('index'),
	'relacionar',
);

?>
<h2>Agrupar con alumno</h2>




<?php $this->renderPartial('_relacionar', array('model'=>$model)); ?>