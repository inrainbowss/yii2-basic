<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class AddParticipantForm extends EditRosterForm
{

	public $title;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
    	$rules = parent::rules();
    	unset($rules['group']);
    	$rules[] = ['title', 'required'];
    	return $rules;
    }

}
