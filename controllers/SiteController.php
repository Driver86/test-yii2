<?php

namespace app\controllers;

use app\models\Category;
use app\models\News;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Выдача списка всех новостей, которые относятся к указанной рубрике, включая дочерние.
     *
     * @param int $categoryId
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionGetNews($categoryId)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = [];
        $category = Category::findOne($categoryId);
        if (!$category) {
            throw new NotFoundHttpException();
        }
        foreach ($category->descendants()->all() ?: [] as $c) {
            $response[] = [
                'category' => $c->title,
                'news' => News::find()->where(['categoryId' => $c->id]),
            ];
        }
        return $this->asJson($response);
    }

    /**
     * Выдача списка всех рубрик, с дочерними, с учетом произвольного уровня вложенности.
     */
    public function actionGetAllCategories()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = $this->createThree(Category::find()->roots()->all());
        return $this->asJson($response);
    }

    protected function createThree($categories)
    {
        $r = [];
        foreach ($categories ?: [] as $category) {
            $r[$category->id] = [
                'title' => $category->title,
                'children' => $this->createThree($category->children()->all()),
            ];
        }
        return $r;
    }
}
