<?php
namespace app\controllers;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use Yii;
use yii\web\Response;

class DefaultController extends Controller
{

	public function actionSuccess(array $data = [])
	{
		$response = Yii::$app->response;
		$response->format = Response::FORMAT_JSON;

		$content = ['result' => 'ok'];
		if (!empty($data))
		{
			$content = array_merge($content, $data);
		}
		$response->data = $content;
		Yii::$app->response->send();
	}

	public function actionError($data = [], $code = 404)
	{
		$data = (array)$data;
		$response = Yii::$app->response;
		$response->format = Response::FORMAT_JSON;

		$response->statusCode = $code;
		$content = ['result' => 'error'];

		$content['messages'] = $data;

		$response->data = $content;
		Yii::$app->response->send();
	}

}