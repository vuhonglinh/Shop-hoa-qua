<?php
function cart_buy()
{
    if (isset($_SESSION['cart']['buy'])) {
        return $_SESSION['cart']['buy'];
    }
}

function cart_info()
{
    if (isset($_SESSION['cart']['info'])) {
        return $_SESSION['cart']['info'];
    }
}

function get_cart_by_id($id) //Lấy sản phẩm qua id
{
    $sql = db_fetch_row("SELECT * FROM `tb_products` WHERE product_id = '{$id}'");
    return $sql;
}

function get_product_promotion($id) //Lấy giá khuyễn mãi theo id sản phẩm
{
    $sql = db_fetch_row("SELECT * FROM `product_promotion` INNER JOIN `tb_promotions` ON product_promotion.promotion_id = tb_promotions.id 
    INNER JOIN `tb_products` ON product_promotion.product_id = tb_products.product_id WHERE tb_products.product_id = {$id} AND tb_promotions.status = 'Đang diễn ra'");
    if (!$sql) {
        return false;
    }
    return $sql['discount_rate'];
}


function add_product_put_cart($id, $qty) //Thêm vào giỏ hàng 
{
    $item = get_cart_by_id($id);
    $promotion = get_product_promotion($id);
    if (!$promotion) {
        $promotion = 0;
    }
    //TRừ sản phẩm trong Database khi mua hàng
    $quantity = $item['quantity']; //Số sản phẩm trong giỏ hàng
    $total_product = $quantity - $qty;
    $data_quantity = [
        'quantity' => $total_product,
    ];
    db_update("tb_products", $data_quantity, "`product_id` = $id");
    // Nếu sản phẩm đã tồn tại trong giỏ hàng, tăng số lượng
    if (isset($_SESSION['cart']['buy']) && array_key_exists($id, $_SESSION['cart']['buy'])) {
        $_SESSION['cart']['buy'][$id]['qty'] += $qty;
        $_SESSION['cart']['buy'][$id]['sub_total'] = $_SESSION['cart']['buy'][$id]['qty'] * $_SESSION['cart']['buy'][$id]['price'];
    } else {
        // Nếu sản phẩm chưa tồn tại trong giỏ hàng, thêm mới
        $_SESSION['cart']['buy'][$id] = [
            'product_id' => $item['product_id'],
            'product_code' => $item['product_code'],
            'product_name' => $item['product_name'],
            'price' => $item['price'] - ($item['price'] * ($promotion / 100)),
            'product_thumb' => $item['product_thumb'],
            'qty' => $qty,
            'sub_total' => ($item['price'] - ($item['price'] * ($promotion / 100))) * $qty,
        ];
    }
    update_cart();
}

function update_cart() //Cập nhật lại giỏ hàng
{
    $count = 0;
    $total = 0;
    if (isset($_SESSION['cart']['buy'])) {
        $count = 0;
        $total = 0;
        foreach ($_SESSION['cart']['buy'] as $item) {
            $count += $item['qty'];
            $total += $item['sub_total'];
        }
    }
    $_SESSION['cart']['info'] = [
        'count' => $count,
        'total' => $total,
    ];
}

function get_list_buy_cart()
{
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart']['buy'] as &$item) { //Cập nhật lại và thêm url
            $item['url_delete'] = "?mod=cart&action=delete&id={$item['product_id']}";
        }
        return $_SESSION['cart']['buy'];
    }
    return false;
}
