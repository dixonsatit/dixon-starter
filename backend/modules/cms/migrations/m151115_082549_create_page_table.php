<?php

use yii\db\Schema;
use yii\db\Migration;

class m151115_082549_create_page_table extends Migration
{
  public function up()
  {
    $this->createTable('{{%cms_page}}', [
          'id' => $this->primaryKey(),
          'slug' => $this->string()->notNull(),
          'title' => $this->string()->notNull(),
          'body' => $this->text(),
          'view' => $this->string(),
          'thumbnail_base_url' => $this->string(),
          'thumbnail_path' => $this->string(),
          'status' => $this->integer(1)->notNull()->defaultValue(1),
          'category_id' => $this->integer()->notNull()->defaultValue(0),
          'created_at' => $this->integer()->notNull(),
          'updated_at' => $this->integer()->notNull(),
          'created_by' => $this->integer()->notNull(),
          'updated_by' => $this->integer()->notNull(),
      ]);
      $this->createIndex('slug','{{%cms_page}}','slug');
      $this->createIndex('category_id','{{%cms_page}}','category_id');
      $this->createIndex('created_by','{{%cms_page}}','created_by');
      $this->createIndex('updated_by','{{%cms_page}}','updated_by');
  }

  public function down()
  {
       $this->dropTable('{{%cms_page}}');
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
