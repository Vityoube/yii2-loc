<?php

use app\modules\admin\models\Order;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Order */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1>View order No<?= $model->id ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'created_at',
            'updated_at',
            'qty',
            'sum',
            [
                'attribute' =>'status',
                'value'=> !$model->status
            ? '<span class="text-danger">Active</span>'
            : '<span class="text-success">Closed</span>',
                'format'=>'html'
            ],
//            'status',
            'name',
            'email:email',
            'phone',
            'address',
        ],
    ]) ?>
    
    <?php   $items=$model->orderItems; ?>

    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Sum</th>
                    <th><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($items as  $item): ?>
                <tr>
                    <td><a href="<?= Url::to(['/product/view','id'=>$item->product_id])?>"><?= $item['name'] ?></a></td>
                    <td><?= $item['qty_item'] ?></td>
                    <td><?= $item['price'] ?></td>
                    <td><?= $item['sum_item'] ?></td>
                </tr>
            <?php endforeach; ?>            
            </tbody>
        </table>
    </div>

</div>
