<?php

namespace app\models;

use wbraganca\behaviors\NestedSetBehavior;
use wbraganca\behaviors\NestedSetQuery;
use Yii;
use yii\db\ActiveRecord;

class News extends ActiveRecord
{
    public static function tableName()
    {
        return 'news';
    }

    public function rules()
    {
        return [
            [['title', 'text'], 'required'],
            ['title', 'string', 'max' => 255],
            ['text', 'string', 'max' => 65535],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => NestedSetBehavior::className(),
                'leftAttribute' => 'left',
                'rightAttribute' => 'right',
                'rootAttribute' => 'root',
                'levelAttribute' => 'level',
                'hasManyRoots' => true,
            ],
        ];
    }

    public static function find()
    {
        return new NestedSetQuery(get_called_class());
    }
}
