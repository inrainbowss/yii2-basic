<?php

namespace app\models;
use yii\db\ActiveRecord;

class User extends ActiveRecord
{
//    public $id;
//    public $uuid;

	public function rules()
	{
		return [
			['uuid', 'required']
		];
	}

	public function formName()
	{
		return '';
	}

	public static function tableName()
	{
		return 'users';
	}

	public static function findByUuid(string $uuid)
	{
		return static::find()->where(['uuid' => $uuid])->one();
	}

	public static function getRoster(int $user_id)
	{
		$groups = Group::find()->where(['user_id' => $user_id])->with(['participants'])->all();
		$data = [];
		foreach($groups as $i => $group)
		{
			$data[$i]['groupTitle'] = $group->title;
			foreach($group->participants as $participant)
			{
				/**
				 * @var $participant Participant
				 */
				$data[$i]['users'][] = ['title' => $participant->title, 'uuid' => $participant->getUser()->uuid];
			}
		}

		return $data;
	}

	public function beforeSave($insert)
	{
    	if ($insert) {
    		$exists = static::findByUuid($this->uuid);

    		if ($exists)
			{
				$this->addError('saveError', 'user already exists');
				return false;
			}
		}

    	return parent::beforeSave($insert);
	}
}
