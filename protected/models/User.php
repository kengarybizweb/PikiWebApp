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
 * @property string $role
 *
 * The followings are the available model relations:
 * @property Rfq[] $rfqs
 * @property RfqProductAssignment[] $pikiRfqProductAssignments
 * @property TblAuthItem $role0
 * @property Product[] $pikiProducts
 */
class User extends CActiveRecord {

    public $products;
    public $preselectedproductids;

    /**
     * @var object an instance of the User AR model class
     */
    //public $user;
    private $_product;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'piki_user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email, password, company_name, business_reg_id', 'required'),
            array('email, password, company_name, business_reg_id', 'length', 'max' => 255),
            array('role', 'in', 'range' => array('member', 'owner', 'reader', 'admin'), 'allowEmpty' => false),
            array('id, email, password, company_name, business_reg_id, role', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'rfqs' => array(self::HAS_MANY, 'Rfq', 'userid'),
            'pikiRfqProductAssignments' => array(self::MANY_MANY, 'RfqProductAssignment', 'piki_rfq_product_user_assignment(userid, rfqproductid)'),
            'role0' => array(self::BELONGS_TO, 'TblAuthItem', 'role'),
            'pikiProducts' => array(self::MANY_MANY, 'Product', 'piki_user_product_assignment(userid, productid)', 'index' => 'id'),
            'products' => array(self::MANY_MANY, 'Product', 'piki_user_product_assignment(userid, productid)', 'index' => 'id'),
        );
    }

    public function afterFind() {
        $this->preselectedproductids = array_keys($this->products);
        parent::afterFind();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'company_name' => 'Company Name',
            'business_reg_id' => 'Business Reg',
            'role' => 'Role',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('company_name', $this->company_name, true);
        $criteria->compare('business_reg_id', $this->business_reg_id, true);
        $criteria->compare('role', $this->role, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Generates the password hash.
     * @param string password
     * @return string hash
     */
    public function hashPassword($password) {
        return md5($password);
        // return crypt($password, $this->generateSalt());
    }

    /**
     * Apply a hash on the password before we store it in the database
     */
    protected function afterValidate() {
        parent::afterValidate();
        if (!$this->hasErrors())
            $this->password = $this->hashPassword($this->password);
    }

    /**
     * Checks if the given password is correct.
     * @param string the password to be validated
     * @return boolean whether the password is valid
     */
    public function validatePassword($password) {
        return $this->hashPassword($password) === $this->password;
        //return crypt($password,$this->password)===$this->password;
    }

    public function assign($productId) {
        $product = Product::model()->findByPk($productId);
        $this->_product = $product;
        if ($this->_product instanceof Product) {
            $this->assignProduct($this->_product->id);
            return true;
        } else {
            $this->addError('productname', 'Error when attempting to assign the products to the user.');
            return false;
        }
    }

    public function assignProduct($productid) {
        $command = Yii::app()->db->createCommand();
        $command->insert('piki_user_product_assignment', array(
            'userid' => Yii::app()->user->id,
            'productid' => $productid,
            'role' => 'owner',
        ));
    }

    public function removeProduct($productid) {
        $command = Yii::app()->db->createCommand();
        $commmand->delete('piki_user_product_assignment', 'userid=:userid AND productid=:productid', array(
            ':userid' => Yii::app()->user->id,
            ':productid' => $productid,
        ));
    }

    /*
     * Determines whether or not a user is already part of a project
     */

    public function isProductAssignedToCurrentUser($productid) {
        $sql = "SELECT userid FROM piki_user_product_assignment WHERE productid=:productid AND userid=:userid";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":productid", $productid, PDO::PARAM_INT);
        $command->bindValue(":userid", Yii::app()->user->id, PDO::PARAM_INT);
        return $command->execute() == 1;
    }

}