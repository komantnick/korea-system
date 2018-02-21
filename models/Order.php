<?php

namespace app\models;

use Yii;
use app\models\Connection;

/**
 * This is the model class for table "order".
 *
 * @property integer $order_id
 * @property integer $user_id
 * @property integer $sum_of_order
 * @property integer $sum_of_bonus
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'sum_of_order'], 'required'],
            [['user_id', 'sum_of_order'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'user_id' => 'User ID',
            'sum_of_order' => 'Sum Of Order',
            'sum_of_bonus' => 'Sum Of Bonus',
        ];
    }
    public function addResult()
    {

        if (!$this->validate()) {
            return null;
        }

        $res = new Order();
        $res->user_id = $this->user_id;
        $res->sum_of_order = $this->sum_of_order;
        $res->sum_of_bonus = ($this->sum_of_order)/10;
        $res->date=date("Y-m-d");
        $res->addParentBonus($this->user_id,$this->sum_of_order);

        return $res->save() ? $res : null;
    }

    public function addParentBonus($id,$bonus)
    {
        $connect=Connection::find()
        ->where([ 'user_id'=>$this->user_id])
        ->one();
        $res=new Order();
        $res->user_id = $connect['parent_id'];
        $res->sum_of_order = 0;
        $res->sum_of_bonus = ($bonus)/20;
        $res->date=date("Y-m-d");
        return $res->save() ? $res : null;
    }

    public function addBonus($code,$id)
    {
        $users=User::find()
        ->where([ 'promo_code'=>$code])
        ->one();
        $con=new Connection();
        $con->user_id = $id;
        $con->parent_id=$users['id'];
        $con->save();
    }
}
