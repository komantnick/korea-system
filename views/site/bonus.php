<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\User;
use app\models\Order;
use app\models\Bonusorder;
$this->title = 'Бонусы';
if (Yii::$app->user->isGuest) {

}
else {
	echo "Номер пользователя:";
	print(Yii::$app->user->identity->id);
	echo "<br>";
	$bonus=Order::find()
        ->where([ 'user_id'=>Yii::$app->user->identity->id]);
        
    $sum = $bonus->sum('sum_of_bonus');
    $bonus=$bonus->all();
    echo "<table style='width:100%'><caption>Зачисленные баллы</caption><tr>"."<th>Сумма бонусов</th>"."<th>Сумма покупок</th>"."<th>Дата</th>"."</tr><br>";
    foreach ($bonus as $x){
    	echo "<tr><td>".$x['sum_of_bonus']."</td><td> ".$x['sum_of_order']."</td><td> ".$x['date'];
    	echo "</td><br>";
    }
    echo "</table>";

    $takenbonus=Bonusorder::find()
        ->where([ 'user_id'=>Yii::$app->user->identity->id]);


        $sum2 = $takenbonus->sum('sum_of_orderbonus');
        
    $takenbonus=$takenbonus->all();

    echo "<table style='width:100%'><caption>Снятые баллы</caption><tr>"."<th>Сумма бонусов</th>"."<th>Сумма покупок</th>"."<th>Дата</th>"."</tr><br>";
    foreach ($takenbonus as $x){  
        echo "<tr><td>".$x['sum_of_orderbonus']."</td><td> ".$x['sum_of_order']."</td><td> ".$x['date'];
        echo "</td><br>";
    }
    echo "</table>";
    $x=$sum-$sum2;
    echo "<h3>Количество бонусов:".$x."</h3>";
}

?>