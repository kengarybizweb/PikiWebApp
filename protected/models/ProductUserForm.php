<?php

/**
 * ProductUserForm class.
 * ProductUserForm is the data structure for keeping
 * the form data related to adding an existing user to a product. It is used by the 'Ad-duser' action of 'ProductController'.
 */
class ProductUserForm extends CFormModel {

    /**
     * @var string email of the user being added to the product
     */
    public $email;

    /**
     * @var string the role to which the user will be associated within the product
     */
    public $role;

    /**
     * @var object an instance of the Product AR model class
     */
    public $product;
    private $_user;

    /**
     * Declares the validation rules.
     * The rules state that email and password are required,
     * and password needs to be authenticated using the verify() method
     */
    public function rules() {
        return array(
            // email and role are required
            array('email, role', 'required'),
            //email needs to be checked for existence 
            array('email', 'exist', 'className' => 'User'),
            array('email', 'verify'),
        );
    }

    /**
     * Authenticates the existence of the user in the system.
     * If valid, it will also make the association between the user, role and product
     * This is the 'verify' validator as declared in rules().
     */
    public function verify($attribute, $params) {
        if (!$this->hasErrors()) {  // we only want to authenticate when no other input errors are present
            $user = User::model()->findByAttributes(array('email' => $this->email));
            if ($this->product->isUserInProduct($user)) {
                $this->addError('email', 'This user has already been added to the product.');
            } else {
                $this->_user = $user;
            }
        }
    }

    public function assign() {
        if ($this->_user instanceof User) {

            //assign the user, in the specified role, to the product
            $this->product->assignUser($this->_user->id, $this->role);
            //add the association, along with the RBAC biz rule, to our RBAC hierarchy
            $auth = Yii::app()->authManager;
            $bizRule = 'return isset($params["product"]) && $params["product"]->allowCurrentUser("' . $this->role . '");';
            $auth->assign($this->role, $this->_user->id, $bizRule);
            return true;
        } else {
            $this->addError('email', 'Error when attempting to assign this user to the product.');
            return false;
        }
    }

    /**
     * Generates an array of emails to use for the autocomplete
     */
    public function createEmailList() {
        $sql = "SELECT email FROM piki_user";
        $command = Yii::app()->db->createCommand($sql);
        $rows = $command->queryAll();
        //format it for use with auto complete widget
        $emails = array();
        foreach ($rows as $row) {
            $emails[] = $row['email'];
        }
        return $emails;
    }

}

?>
