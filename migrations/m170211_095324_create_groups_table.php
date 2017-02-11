<?php

use yii\db\Migration;

/**
 * Handles the creation of table `groups`.
 */
class m170211_095324_create_groups_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('groups', [
            'id' => $this->primaryKey(),
			'user_id' => $this->integer()->notNull(),
			'title' => $this->string()->notNull()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('groups');
    }
}
