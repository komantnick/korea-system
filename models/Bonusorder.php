<?php

namespace app\models;

use Yii;
use app\models\Order;
/**
 * This is the model class for table "bonusorder".
 *
 * @property integer $bonusorder_id
 * @property integer $user_id
 * @property integer $sum_of_order
 * @property integer $sum_of_orderbonus
 * @property string $date
 */
class Bonusorder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bonusorder';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['bonusorder_id', 'user_id', 'sum_of_order', 'sum_of_orderbonus', 'date'], 'required'],
            [['bonusorder_id', 'user_id', 'sum_of_order', 'sum_of_orderbonus'], 'integer'],
            [['date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bonusorder_id' => 'Bonusorder ID',
            'user_id' => 'User ID',
            'sum_of_order' => 'Sum Of Order',
            'sum_of_orderbonus' => 'Sum Of Orderbonus',
            'date' => 'Date',
        ];
    }

    public function takeBonus()
    {

        if (!$this->validate()) {
            return null;
        }

        $bonus=Order::find()
        ->where([ 'user_id'=>$this->user_id]);
        
        $sum = $bonus->sum('sum_of_bonus');
        if ($sum==NULL){
            $ordres=new Order();
            if ($this->sum_of_order>0){
        $ordres->user_id = $this->user_id;
        $ordres->sum_of_order = $this->sum_of_order;
        $ordres->sum_of_bonus = ($this->sum_of_order)/10;
        $ordres->date=date("Y-m-d");
        $ordres->addParentBonus($this->user_id,$this->sum_of_order);
        return$ordres->save();
        } 
        return null;   
        }
        else {
            $res = new Bonusorder();
            $res->user_id = $this->user_id;
            
            $res->date=date("Y-m-d");
            if ($this->sum_of_order>$sum) $this->sum_of_order=$this->sum_of_order-$res->sum_of_orderbonus;
            else $sum=$sum-$this->sum_of_order;
            $res->sum_of_order = $this->sum_of_order;
            $res->sum_of_orderbonus = $sum;
            if ($this->sum_of_order>0){
            $ordres=new Order();
            $ordres->user_id = $this->user_id;
        $ordres->sum_of_order = $this->sum_of_order;
        $ordres->sum_of_bonus = ($this->sum_of_order)/10;
        $ordres->date=date("Y-m-d");
        $ordres->addParentBonus($this->user_id,$this->sum_of_order);
            $ordres->save();
        }    
            return $res->save();
        }
    }
}