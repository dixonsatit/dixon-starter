<?php

use yii\db\Schema;
use yii\db\Migration;

class m151115_082359_create_category_table extends Migration
{
  public function up()
  {
    $this->createTable('{{%cms_category}}', [
          'id' => $this->primaryKey(),
          'name' => $this->string()->notNull(),
          'detail' => $this->string(),
          'status' => $this->integer(1)->notNull()->defaultValue(1),
          'parent_id' => $this->integer(),
          'created_at' => $this->integer()->notNull(),
          'updated_at' => $this->integer()->notNull(),
          'created_by' => $this->integer()->notNull(),
          'updated_by' => $this->integer()->notNull(),
      ]);
      $this->addForeignKey('fk_post_cms_category','{{%cms_category}}','parent_id','{{%cms_category}}','id');
  }

  public function down()
  {
       $this->dropTable('{{%cms_category}}');
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
