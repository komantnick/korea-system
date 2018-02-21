<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "connection".
 *
 * @property integer $user_id
 * @property integer $parent_id
 */
class Connection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'connection';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'parent_id'], 'required'],
            [['user_id', 'parent_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'parent_id' => 'Parent ID',
        ];
    }
}
