<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class EditRosterForm extends Model
{

	public $uuid;
	public $participant;
	public $group;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['uuid', 'participant', 'group'], 'required'],
			'uuid' => ['uuid', 'exist', 'targetClass' => User::class, 'targetAttribute' => 'uuid'],
			'participant' => ['participant', 'exist', 'targetClass' => User::class, 'targetAttribute' => 'uuid'],
			'group' => ['group', 'exist', 'targetClass' => Group::class, 'targetAttribute' => 'title']
		];
    }

	public function formName()
	{
		return '';
	}

}
