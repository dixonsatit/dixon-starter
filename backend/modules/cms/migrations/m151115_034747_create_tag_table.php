<?php

use yii\db\Schema;
use yii\db\Migration;

class m151115_034747_create_tag_table extends Migration
{
    public function up()
    {
      $this->createTable('{{%cms_tag}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'frequency' => $this->integer()->defaultValue(0),
        ]);
    }

    public function down()
    {
       $this->dropTable('{{%cms_tag}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
