<?php

namespace app\models;

use yii\db\ActiveRecord;

class Participant extends ActiveRecord
{
//    public $id;
//    public $uuid;
//    public $title;
//    public $group_id;


	/**
	 * @param $user_id
	 * @param $group_id
	 * @return Participant
	 */
	public static function findParticipant($user_id, $group_id)
	{
		return static::find()->where(['user_id' => $user_id, 'group_id' => $group_id])->one();
	}

	/**
	 * @param $user_id
	 * @param $group_id
	 * @param $title
	 * @return Participant|bool
	 */
	public static function addParticipant($user_id, $group_id, $title)
	{
		$model = new static();
		$model->user_id = $user_id;
		$model->group_id = $group_id;
		$model->title = $title;

		if (!$model->save())
		{
			return false;
		}

		return $model;
	}

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'participants';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['user_id', 'required'],
			['group_id', 'required'],
			['title', 'required'],
		];
	}

	/**
	 * @return array|null|ActiveRecord
	 */
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'user_id'])->one();
	}

}
