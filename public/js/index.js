function add_cart(event) {
    event.preventDefault();//Thêm sản phẩm vào giỏ hàng
    var product_id = event.target.value;
    var quantity = $("#num-order").val();
    var data = {
        product_id: product_id,
        quantity: quantity,
    };
    $.ajax({
        url: '?mod=cart&action=add_cart',
        method: 'POST',
        data: data,
        dataType: 'json',
        success: function (data) {
            // Cập nhật giao diện người dùng sau khi thêm vào giỏ hàng
            $("#menu_total_cart").html(data.total_cart);
            $("#num-order").val(1);
            $("#num-order").attr('max', data.quantity);
            $("#menu_total_cart_sm").html(data.total_cart);
            $("#total_price_cart").html(data.total);
            $("#list_add_cart").html(data.list_add_cart);
            if (data.quantity > 0) {
                $("#quantity_product").html("<span>Còn " + data.quantity + " sản phẩm</span>");
            } else {
                $("#quantity_product").html("<span class='text-danger'>Hết hàng</span>");
                $(".het_hang").attr('onclick', "het_hang()");
            }
            Swal.fire({
                icon: 'success',
                title: 'Đã thêm vào giỏ hàng',
                showConfirmButton: false,
                timer: 3000
            });
        },

    });
}


var input = document.getElementById('num-order');

// Ngăn chặn việc nhập giá trị trực tiếp
input.addEventListener('keydown', function (e) {
    e.preventDefault();
});




function quickView(_this) {//Phần QuickView
    var product_id = $(_this).val();
    var data = { product_id: product_id };
    $.ajax({
        url: '?mod=product&action=quickView_ajax',
        method: 'POST',
        data: data,
        dataType: 'json',
        success: function (data) {
            $("#product_img").html("<img style='height: 600px; width: 600px;' class='image_product' src='admin/img/" + data.product_img + "' alt=''>");
            $("#product_name").html(data.product_name);
            $("#product_star").html(data.product_star);
            $("#product_reviews").html(data.product_reviews);
            $("#product_desc").html(data.product_desc);
            $("#product_price").html(data.product_price);
            $("#quantity_product").html(data.quantity);
            $("#status").html(data.num_order);
            $("#btn_add_cart").html(data.btn_add_cart);
            $("#btn_buy_now").html(data.btn_buy_now);
        }
    });
}

function changPrice(_this) {//Thay đỏi giá khi chon nơi vận chuyển
    var idShip = $(_this).val();
    var voucher = $("#voucher").val();
    if (voucher == undefined) {
        voucher = 0;
    }
    var data = {
        idShip: idShip,
        voucher: voucher,
    }
    console.log(data);
    $.ajax({
        url: '?mod=cart&action=chang_price',
        method: 'POST',
        data: data,
        dataType: 'html',
        success: function (data) {
            $("#total_pay").html(data);
        }
    });
}

