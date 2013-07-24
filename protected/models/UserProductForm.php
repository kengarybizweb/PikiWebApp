<?php

/**
 * ProductUserForm class.
 * ProductUserForm is the data structure for keeping
 * the form data related to adding an existing user to a product. It is used by the 'Ad-duser' action of 'ProductController'.
 */
class UserProductForm extends CFormModel {

    /**
     * @var string username of the user being added to the project
     */
    public $productname;
    public $products;
    /**
     * @var object an instance of the User AR model class
     */
    public $user;
    private $_product;

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
        );
    }
    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'products' => array(self::HAS_MANY, 'Product', 'id'),
        );
    }

    public function assign($productId) {
        $product = Product::model()->findByPk($productId);
        if ($this->user->isProductAssignedToCurrentUser($product)) {
            $this->addError('', 'This product has already been associated with user.');
            return true;
        } else {
            $this->_product = $product;
        }

        if ($this->_product instanceof Product) {
            $this->user->assignProduct($this->_product->id);
            return true;
        } else {
            $this->addError('productname', 'Error when attempting to assign the products to the user.');
            return false;
        }
    }

    /**
     * Generates an array of emails to use for the autocomplete
     */
    public function createProductList() {

        $sql = "SELECT name FROM piki_product";
        $command = Yii::app()->db->createCommand($sql);
        $rows = $command->queryAll();
        //format it for use with auto complete widget
        $products = array();
        foreach ($rows as $row) {
            $products[] = $row['products'];
        }
        return $products;
    }

}

?>
