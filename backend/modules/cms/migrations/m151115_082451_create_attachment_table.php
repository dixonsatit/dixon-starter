<?php

use yii\db\Schema;
use yii\db\Migration;

class m151115_082451_create_attachment_table extends Migration
{
  public function up()
  {
    $tableOptions = null;
       if ($this->db->driverName === 'mysql') {
           $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
       }

    $this->createTable('{{%cms_attachment}}', [
          'id' => $this->primaryKey(),
          'post_id' => $this->integer(),
          'page_id' => $this->integer(),
          'path' => $this->string()->notNull(),
          'base_url' => $this->string(),
          'name' => $this->string(),
          'type' => $this->string(),
          'size' => $this->integer(),
          'created_at' => $this->integer()->notNull(),
          'updated_at' => $this->integer()->notNull(),
          'created_by' => $this->integer()->notNull(),
          'updated_by' => $this->integer()->notNull()

      ],$tableOptions);

      $this->createIndex('post_id','{{%cms_attachment}}','post_id');
      $this->createIndex('page_id','{{%cms_attachment}}','page_id');
      $this->addForeignKey('fk_post','{{%cms_attachment}}','post_id','{{%cms_post}}','id','CASCADE','CASCADE');
      $this->addForeignKey('fk_page','{{%cms_attachment}}','page_id','{{%cms_page}}','id','CASCADE','CASCADE');
  }

  public function down()
  {
       $this->dropTable('{{%cms_attachment}}');
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
