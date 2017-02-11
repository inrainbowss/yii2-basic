<?php

namespace app\models;

use yii\db\ActiveRecord;

class Group extends ActiveRecord
{
//    public $id;
//    public $user_id;
//    public $title;
//    public $users;


	public static function findOrCreate(int $user_id, string $title)
	{
		$group = Group::getUserGroup($user_id, $title);

		if (!empty($group))
		{
			return $group;
		}

		$group = new Group();
		$group->user_id = $user_id;
		$group->title = $title;

		if (!$group->save())
		{
			return false;
		}

		return $group;
	}

	public static function getUserGroup(int $user_id, string $title)
	{
		return static::find()->where(['user_id' => $user_id, 'title' => $title])->one();
	}

	public static function tableName()
	{
		return 'groups';
	}

	public function rules()
	{
		return [
			['user_id', 'required'],
			['title', 'required']
		];
	}

	public function getparticipants()
	{
		return $this->hasMany(Participant::className(), ['group_id' => 'id']);
	}
}
