<?php

/**
 * This is the model class for table "piki_user".
 *
 * The followings are the available columns in table 'piki_user':
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $company_name
 * @property string $business_reg_id
 *
 * The followings are the available model relations:
 * @property Rfq[] $rfqs
 * @property RfqProductAssignment[] $pikiRfqProductAssignments
 * @property Product[] $pikiProducts
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'piki_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, password, company_name, business_reg_id', 'required'),
			array('email, password, company_name, business_reg_id', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, email, password, company_name, business_reg_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'rfqs' => array(self::HAS_MANY, 'Rfq', 'userid'),
			'pikiRfqProductAssignments' => array(self::MANY_MANY, 'RfqProductAssignment', 'piki_rfq_product_user_assignment(userid, rfqproductid)'),
			'pikiProducts' => array(self::MANY_MANY, 'Product', 'piki_user_product_assignment(userid, productid)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'Email',
			'password' => 'Password',
			'company_name' => 'Company Name',
			'business_reg_id' => 'Business Reg',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('business_reg_id',$this->business_reg_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}