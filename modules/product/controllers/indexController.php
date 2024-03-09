<?php
function construct()
{
}

function indexAction()
{
}

function ajaxAction() //Thêm bình luận
{
    load_module('index');
    $comment = $_POST['comment'];
    $id_product = $_POST['id_product'];
    $star = !empty($_POST['star']) ? $_POST['star'] : 0;
    $id_customer = info_login("id");
    $data = [
        'id_product' => $id_product,
        'comment_content' => $comment,
        'id_customer' => $id_customer,
        'star' => $star,
    ];
    add_comments($data);
    $comments = get_list_comments($id_product); //Danh sách bình luận
    $avg_star = product_star_by_id($id_product); //Lấy tb đánh giá sao
    $string = "";
    foreach ($comments as $item) {
        if (empty($item['img'])) {
            $img_user = "img/user.png";
        } else {
            $img_user = "admin/img/{$item['img']}";
        }
        $string .= "<div class='tp-product-details-review-avater d-flex align-items-start'>" .
            "<div class='tp-product-details-review-avater-thumb'>" .
            "<a href='#'>" .
            "<img src='" . $img_user . "' alt=''>" .
            "</a>" .
            "</div>" .
            "<div class='tp-product-details-review-avater-content'>" .
            "<div class='tp-product-details-review-avater-rating d-flex align-items-center'>" .
            " " . str_repeat("<span><i class='fa-solid fa-star'></i></span>", $item['star']) . " " .
            "</div>" .
            "<h3 class='tp-product-details-review-avater-title'>" . $item['fullname'] . "</h3>" .
            "<span class='tp-product-details-review-avater-meta'>" . $item['time'] . "</span>" .

            "<div class='tp-product-details-review-avater-comment'>" .
            "<p>" . $item['comment_content'] . "</p>" .
            "</div>" .
            "</div>" .
            "</div>";
    }
    $count_evaluate = total_comments($id_product); //Lấy tông số bình luận và đánh giá sp
    $string_avg = "<div class='tp-product-details-review-summery-value'>" .
        "<span>" . round($avg_star['star'], 1) . "</span>" .
        "</div>" .
        "<div class='tp-product-details-review-summery-rating d-flex align-items-center'>" .
        "" . str_repeat("<span><i class='fa-solid fa-star'></i></span>", round($avg_star['star'])) . "" .
        "<p>(" . $count_evaluate . " Bình luận và đánh giá)</p>" .
        "</div>";
    //Tổng số lượng đánh giá sao theo thư hạng
    $star_5 = num_product_star_5($id_product);
    $star_4 = num_product_star_4($id_product);
    $star_3 = num_product_star_3($id_product);
    $star_2 = num_product_star_2($id_product);
    $star_1 = num_product_star_1($id_product);
    $result = [
        'list_comment' => $string,
        'avg_star' => $string_avg,
        'total_comment' =>  $count_evaluate,
        'fa_star' => str_repeat("<span><i class='fa-solid fa-star'></i></span>", round($avg_star['star'])),
        'star_5' => $star_5,
        'star_4' => $star_4,
        'star_3' => $star_3,
        'star_2' => $star_2,
        'star_1' => $star_1,
    ];
    echo json_encode($result);
}

function detail_ajaxAction() //Ram sản phẩm 
{
    load_module('index');
    $product_id = $_POST['product_id']; //id sản phẩm
    $ram_id = $_POST['ram']; //id thuộc tính ram
    $list_color = get_list_color_variant_by_ram_id($ram_id); //Lấy danh sách biến thể màu sắc theo ram id
    $string = "";
    foreach ($list_color as $item) {
        if ($item['quantity'] < 1) {
            $disabled = "disabled";
        } else {
            $disabled = "";
        }
        $string .= "
        <input onchange='selectColorVar(this)' type='radio' " . $disabled . " class='color-radio' id='color" . $item['id'] . "' name='color' value='" . $item['id'] . "'>
        <label for='color" . $item['id'] . "' class='color-label text-center' style='background-color: " . $item['color'] . ";'></label>";
    }

    echo $string;
}


function detail_color_ajaxAction()
{
    load_module('index');
    $color_id = $_POST['color_id'];
    $color = get_color_variant($color_id); //Lấy ra màu sắc theo id màu sắc
    $promotion = get_product_promotion_by_id($color['product_id']); //Lấy ra phần trăm khuyễn mãi
    if (!$promotion) {
        $promotion = 0;
    }
    $price = $color['color_price'] - ($color['color_price'] * ($promotion / 100));
    $result = [
        'product_name' => $color['product_name'] . " {$color['ram_name']} {$color['color_name']}",
        'price' => currency_format($price),
        'quantity' => $color['quantity'],
        'image_product' => $color['image']
    ];
    echo json_encode($result);
}

function mainAction()
{
    load_module("index");
    global $select;
    $data['list_ads'] = list_ads("product");
    $price = (!empty($_POST['price'])) ? $_POST['price'] : null;
    $category = (!empty($_POST['category'])) ? $_POST['category'] : null;
    $select = (!empty($_POST['select'])) ? $_POST['select'] : null;
    $data['list_products_by_star'] = list_products_by_sales();
    $data['list_products'] = list_products($select, $price, $category); //Danh sách sản phẩm
    $data['list_category'] = get_list_category(); //Lấy danh sách danh mục
    load_view("main", $data);
}

