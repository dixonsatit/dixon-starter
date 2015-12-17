<?php

use yii\db\Schema;
use yii\db\Migration;

class m151115_080028_create_post_tag_assn_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%cms_post_tag_assn}}', [
            'post_id' => $this->string()->notNull(),
            'tag_id' => $this->integer()->notNull(),
        ]);

      $this->addPrimaryKey('', '{{%cms_post_tag_assn}}', ['post_id', 'tag_id']);
    }

    public function down()
    {
       $this->dropTable('{{%cms_post_tag_assn}}');
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
