<?php

class RfqController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules

      public function accessRules()
      {
      return array(
      array('allow',  // allow all users to perform 'index' and 'view' actions
      'actions'=>array('index','view'),
      'users'=>array('*'),
      ),
      array('allow', // allow authenticated user to perform 'create' and 'update' actions
      'actions'=>array('create','update'),
      'users'=>array('@'),
      ),
      array('allow', // allow admin user to perform 'admin' and 'delete' actions
      'actions'=>array('admin','delete'),
      'users'=>array('admin'),
      ),
      array('deny',  // deny all users
      'users'=>array('*'),
      ),
      );
      } */

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $model = new Rfq;
        //$productModel->products = array(new Product);
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Rfq'])) {
            $model->attributes = $_POST['Rfq'];
            //$model->userid = Yii::app()->user->id;
            //$mode->created_date = date('Y-m-d H:i:s');
            if ($model->save()) {

                // A RFQ contains many products
                // insert new records to rfq_product assignment for each product
                foreach ($_POST['Rfq']['products'] as $productId) {
                    $rfqProduct = new RfqProductAssignment;
                    $rfqProduct->rfqid = $model->id;
                    $rfqProduct->productid = $productId;
                    if ($rfqProduct->save()) {
                        // A product has many owners to recieve the emails 
                        // insert new records to rfq_product_user for each product owner
                        $EachProductOwners = UserProductAssignment::model()->findAll('productid=:productid', array(':productid' => $productId,));
                        if ($EachProductOwners != null) {
                            foreach ($EachProductOwners as $EachProductOwner) {
                                $rfqProductUserAssignment = new RfqProductUserAssignment;
                                $rfqProductUserAssignment->rfqproductid = $rfqProduct->id;
                                $rfqProductUserAssignment->userid = $EachProductOwner->userid;
                                if ($rfqProductUserAssignment->save()) {
                                    /* #Send Email */
                                    Yii::import('ext.phpmailer.JPhpMailer');
                                    $mail = new JPhpMailer;
                                    $mail->IsSMTP();
                                    $mail->Host = 'smpt.bizweb.sg';
                                    $mail->SMTPAuth = true;
                                    $mail->Username = 'support@bizweb.sg';
                                    $mail->Password = 'Grandfather26';
                                    $mail->SetFrom('support@bizweb.sg', 'First Last');
                                    $mail->Subject = 'PHPMailer Test Subject via smtp, basic with authentication';
                                    $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
                                    $mail->MsgHTML('<h1>JUST A TEST!</h1>');
                                    $mail->AddAddress(User::model()->findByPk($rfqProductUserAssignment->userid)->email, 'John Doe');
                                    $mail->Send();
                                    /* Send Email # */
                                }
                            }
                        }
                    }
                }

                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        if (!Yii::app()->user->checkAccess('updateRfq')) {
            throw new CHttpException(403, 'You are not authorized to perform this action.');
        }

        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Rfq'])) {
            $model->attributes = $_POST['Rfq'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (!Yii::app()->user->checkAccess('deleteRfq')) {
            throw new CHttpException(403, 'You are not authorized to perform this action.');
        }
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //$dataProvider = new CActiveDataProvider('Rfq');

        $dataProvider = new CActiveDataProvider('Rfq', array(
            'criteria' => array(
                'condition' => 'userid=:userid',
                'params' => array(':userid' => Yii::app()->user->id),
        )));

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Rfq('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Rfq']))
            $model->attributes = $_GET['Rfq'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Rfq the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Rfq::model()->find('id=:id && userid=:userid', array(':id' => $id, ':userid' => Yii::app()->user->id));

        if ($model === null)
            throw new CHttpException(403, 'You are not authorised to view.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Rfq $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'rfq-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