function apply_voucher() { //Áp dụng voucher
    var voucher = $("#voucher").val();
    var shipping = $('input[name="shipping"]:checked').val();
    if (shipping === undefined) {
        shipping = 0;
    }
    //Kiểm tra xem mã giảm giá có được nhập hay không
    var data = {
        voucher: voucher,
        shipping: shipping,
    };
    console.log(data);
    $.ajax({
        url: '?mod=cart&action=apply_voucher_ajax',
        method: 'POST',
        data: data,
        dataType: 'json',
        success: function (data) {
            console.log(data);
            if (data.status == 'success') {
                $("#total_pay").html(data.total);
                $("#voucher").attr("readonly", true);
                $("#apply_voucher").html("<span class='text-success font-weight-bold'>Đã áp dụng</span>");
                $('#voucher').attr('name', 'voucher');
                $("#discount").html("<span>Giảm giá</span><span class='text-danger'>-" + data.discount + "</span>");
                Swal.fire({
                    icon: 'success',
                    title: 'Áp dụng Voucher thành công',
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                $("#voucher").val("");
                Swal.fire({
                    icon: 'error',
                    title: 'Mã khuyễn mãi không hợp lệ!',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        }
    });
}

function tablist(_this) {//Thay đổi tiêu đề sản phẩm trang home
    var value = $(_this).attr("id");
    console.log(value);
    $("#product_title").html(value);
}

// Phần sản phẩm yêu thích

function favourite(_this) {//Thêm vào danh sách yêu thích
    var product_id = $(_this).val();
    var data = {
        product_id: product_id
    };
    $.ajax({
        url: '?mod=wishlist&action=add_wishlist_ajax',
        method: 'POST',
        data: data,
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $(".count_wishlist").html(data.count);
            $(_this).css("background-color", "palevioletred");
            $(_this).off("click"); // Tắt sự kiện click hiện tại
            $(_this).attr("onclick", "delete_favourite(this)");
        }
    });
}

function delete_favourite(_this) {//xÓA KHỎI DANH SÁCH YÊU THÍCH
    var product_id = $(_this).val();
    var data = {
        product_id: product_id
    };
    $.ajax({
        url: '?mod=wishlist&action=delete_favourite',
        method: 'POST',
        data: data,
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $(".count_wishlist").html(data.count);
            $(_this).css("background-color", "");
            $(_this).on("click"); // Bật sự kiện click hiện tại
            $(_this).attr("onclick", "favourite(this)");
        }
    });
}



function delete_wishlist(_this) {
    var product_id = $(_this).attr('product_id');
    var data = {
        product_id: product_id
    }
    $.ajax({
        url: '?mod=wishlist&action=delete_wishlist_ajax',
        method: 'POST',
        data: data,
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $(".count_wishlist").html(data.count_wishlist);
            $("#list_wishlist").html(data.list_wishlist);
        }
    });
}
// End phần sản phẩm yêu thích

//Phần so sánh sản phâm
function add_compare(_this) { //Thêm vào sản phẩm so sánh
    var product_id = $(_this).val();
    var data = {
        product_id: product_id,
    }
    $.ajax({
        url: '?mod=compare&action=add_compare_ajax',
        method: 'POST',
        data: data,
        dataType: 'json',
        success: function (data) {
            console.log(data);
            if (data.status == 'success') { //Thành công
                $(".count_compare").html(data.count);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Không thể thêm!',
                    text: "Sản phẩm so sanh chỉ tối đa 4 sản phẩm",
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        }
    });
}


function delete_compare(_this) {//Xóa so sánh sản phẩm
    var color_id = $(_this).attr('color_id');
    var data = {
        color_id: color_id
    }
    $.ajax({
        url: '?mod=compare&action=delete_compare_ajax',
        method: 'POST',
        data: data,
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $("#list_compare").html(data.list_compare);
            $(".count_compare").html(data.count_compare);
        }
    });
}
//End so sánh sản phẩm


function by_now(_this) {//Mua ngay
    var product_id = $(_this).val();
    var quantity = $("#num-order").val();
    window.location.href = "?mod=cart&action=buy_now&product_id=" + product_id + "&quantity=" + quantity;
}

function het_hang() {
    Swal.fire({
        icon: 'error',
        title: 'Đã hết hàng!',
        text: "Sản phẩm không còn hàng",
        showConfirmButton: false,
        timer: 3000
    });
}

function payOnline(_this) {
    var pay = $(_this).val();
    console.log('Selected payment method:', pay);
    if (pay == 1) {
        $("#order_buy1").html("<input type='submit' name='order_buy' class='tp-checkout-btn w-100' id='order-now' value='Đặt hàng'>");
    } else if (pay == 2) {
        $("#order_buy1").html("<input type='submit' name='payUrl' class='tp-checkout-btn w-100' id='order-now' value='Thanh toán'>");
    } else if (pay == 3) {
        $("#order_buy1").html("<input type='submit' name='redirect' class='tp-checkout-btn w-100' id='order-now' value='Thanh toán'>");
    }
}