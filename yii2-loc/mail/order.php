<div class="table-responsive">
    <table style="width: 100%; border:  1px solid #ddd; border-collapse: collapse;">
        <thead>
            <tr style="background: #f9f9f9">
                <th style="padding: 8px; border:  1px solid #ddd;">Name</th>
                <th style="padding: 8px; border:  1px solid #ddd;">Quantity</th>
                <th style="padding: 8px; border:  1px solid #ddd;">Price</th>
                <th style="padding: 8px; border:  1px solid #ddd;">Sum</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($session['cart'] as  $id=>$item): ?>
            <tr>           
                <td style="padding: 8px; border:  1px solid #ddd;">
                    <a href="<?= yii\helpers\Url::to(['product/view','id'=>$id],true) ?>">
                <?= $item['name'] ?></a>
                </td>
                <td style="padding: 8px; border:  1px solid #ddd;"><?= $item['qty'] ?></td>
                <td style="padding: 8px; border:  1px solid #ddd;"><?= $item['price'] ?></td>
                <td style="padding: 8px; border:  1px solid #ddd;"><?= $item['price']*$item['qty'] ?></td>
                
            </tr>
        <?php endforeach; ?>            
            <tr>
                <td colspan="3" style="padding: 8px; border:  1px solid #ddd;">Total:</td>
                <td><?=  $session['cart.qty']?></td>
            </tr>
            <tr>
                <td colspan="3" style="padding: 8px; border:  1px solid #ddd;">Sum:</td>
                <td><?=  $session['cart.sum']?></td>
            </tr>
        </tbody>
    </table>
</div>
 