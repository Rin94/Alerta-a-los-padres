<?php
/* @var $this AvisoController */
/* @var $model Aviso */
?>

<?php

$this->breadcrumbs = array(
    'Avisos'=>array('index'),
    
    $model->id,
);

$this->menu = array(
    array('label' => 'List Aviso', 'url' => array('index')),
    array('label' => 'Create Aviso', 'url' => array('create')),
    array('label' => 'Update Aviso', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete Aviso', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Aviso', 'url' => array('admin')),
);
?>

<h2>Aviso/Tarea #<?php echo $model->id; ?></h2><br/>

<div >
    <legend>
        <fieldset bgcolor="#FFFACD">
            <center>
                <h3><b><?php echo CHtml::encode($model->getAttributeLabel('titulo')); ?></b></h3>
                <p><?php echo $model->titulo ?></p> 
            </center>  
            <div>
                <p>
                    <b><?php echo CHtml::encode($model->getAttributeLabel('materia_id')) . ":</b> " . $model->materia->nombre; ?>
                        <b><?php echo CHtml::encode($model->getAttributeLabel('grupo_id')) . ":</b> " . $model->grupo->nombre; ?>
                            </p> 
                            <rigth>
                                <?php echo TbHtml::dateField("nombre", $model->fecha_publicacion, array('prepend' => "Publicado", 'span' => 2)); ?>
                                <?php echo TbHtml::dateField("nombre", $model->fecha_entrega, array('prepend' => "Entregar", 'span' => 2)); ?>          
                            </rigth>             
                            </div>
                            <p><b><?php echo CHtml::encode($model->getAttributeLabel('descripcion')); ?>:</b></p>
                            <p><?php echo TbHtml::well($model->descripcion); ?></p>
                            <br/>

                            <?php
                            $conteo = Adjunto::model()->count("aviso_id=$model->id");
                            if (Adjunto::model()->count("aviso_id=$model->id") > 0) {
                                $rutas = Adjunto::model()->findAll("aviso_id=$model->id");
                                $nombreGrupo = $model->grupo->nombre;
                                echo "<b> " . CHtml::encode($model->getAttributeLabel('adjuntos')) . ":</b> <br/>";
                                foreach ($rutas as $value) {
                                    # ICON_FILE
                                    #echo TbHtml::submitButton("Ver material",array('onclick' => 'window.open("../adjuntos/'$nombreGrupo.'/"'.$value->nombre.'","","height=800,width=600"'));
                                    echo TbHtml::link(TbHtml::icon(TbHtml::ICON_FILE) .$value->nombre, "../adjuntos/$nombreGrupo/" . $value->nombre . "") . "<br/>";
                                }
                            } else {
                                echo "No hay material que mostras";
                            }
                            ?>

                            </fieldset>

                            </legend>




</div>

