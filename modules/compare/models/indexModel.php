<?php
function get_product_by_color_id($product_id) //Lấy chi tiết sản phẩm bằng id color
{
    $sql = db_fetch_row("SELECT * FROM `tb_products` WHERE product_id = {$product_id}");
    return $sql;
}

function product_reviews($id) //Lấy chi tiêt danh giá sản phẩm
{
    $sql = db_fetch_row("SELECT AVG(`star`) AS `star`, COUNT(`id_product`) AS `count` FROM `tb_comments` WHERE `id_product` = {$id}");
    return $sql;
}
