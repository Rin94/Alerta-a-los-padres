<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
/**
 * This is the model class for table "usuario".
 *
 * The followings are the available columns in table 'usuario':
 * @property integer $id
 * @property string $nick
 * @property string $contrasenia
 * @property string $correo
 * @property integer $tipo_id
 *
 * The followings are the available model relations:
 * @property Alumno[] $alumnos
 * @property Maestro[] $maestros
 * @property Padre[] $padres
 * @property Tipo $tipo
 */
class Usuario extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public $name;
        public $ap_pat;
        public $ap_mat;
        public $verifyCode;
        
	public function tableName()
	{
		return 'usuario';
	}
        
        public function validatePassword($password,$n){
            if (CPasswordHelper::verifyPassword($password, $n->contrasenia))
               return true;
                    
           else
                return false;    
        }
        public function hashPassword($password)
        {
            return CPasswordHelper::hashPassword($password);
        }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nick, contrasenia, correo, name, ap_pat', 'required'),
			array('tipo_id', 'numerical', 'integerOnly'=>true),
			array('nick, contrasenia, correo, name, ap_pat, ap_mat', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nick, contrasenia, correo, tipo_id', 'safe', 'on'=>'search'),
                        array('verifyCode', 'captcha', 'allowEmpty' => ! CCaptcha::checkRequirements()),
		);
	}
        
        public function beforeSave()
        {
          $this->contrasenia = CPasswordHelper::hashPassword($this->contrasenia);
          return parent::beforeSave();
        }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'alumnos' => array(self::HAS_MANY, 'Alumno', 'usuario_id'),
			'maestros' => array(self::HAS_MANY, 'Maestro', 'usuario_id'),
			'padres' => array(self::HAS_MANY, 'Padre', 'usuario_id'),
			'tipo' => array(self::BELONGS_TO, 'Tipo', 'tipo_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nick' => 'Nick',
			'contrasenia' => 'Contrasenia',
			'correo' => 'Correo',
			'tipo_id' => 'Tipo',
                        'name'=> 'Nombre',
                        'ap_pat'=>'Apellido Paterno',
                        'ap_mat'=>'Apellido Materno',
                        'verifyCode'=>'Código de verificación'
                    
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('nick',$this->nick,true);
		$criteria->compare('contrasenia',$this->contrasenia,true);
		$criteria->compare('correo',$this->correo,true);
		$criteria->compare('tipo_id',$this->tipo_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usuario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
