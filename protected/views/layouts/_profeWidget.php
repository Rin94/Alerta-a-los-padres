<?php
$this->widget('bootstrap.widgets.TbNavbar', array(
                    'color' => TbHtml::NAVBAR_COLOR_INVERSE,
                    'brandLabel' => 'Estudiantes',
                    'collapse' => true,
                    'items' => array(
                        array('class' => 'bootstrap.widgets.TbNav',
                            
                            'items' => array(
                                array('label' => 'Ayuda', 'items' => array(
                                        array('label' => 'Contacto', 'url' =>  array('/site/contact')),
                                        array('label' => 'About', 'url' => array('/site/page', 'view' => 'about')),
                                    
                                    )), 
                             'items' => array(
                                array('label' => 'Grupo', 'items' => array(
                                        array('label' => 'Crear', 'url' =>  array('/grupo/create')),
                                        array('label' => 'Ver Grupos', 'url' => array('/grupo/admin')),
                                    
                                    ))),
                                array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                                array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
                            ),
                        ),
                    ),
                ));
