<?php

class m130711_115453_add_role_to_piki_product_user_assignment extends CDbMigration {

    public function up() {
        $this->addColumn('piki_user_product_assignment', 'role', 'varchar(64)');
//the tbl_project_user_assignment.role is a reference
//to tbl_auth_item.name
        $this->addForeignKey('fk_product_user_role', 'piki_user_product_assignment', 'role', 'tbl_auth_item', 'name', 'CASCADE', 'CASCADE');
    }

    public function down() {
        $this->dropForeignKey('fk_product_user_role', 'piki_user_product_assignment');
        $this->dropColumn('piki_user_product_assignment', 'role');
    }

    /*
      // Use safeUp/safeDown to do migration with transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}