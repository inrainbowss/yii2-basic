<?php

namespace app\controllers;

use app\models\{Group, User, Participant};

use Yii;


class RosterController extends DefaultController
{

	public function actionCreate()
	{
		$model = new User();
		$model->load(Yii::$app->request->get());

		if (!$model->save())
		{
			return $this->actionError($model->errors);
		}

		return $this->actionSuccess();
	}

	public function actionRoster()
	{
		$uuid = Yii::$app->request->get('uuid', null);

		if (!$uuid)
		{
			$this->actionError('you must pass the uuid parameter', 400);
		}

		$user = User::findByUuid($uuid);
		if (!$user instanceof User)
		{
			$this->actionError('user does not exist');
		}
		$roster = User::getRoster($user->id);

		return $this->actionSuccess(['roster' => $roster]);
	}

	public function actionAddParticipant()
	{
		$uuid = Yii::$app->request->get('uuid', null);
		$participant = Yii::$app->request->get('participant', null);
		$title = Yii::$app->request->get('title', null);
		$group = Yii::$app->request->get('group', null);

		if (!$uuid || !$participant || !$title || !$group)
		{
			return $this->actionError(
				'you must pass all required parameters: uuid, participant, title, group',
				400
			);
		}

		$user = User::findByUuid($uuid);
		if (!$user instanceof User)
		{
			return $this->actionError('user does not exist');
		}

		$user_participant = User::findByUuid($participant);
		if (!$user_participant instanceof User)
		{
			return $this->actionError('participant does not exist');
		}

		$group = Group::findOrCreate($user->id, $group);

		if ($group == false)
		{
			return $this->actionError($group->errors);
		}

		if (Participant::findParticipant($user_participant->id, $group->id))
		{
			return $this->actionError('participant already exist in group');
		}

		$participant = Participant::addParticipant($user_participant->id, $group->id, $title);
		if (!$participant)
		{
			return $this->actionError($participant->errors);
		}

		return $this->actionSuccess();
	}

	public function actionRemoveParticipant()
	{
		$uuid = Yii::$app->request->get('uuid', null);
		$participant = Yii::$app->request->get('participant', null);
		$group = Yii::$app->request->get('group', null);

		if (!$uuid || !$participant || !$group)
		{
			return $this->actionError(
				'you must pass all required parameters: uuid, participant, group',
				400
			);
		}

		$user = User::findByUuid($uuid);
		if (!$user instanceof User)
		{
			return $this->actionError('user does not exist');
		}

		$user_participant = User::findByUuid($participant);
		if (!$user_participant instanceof User)
		{
			return $this->actionError('participant does not exist');
		}

		$group = Group::getUserGroup($user->id, $group);
		if (!$group instanceof Group)
		{
			return $this->actionError('this group does not exist');
		}

		$participant = Participant::findParticipant($user_participant->id, $group->id);
		if (!$participant instanceof Participant)
		{
			return $this->actionError('participant does not exist in group');
		}

		if ($participant->delete() == false)
		{
			return $this->actionError('error on deleting participant');
		}

		return $this->actionSuccess();
	}

	public function actionRenameParticipant()
	{
		$uuid = Yii::$app->request->get('uuid', null);
		$participant = Yii::$app->request->get('participant', null);
		$group = Yii::$app->request->get('group', null);
		$title = Yii::$app->request->get('title', null);

		if (!$uuid || !$participant || !$group || !$title)
		{
			return $this->actionError(
				'you must pass all required parameters: uuid, participant, group, title',
				400
			);
		}

		$user = User::findByUuid($uuid);
		if (!$user instanceof User)
		{
			return $this->actionError('user does not exist');
		}

		$user_participant = User::findByUuid($participant);
		if (!$user_participant instanceof User)
		{
			return $this->actionError('participant does not exist');
		}

		$group = Group::getUserGroup($user->id, $group);
		if (!$group instanceof Group)
		{
			return $this->actionError('this group does not exist');
		}

		$participant = Participant::findParticipant($user_participant->id, $group->id);
		if (!$participant instanceof Participant)
		{
			return $this->actionError('participant does not exist in group');
		}

		$participant->title = $title;
		if (!$participant->save())
		{
			return $this->actionError($participant->errors);
		}

		return $this->actionSuccess();
	}
}
