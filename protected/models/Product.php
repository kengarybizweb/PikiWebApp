<?php

/**
 * This is the model class for table "piki_product".
 *
 * The followings are the available columns in table 'piki_product':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $parentid
 *
 * The followings are the available model relations:
 * @property Product $parent
 * @property Product[] $products
 * @property RfqProductAssignment[] $rfqProductAssignments
 * @property User[] $pikiUsers
 */
class Product extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Product the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'piki_product';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('parentid', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            array('description', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, description, parentid', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'parent' => array(self::BELONGS_TO, 'Product', 'parentid'),
            'products' => array(self::HAS_MANY, 'Product', 'parentid'),
            'rfqProductAssignments' => array(self::HAS_MANY, 'RfqProductAssignment', 'productid'),
            'pikiUsers' => array(self::MANY_MANY, 'User', 'piki_user_product_assignment(productid, userid)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'parentid' => 'Parentid',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('parentid', $this->parentid);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Assign an association between role, user, product
     */
    public function assignUser($userId, $role) {
        $command = Yii::app()->db->createCommand();
        $command->insert('piki_user_product_assignment', array(
            'role' => $role,
            'userid' => $userId,
            'productid' => $this->id,
        ));
    }

    /**
     * Remove an association between role, user, product
     */
    public function removeUser($userId) {
        $command = Yii::app()->db->createCommand();
        $command->delete(
                'piki_user_product_assignment', 'userid=:userId AND productid=:productId', array(':userId' => $userId, ':productId' => $this->id)
        );
    }

    public function allowCurrentUser($role) {
        $sql = "SELECT * FROM piki_user_product_assignment WHERE productid=:productId AND userid=:userId AND role=:role";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":productId", $this->id, PDO::PARAM_INT);
        $command->bindValue(":userId", Yii::app()->user->getId(), PDO::PARAM_INT);
        $command->bindValue(":role", $role, PDO::PARAM_STR);
        return $command->execute() == 1;
    }

    /**
     * Returns an array of available roles in which a user can be placed
      when being added to a product
     */
    public static function getUserRoleOptions() {
        return CHtml::listData(Yii::app()->authManager->getRoles(), 'name', 'name');
    }

    /*
     * Determines whether or not a user is already part of a project
     */

    public function isUserInProduct($user) {
        $sql = "SELECT userid FROM piki_user_product_assignment WHERE productid=:productId AND userid=:userId";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":productId", $this->id, PDO::PARAM_INT);
        $command->bindValue(":userId", $user->id, PDO::PARAM_INT);
        return $command->execute() == 1;
    }

}