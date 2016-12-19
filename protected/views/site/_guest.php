<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    $this->widget('bootstrap.widgets.TbHeroUnit', array(
        'heading' => 'Notifica',
        'htmlOptions' => array(
            
        // "style"=>"background-image: https://cdn0.iconfinder.com/data/icons/education-6/501/Education_7-512.png",
        ),
        'content' => '<p>Entera a los padres de tus a alumnos o enterate de las tareas'
        . ' de tus hijos ahora mismo!!! </p><p><b>Registrate</b></p>' .
        TbHtml::submitButton('Maestro', array(
            'color' => TbHtml::BUTTON_COLOR_DANGER,
            'onclick' => 'window.open("usuario/create")',
            'size' => TbHtml::BUTTON_SIZE_LARGE,  
            'block' => true)  
                )."</br>".
        TbHtml::submitButton('Padres ', array(
            'color' => TbHtml::BUTTON_COLOR_DANGER,
            'onclick' => 'window.open("usuario/createPadre")',
            'size' => TbHtml::BUTTON_SIZE_LARGE,
            'block' => true))
            
   ) );
