<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="language" content="en">
        <?php Yii::app()->bootstrap->register(); ?>

        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>

        <div class="container" id="page">

            <div id="header">

            </div><!-- header -->

            <div id="mainmenu">
                <?php
                if (Yii::app()->user->getIsGuest()) {
                    $this->widget('bootstrap.widgets.TbNavbar', array(
                        'color' => TbHtml::NAVBAR_COLOR_INVERSE,
                        'brandLabel' => 'Estudiantes',
                        'collapse' => true,
                        'items' => array(
                            array('class' => 'bootstrap.widgets.TbNav',
                                'items' => array(
                                    array('label' => 'Ayuda', 'items' => array(
                                            array('label' => 'Contacto', 'url' => array('/site/contact')),
                                            array('label' => 'About', 'url' => array('/site/page', 'view' => 'about')),
                                        )),
                                    array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                                    array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
                                ),
                            ),
                        ),
                    ));
                } else if (Yii::app()->user->getState("role") == "Profesor") {
                    $this->widget('bootstrap.widgets.TbNavbar', array(
                        'color' => TbHtml::NAVBAR_COLOR_INVERSE,
                        'brandLabel' => 'Estudiantes',
                        'collapse' => true,
                        'items' => array(
                            array('class' => 'bootstrap.widgets.TbNav',
                                'items' => array(
                                    array('label' => 'Ayuda', 'items' => array(
                                            array('label' => 'Contacto', 'url' => array('/site/contact')),
                                            array('label' => 'About', 'url' => array('/site/page', 'view' => 'about')),
                                        )),
                                    array('label' => 'Grupo', 'items' => array(
                                            array('label' => 'Crear', 'url' => array('/grupo/create')),
                                            array('label' => 'Ver Grupos', 'url' => array('/grupo/admin')),
                                        )),
                                    array('label' => 'Avisos', 'items' => array(
                                            array('label' => 'Crear Aviso', 'url' => array('/aviso/create')),
                                            array('label' => 'Ver Aviso', 'url' => array('/aviso/admin')),
                                        )),
                                    array('label' => 'Alumno', 'items' => array(
                                            array('label' => 'Ver Alumnos', 'url' => array('/alumno/view')),
                                            array('label' => 'Ver Aviso', 'url' => array('/alumno/admin')),
                                        )),
                                    array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                                    array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
                                ),
                            ),
                        ),
                    ));
                } else if (Yii::app()->user->getState("role") == "Alumno") {
                    $this->widget('bootstrap.widgets.TbNavbar', array(
                        'color' => TbHtml::NAVBAR_COLOR_INVERSE,
                        'brandLabel' => 'Estudiantes',
                        'collapse' => true,
                        'items' => array(
                            array('class' => 'bootstrap.widgets.TbNav',
                                'items' => array(
                                    array('label' => 'Ayuda', 'items' => array(
                                            array('label' => 'Contacto', 'url' => array('/site/contact')),
                                            array('label' => 'About', 'url' => array('/site/page', 'view' => 'about')),
                                        )),
                                    array('label' => 'Grupo', 'items' => array(
                                            array('label' => 'Insccribirse a un Grupo', 'url' => array('/grupo/index')),
                                            array('label' => 'Ver Grupos', 'url' => array('/grupo/viewal')),
                                        )),
                                    array('label' => 'Avisos', 'items' => array(             
                                            array('label' => 'Ver Aviso', 'url' => array('/aviso/adminal')),
                                        )),
                                    array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                                    array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
                                ),
                            ),
                        ),
                    ));
                } else if (Yii::app()->user->getState("role") == "Tutor") {
                    $this->widget('bootstrap.widgets.TbNavbar', array(
                        'color' => TbHtml::NAVBAR_COLOR_INVERSE,
                        'brandLabel' => 'Estudiantes',
                        'collapse' => true,
                        'items' => array(
                            array('class' => 'bootstrap.widgets.TbNav',
                                'items' => array(
                                    array('label' => 'Ayuda', 'items' => array(
                                            array('label' => 'Contacto', 'url' => array('/site/contact')),
                                            array('label' => 'About', 'url' => array('/site/page', 'view' => 'about')),
                                        )),
                                    array('label' => 'Grupo', 'items' => array(
                                            array('label' => 'Crear', 'url' => array('/grupo/create')),
                                            array('label' => 'Ver Grupos', 'url' => array('/grupo/admin')),
                                        )),
                                    array('label' => 'Avisos', 'items' => array(
                                            array('label' => 'Crear Aviso', 'url' => array('/aviso/create')),
                                            array('label' => 'Ver Aviso', 'url' => array('/aviso/admin')),
                                        )),
                                    array('label' => 'Alumno', 'items' => array(
                                            array('label' => 'Ver Alumnos', 'url' => array('/alumno/view')),
                                            array('label' => 'Ver Aviso', 'url' => array('/alumno/admin')),
                                        )),
                                    array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                                    array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
                                ),
                            ),
                        ),
                    ));
                }
                ?>

            </div><!-- mainmenu -->
                <?php if (isset($this->breadcrumbs)): ?>
                    <?php
                    $this->widget('bootstrap.widgets.TbBreadcrumb', array(
                        'links' => $this->breadcrumbs,
                    ));
                    ?><!-- breadcrumbs -->
                <?php endif ?>

                <?php echo $content; ?>

            <div class="clear"></div>

            <div id="footer">
                Copyright &copy; <?php echo date('Y'); ?> UAZ.<br/>
                Made by Jared Salinas 
                All Rights Reserved.<br/>
                <?php echo Yii::powered(); ?>
            </div><!-- footer -->

        </div><!-- page -->

    </body>
</html>
