<?php

use yii\db\Migration;

/**
 * Handles the creation of table `participants`.
 */
class m170211_095334_create_participants_table extends Migration
{
	/**
	 * @inheritdoc
	 */
	public function up()
	{
		$this->createTable('participants', [
			'id' => $this->primaryKey(),
			'group_id' => $this->integer()->notNull(),
			'user_id' => $this->integer()->notNull(),
			'title' => $this->string()->notNull()
		]);
	}

	/**
	 * @inheritdoc
	 */
	public function down()
	{
		$this->dropTable('participants');
	}
}
