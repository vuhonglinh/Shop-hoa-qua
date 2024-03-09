<?php
$settings = db_fetch_row("SELECT * FROM `tb_settings`");
?>
<!-- footer area start -->
<footer>
    <div class="tp-footer-area" data-bg-color="footer-bg-grey">
        <div class="tp-footer-top pt-95 pb-40">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-3 col-md-4 col-sm-6">
                        <div class="tp-footer-widget footer-col-1 mb-50">
                            <div class="tp-footer-widget-content">
                                <div class="tp-footer-logo">
                                    <a href="trang-chu.html">
                                        <img width="130px" height="90px" src="admin/img/<?php echo $settings['logo'] ?>" alt="logo">
                                    </a>
                                </div>
                                <p class="tp-footer-desc"><?php echo $settings['introduce'] ?></p>
                                <div class="tp-footer-social">
                                    <a href="https://www.facebook.com/groups/6699202613534867/"><i class="fa-brands fa-facebook-f"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                        <div class="tp-footer-widget footer-col-2 mb-50">
                            <h4 class="tp-footer-widget-title">Tài khoản của tôi</h4>
                            <div class="tp-footer-widget-content">
                                <ul>
                                    <li><a href="gio-hang.html">Giỏ hàng</a></li>
                                    <li><a href="?mod=wishlist&action=main">Yêu thích</a></li>
                                    <?php if (isset($_SESSION['is_login'])) : ?>
                                        <li><a href="?mod=users&action=index">Danh sách đơn hàng</a></li>
                                        <li><a href="?mod=users&action=index">Tài khoản</a></li>
                                        <li><a href="?mod=users&action=index">Lịch sử</a></li>
                                        <li><a href="?mod=users&action=index">Đổi mật khẩu</a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="tp-footer-widget footer-col-3 mb-50">
                            <h4 class="tp-footer-widget-title">Thông tin</h4>
                            <div class="tp-footer-widget-content">
                                <ul>
                                    <li><a href="gioi-thieu-1.html">Giới thiệu</a></li>
                                    <li><a href="lien-he-2.html">Liên hệ</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="tp-footer-widget footer-col-4 mb-50">
                            <h4 class="tp-footer-widget-title">Thông tin cửa hàng</h4>
                            <div class="tp-footer-widget-content">
                                <div class="tp-footer-talk mb-20">
                                    <span>Số điện thoại</span>
                                    <h4><a href="tel:670-413-90-762"><?php echo $settings['phone'] ?></a></h4>
                                </div>
                                <div class="tp-footer-contact">
                                    <div class="tp-footer-contact-item d-flex align-items-start">
                                        <div class="tp-footer-contact-icon">
                                            <span>
                                                <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 5C1 2.2 2.6 1 5 1H13C15.4 1 17 2.2 17 5V10.6C17 13.4 15.4 14.6 13 14.6H5" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M13 5.40039L10.496 7.40039C9.672 8.05639 8.32 8.05639 7.496 7.40039L5 5.40039" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M1 11.4004H5.8" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M1 8.19922H3.4" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="tp-footer-contact-content">
                                            <p><a href="mailto:shofy@support.com"><?php echo $settings['email'] ?></a></p>
                                        </div>
                                    </div>
                                    <div class="tp-footer-contact-item d-flex align-items-start">
                                        <div class="tp-footer-contact-icon">
                                            <span>
                                                <svg width="17" height="20" viewBox="0 0 17 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M8.50001 10.9417C9.99877 10.9417 11.2138 9.72668 11.2138 8.22791C11.2138 6.72915 9.99877 5.51416 8.50001 5.51416C7.00124 5.51416 5.78625 6.72915 5.78625 8.22791C5.78625 9.72668 7.00124 10.9417 8.50001 10.9417Z" stroke="currentColor" stroke-width="1.5" />
                                                    <path d="M1.21115 6.64496C2.92464 -0.887449 14.0841 -0.878751 15.7889 6.65366C16.7891 11.0722 14.0406 14.8123 11.6313 17.126C9.88298 18.8134 7.11704 18.8134 5.36006 17.126C2.95943 14.8123 0.210885 11.0635 1.21115 6.64496Z" stroke="currentColor" stroke-width="1.5" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="tp-footer-contact-content">
                                            <p><a href="https://maps.app.goo.gl/ZmY7SmDe3Ln42nZHA" target="_blank"><?php echo $settings['address'] ?></a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tp-footer-bottom">
            <div class="container">
                <div class="tp-footer-bottom-wrapper">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="tp-footer-copyright">
                                <p>CTTNHT phân phối trên cả nước <a href="trang-chu.html">Autosmart </a>.</p>
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="tp-footer-payment text-md-end">
                                <p>
                                    <img src="assets/img/footer/footer-pay.png" alt="">
                                </p>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer area end -->
<!-- Phần cũ -->
<script src="public/js/code.jquery.com_jquery-3.3.1.slim.min.js"></script>
<script src="public/js/cdn.jsdelivr.net_npm_bootstrap@4.6.2_dist_js_bootstrap.bundle.min.js"></script>
<script src="public/js/cdn.jsdelivr.net_npm_jquery@3.5.1_dist_jquery.slim.min.js"></script>
<script src="public/js/code.jquery.com_jquery-3.7.1.min.js"></script>
<script src="public/js/code.jquery.com_jquery-3.7.0.min.js"></script>
<script src="public/bootstrap/js/bootstrap.min.js"></script>
<script src="public/js/index.js" text="type/javascript"></script>
<script src="public/js/app.js" text="type/javascript"></script>
<!-- JS here -->
<script src="assets/js/vendor/jquery.js"></script>
<script src="assets/js/vendor/waypoints.js"></script>
<script src="assets/js/bootstrap-bundle.js"></script>
<script src="assets/js/meanmenu.js"></script>
<script src="assets/js/swiper-bundle.js"></script>
<script src="assets/js/slick.js"></script>
<script src="assets/js/range-slider.js"></script>
<script src="assets/js/magnific-popup.js"></script>
<script src="assets/js/nice-select.js"></script>
<script src="assets/js/purecounter.js"></script>
<script src="assets/js/countdown.js"></script>
<script src="assets/js/wow.js"></script>
<script src="assets/js/isotope-pkgd.js"></script>
<script src="assets/js/imagesloaded-pkgd.js"></script>
<script src="assets/js/ajax-form.js"></script>
<script src="assets/js/main.js"></script>

</body>

<!-- Mirrored from html.hixstudio.net/shofy-prv/shofy/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 21 Nov 2023 05:12:52 GMT -->

</html>