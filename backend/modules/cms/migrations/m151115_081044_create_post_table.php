<?php

use yii\db\Schema;
use yii\db\Migration;

class m151115_081044_create_post_table extends Migration
{
  public function up()
  {
    $this->createTable('{{%cms_post}}', [
          'id' => $this->primaryKey(),
          'slug' => $this->string()->notNull(),
          'title' => $this->string()->notNull(),
          'body' => $this->text(),
          'published_at' => $this->datetime(),
          'view' => $this->string(),
          'thumbnail_base_url' => $this->string(),
          'thumbnail_path' => $this->string(),
          'status' => $this->integer(1)->notNull()->defaultValue(1),
          'category_id' => $this->integer()->notNull(),
          'created_at' => $this->integer()->notNull(),
          'updated_at' => $this->integer()->notNull(),
          'created_by' => $this->integer()->notNull(),
          'updated_by' => $this->integer()->notNull(),
      ]);
      $this->createIndex('slug','{{%cms_post}}','slug');
      $this->createIndex('status','{{%cms_post}}','status');
      $this->createIndex('category_id','{{%cms_post}}','category_id');
      $this->createIndex('created_by','{{%cms_post}}','created_by');
      $this->createIndex('updated_by','{{%cms_post}}','updated_by');
  }

  public function down()
  {
       $this->dropTable('{{%article}}');
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
