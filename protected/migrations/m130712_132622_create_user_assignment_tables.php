<?php

class m130712_132622_create_user_assignment_tables extends CDbMigration
{
	public function up() {
        $this->addColumn('piki_user', 'role', 'varchar(64)');
//the tbl_project_user_assignment.role is a reference
//to tbl_auth_item.name
        $this->addForeignKey('fk_user_role', 'piki_user', 'role', 'tbl_auth_item', 'name', 'CASCADE', 'CASCADE');
    }

    public function down() {
        $this->dropForeignKey('fk_user_role', 'piki_user');
        $this->dropColumn('piki_user', 'role');
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