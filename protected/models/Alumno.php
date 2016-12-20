<?php

/**
 * This is the model class for table "alumno".
 *
 * The followings are the available columns in table 'alumno':
 * @property integer $id
 * @property string $nombre
 * @property string $apellido_pat
 * @property string $apellido_mat
 * @property integer $usuario_id
 *
 * The followings are the available model relations:
 * @property Usuario $usuario
 * @property Grupo[] $grupos
 * @property Padre[] $padres
 */
class Alumno extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'alumno';
    }

    private $fullName;
    public $padre_id;

    public function getFullName() {
        return $this->nombre . ' ' . $this->apellido_pat. ' '.$this->apellido_mat;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nombre, apellido_pat', 'required'),
            array('usuario_id', 'numerical', 'integerOnly' => true),
            array('nombre, apellido_pat, apellido_mat', 'length', 'max' => 45),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nombre, apellido_pat, apellido_mat, usuario_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'usuario' => array(self::BELONGS_TO, 'Usuario', 'usuario_id'),
            'grupos' => array(self::MANY_MANY, 'Grupo', 'alumno_has_grupo(alumno_id, grupo_id)'),
            'padres' => array(self::MANY_MANY, 'Padre', 'alumno_has_padre(alumno_id, padre_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'nombre' => 'Nombre',
            'apellido_pat' => 'Apellido Pat',
            'apellido_mat' => 'Apellido Mat',
            'usuario_id' => 'Usuario',
            'padre_id'=>'Padre',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('nombre', $this->nombre, true);
        $criteria->compare('apellido_pat', $this->apellido_pat, true);
        $criteria->compare('apellido_mat', $this->apellido_mat, true);
        $criteria->compare('usuario_id', $this->usuario_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function encontrarNiños($grupo) {
        $criteria = new CDbCriteria;
        $criteria->select = 't.id, t.nombre, t.apellido_pat, t.apellido_mat';
        $criteria->join = "JOIN alumno_has_grupo  ON t.id = alumno_has_grupo.alumno_id";
        $criteria->condition = "alumno_has_grupo.grupo_id = :value";
        $criteria->order = "t.nombre DESC";
        $criteria->params = array(":value" => $grupo);
        return $criteria;
    }
    
    public static function buscarNiñosXBuscador($nombre,$apPat,$apMat){
        //SELECT nombre, apellido_pat, apellido_mat from alumno
        //where lower(nombre)=lower('Dani') 
        //        and lower(apellido_pat)='Rodríguez' 
        //        and lower (apellido_mat)=lower('Ramos')
        $criteria= new CDbCriteria();
        $criteria->select = 't.id, t.nombre, t.apellido_pat, t.apellido_mat';
        $criteria->condition="ower(nombre)=lower('$nombre') and lower(apellido_pat)=('$apPat') and lower (apellido_mat)=lower('$apMat')";
        return $criteria;
        
    }

    public static function listarNiños($model) {
        return TbHtml::listData(
                        Alumno::model()->findAll(Alumno::model()->encontrarNiños($model->id))
                        , 'id', 'fullName');
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Alumno the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
