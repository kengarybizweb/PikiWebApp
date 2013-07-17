<?php

/**
 * This is the model class for table "piki_rfq_product_assignment".
 *
 * The followings are the available columns in table 'piki_rfq_product_assignment':
 * @property integer $id
 * @property integer $rfqid
 * @property integer $productid
 *
 * The followings are the available model relations:
 * @property Rfq $rfq
 * @property Product $product
 * @property User[] $pikiUsers
 */
class RfqProductAssignment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RfqProductAssignment the static model class
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
		return 'piki_rfq_product_assignment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rfqid, productid', 'required'),
			array('rfqid, productid', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, rfqid, productid', 'safe', 'on'=>'search'),
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
			'rfq' => array(self::BELONGS_TO, 'Rfq', 'rfqid'),
			'product' => array(self::BELONGS_TO, 'Product', 'productid'),
			'pikiUsers' => array(self::MANY_MANY, 'User', 'piki_rfq_product_user_assignment(rfqproductid, userid)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'rfqid' => 'Rfqid',
			'productid' => 'Productid',
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
		$criteria->compare('rfqid',$this->rfqid);
		$criteria->compare('productid',$this->productid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}