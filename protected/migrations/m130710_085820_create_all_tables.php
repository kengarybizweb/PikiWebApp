<?php

class m130710_085820_create_all_tables extends CDbMigration
{
/*
	public function up()
	{
	}

	public function down()
	{
		echo "m130710_085820_create_all_tables does not support migration down.\n";
		return false;
	}
*/

    public function up() {

        /*         * Create Tables */

//create the user table
        $this->createTable('piki_user', array(
            'id' => 'pk',
            'email' => 'string NOT NULL',
            'password' => 'string NOT NULL',
            'company_name' => 'string NOT NULL',
            'business_reg_id' => 'string NOT NULL',
                ), 'ENGINE=InnoDB');

//create the piki_rfq table
        $this->createTable('piki_rfq', array(
            'id' => 'pk',
            'userid' => 'int(11) NOT NULL',
            'created_date' => 'datetime DEFAULT NULL',
                ), 'ENGINE=InnoDB');

//create the product table
        $this->createTable('piki_product', array(
            'id' => 'pk',
            'name' => 'string NOT NULL',
            'description' => 'text',
            'parentid' => 'int(11) DEFAULT NULL',
                ), 'ENGINE=InnoDB');

//relationship between user, product
        $this->createTable('piki_user_product_assignment', array(
            'userid' => 'int(11) NOT NULL',
            'productid' => 'int(11) NOT NULL',
            'PRIMARY KEY (`userid`,`productid`)',
                ), 'ENGINE=InnoDB');

//relationship between rfq and product
        $this->createTable('piki_rfq_product_assignment', array(
            'id' => 'pk',
            'rfqid' => 'int(11) NOT NULL',
            'productid' => 'int(11) NOT NULL',
                ), 'ENGINE=InnoDB');

//relationship between rfq, product, user
        $this->createTable('piki_rfq_product_user_assignment', array(
            'rfqproductid' => 'int(11) NOT NULL',
            'userid' => 'int(11) NOT NULL',
            'PRIMARY KEY (`rfqproductid`,`userid`)',
                ), 'ENGINE=InnoDB');


        /** foreign key relationships */
        //the piki_rfq.userid is a reference to piki_user.id
        $this->addForeignKey("fk_rfq_user", "piki_rfq", "userid", "piki_user", "id", "CASCADE", "RESTRICT");

        //the piki_product.parentid is a self reference to piki_product.id
        $this->addForeignKey("fk_product_parent", "piki_product", "parentid", "piki_product", "id", "CASCADE", "RESTRICT");

        //the piki_user_product_assignment.userid is a reference to piki_user.id
//the piki_user_product_assignment.productid is a reference to piki_product.id
        $this->addForeignKey("fk_userid_product", "piki_user_product_assignment", "userid", "piki_user", "id", "CASCADE", "RESTRICT");
        $this->addForeignKey("fk_user_productid", "piki_user_product_assignment", "productid", "piki_product", "id", "CASCADE", "RESTRICT");

        //the piki_rfq_product_assignment.rfqid is a reference to piki_rfq.id
        //the piki_rfq_product_assignment.productid is a reference to piki_product.id
        $this->addForeignKey("fk_rfqid_product", "piki_rfq_product_assignment", "rfqid", "piki_rfq", "id", "CASCADE", "RESTRICT");
        $this->addForeignKey("fk_rfq_productid", "piki_rfq_product_assignment", "productid", "piki_product", "id", "CASCADE", "RESTRICT");

        //the piki_rfq_product_user_assignment.rfqproductid is a reference to piki_rfq_product_assignment.id
        //the piki_rfq_product_user_assignment.rfqproductid is a reference to piki_rfq_product_assignment.id
        $this->addForeignKey("fk_rfqproductid_user", "piki_rfq_product_user_assignment", "rfqproductid", "piki_rfq_product_assignment", "id", "CASCADE", "RESTRICT");
        $this->addForeignKey("fk_rfqproduct_userid", "piki_rfq_product_user_assignment", "userid", "piki_user", "id", "CASCADE", "RESTRICT");
    }

    public function down() {
        $this->truncateTable('piki_rfq_product_user_assignment ');
        $this->truncateTable('piki_rfq_product_assignment');
        $this->truncateTable('piki_user_product_assignment');
        $this->truncateTable('piki_product');
        $this->truncateTable('piki_rfq');
        $this->truncateTable('piki_user');

        $this->dropTable('piki_rfq_product_user_assignment ');
        $this->dropTable('piki_rfq_product_assignment');
        $this->dropTable('piki_user_product_assignment');
        $this->dropTable('piki_product');
        $this->dropTable('piki_rfq');
        $this->dropTable('piki_user');
    }

}