function productAction()
{
    load_module('product');
    $select = (!empty($_POST['select'])) ? $_POST['select'] : null;
    $data['list_ads'] = list_ads("product");
    //
    $page =  (!empty($_GET['page'])) ? $_GET['page'] : 1;
    $num_rows = 12;
    $start = ($page - 1) * $num_rows;
    //
    $data['list_category'] = list_category();
    $data['list_products_by_star'] = list_products_by_sales();
    $cat_id = (!empty($_GET['cat_id'])) ? $_GET['cat_id'] : null;
    $name_product = (!empty($_GET['name_product'])) ? $_GET['name_product'] : null;
    $data['list_product'] = list_product($cat_id, $name_product, $start, $num_rows, $select);
    $data['num_rows'] = $num_rows; //Số bản ghi trong 1 trang
    $data['start'] = $start; //Điểm bắt đàu lấy bản ghi
    $data['total_product'] = total_product($cat_id, $name_product);
    load_view("product", $data);
}

function detailAction()
{
    load_module('index');
    $id = $_GET['id'];
    //Tổng số lượng đánh giá sao theo thư hạng
    $data['star_5'] = num_product_star_5($id);
    $data['star_4'] = num_product_star_4($id);
    $data['star_3'] = num_product_star_3($id);
    $data['star_2'] = num_product_star_2($id);
    $data['star_1'] = num_product_star_1($id);
    //Gía khuyễn mãi
    $data['promotion'] = get_product_promotion_by_id($id);
    //
    $data['star'] = product_star_by_id($id); //Lấy tb đánh giá sao
    $data['count_evaluate'] = total_comments($id); //Lấy tông số bình luận và đánh giá sp
    $data['product'] = get_product_by_id($id); //Lấy chi tiết sản phẩm
    $data['list_img_detail'] = get_img_detail_by_id($id); //Lấy chi tiết sản phẩm
    $data['comments'] = get_list_comments($id);
    // Share sản phẩm
    $data['product_share'] = [
        'url' =>  base_url("san-pham/chi-tiet/" . create_slug($data['product']['product_name']) . "/" . $id . ".html"),
        'img' => 'anhdienthoaij.jpg',
    ];
    load_view('detail', $data);
}
// function add_cartAction()
// {
//     load_module("index");
//     $id = $_GET['id'];
//     $num_order =  !empty($_POST['num-order']) ? $_GET['num_order'] : 1;
//     add_cart($id, $num_order);
// }

function seach_productAction()
{
    load_module("seach_product");
    $data['list_ads'] = list_ads("product");
    $select = (!empty($_POST['select'])) ? $_POST['select'] : null;
    $seach = (!empty($_GET['seach'])) ? $_GET['seach'] : null;
    $data['seach_product'] = seach_product($seach, $select);
    load_view("seach_product", $data);
}

function seachAction()
{
    load_module("seach_product");
    $seach = $_POST['seach'];
    $item = check_name_product($seach);
    if ($item != null) {
        $slug = create_slug($item['product_name']);
        $id = $item['product_id'];
        redirect("san-pham/chi-tiet/{$slug}/{$id}.html");
    } else {
        redirect("?mod=product&action=seach_product&seach={$seach}");
    }
}

function quickView_ajaxAction() //Phần xem sản phẩm
{
    load_module("index");
    $id = $_POST['product_id'];
    //Lấy biến thể
    $product = get_product_by_id($id); //Lấy chi tiết sản phẩm
    $star = product_star_by_id($id); //Lấy tb đánh giá sao
    $count_evaluate = total_comments($id); //Lấy tông số bình luận và đánh giá sp

    if (get_product_promotion($product['product_id']) == false) {
        $price =  "<span style='color: red;'>" . currency_format($product['price']) . "</span>";
    } else {
        $price = "<span style='text-decoration: line-through;color: #55585B;font-weight: 500; font-size: 20px;'>" . currency_format($product['price']) . "</span> -
        <span style='color: red;'>" . currency_format($product['price'] - ($product['price'] * get_product_promotion($product['product_id']) / 100)) . "</span>";
    }

    if ($product['quantity'] > 0) {
        $quantity = "<span>Còn " . $product['quantity'] . " sản phẩm</span>";
        $btn_add_cart = "<button value='" . $product['product_id'] . "' type='submit' onclick='add_cart(event)' class='tp-product-details-add-to-cart-btn w-100 het_hang'>Thêm vào giỏ hàng</button>";
        $btn_buy_now = "<button value='" . $product['product_id'] . "' onclick='by_now(this)' class='tp-product-details-buy-now-btn w-100 het_hang'>Mua ngay</button>";
    } else {
        $quantity = "<span class='text-danger'>Hết hàng</span>";
        $btn_add_cart = "<button value='" . $product['product_id'] . "' type='submit' onclick='het_hang()' class='tp-product-details-add-to-cart-btn w-100'>Thêm vào giỏ hàng</button>";
        $btn_buy_now = "<button onclick='het_hang()' class='tp-product-details-buy-now-btn w-100'>Mua ngay</button>";
    }
    $data = [
        'product_img' => $product['product_thumb'],
        'product_name' => $product['product_name'],
        'product_star' => str_repeat("<span><i class='fa-solid fa-star'></i></span>", round($star['star'])),
        'product_reviews' => "({$count_evaluate} bình luận và đánh giá)",
        'product_desc' => $product['product_desc'],
        'product_price' => $price,
        'quantity' => $quantity,
        'btn_add_cart' => $btn_add_cart,
        'btn_buy_now' => $btn_buy_now,
        'num_order' => "<input class='tp-cart-input' type='number' id='num-order' value='1' min='1' max='" . $product['quantity'] . "'>",
    ];
    echo json_encode($data);
}
