<?php require_once "header.php"; ?>

<link href="css/home.css" rel="stylesheet">
    <main>
        <div class="hero_single version_1">
            <div class="opacity-mask">
                <div class="container">
                    <div class="row justify-content-lg-start justify-content-md-center">
                        <div class="col-xl-7 col-lg-8">
                            <h1>Yemek ve Market İhtiyaçlarınız Kapınızda!</h1>
                            <p>Lezzet ve Hız Kapınızda: <span class="element" style="font-weight: 500"></span></p>
                            <form method="post" action="foods.php">
                                <div class="row g-0 custom-search-input">
                                    <div class="col-lg-10">
                                        <div class="form-group">
                                            <input class="form-control no_border_r" type="text" name="adres" placeholder="Address, mahalle...">
                                                <button type="button" id="gpsButton" class="gps-button">
                                                    <span class="fs1" aria-hidden="true" data-icon="&#xe081;"></span>
                                                </button>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <button class="btn_1 gradient" type="submit">Keşfet</button>
                                    </div>
                                </div>
                                <!-- /row -->
                                <div class="search_trends">
                                    <h5>Trendler:</h5>
                                    <ul>
                                        <li><a href="#0">Tatlı</a></li>
                                        <li><a href="#0">Pizza</a></li>
                                        <li><a href="#0">Tavuk</a></li>
                                        <li><a href="#0">Köfte</a></li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wave hero"></div>
        </div>

                <div class="banner lazy" data-bg="url(img/banner_bg_desktop.jpg)">
                    <div class="wrapper d-flex align-items-center opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.3)">
                        <div>
                            <small>Lezzet Sepeti</small>
                            <h3>Lezzet Kapınızda, Keyif Sizde!</h3>
                            <p>En sevdiğiniz yemekler kapınıza kadar gelirken, keyifli anlar sizinle!</p>
                            <a href="grid-listing-filterscol.html" class="btn_1 gradient">Sipariş Ver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="shape_element_2">
            <div class="container margin_60_0">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="box_how">
                                    <figure><img src="img/lazy-placeholder-100-100-white.png" data-src="img/how_1.svg" alt="" width="150" height="167" class="lazy"></figure>
                                    <h3>Kolay Sipariş</h3>
                                    <p>Hızlı ve pratik sipariş süreciyle lezzetli yemekler bir tık uzağınızda!</p>
                                </div>
                                <div class="box_how">
                                    <figure><img src="img/lazy-placeholder-100-100-white.png" data-src="img/how_2.svg" alt="" width="130" height="145" class="lazy"></figure>
                                    <h3>Hızlı Teslimat</h3>
                                    <p>Hızlı teslimat ile zahmetsizce sipariş verin ve yemeğin tadını çıkarın!</p>
                                </div>
                            </div>
                            <div class="col-lg-6 align-self-center">
                                <div class="box_how">
                                    <figure><img src="img/lazy-placeholder-100-100-white.png" data-src="img/how_3.svg" alt="" width="150" height="132" class="lazy"></figure>
                                    <h3>Yemeğin Tadını Çıkar</h3>
                                    <p>Siparişinizi zahmetsizce verin ve yemeğin tadını çıkarın; lezzet kapınıza geliyor!</p>
                                </div>
                            </div>
                        </div>
                        <p class="text-center mt-3 d-block d-lg-none"><a href="#0" class="btn_1 medium gradient pulse_bt mt-2">Register Now!</a></p>
                    </div>
                    <div class="col-lg-5 offset-lg-1 align-self-center">
                        <div class="intro_txt">
                            <div class="main_title">
                                <span><em></em></span>
                                <h2>Hemen Sipariş Vermeye Başlayın</h2>
                            </div>
                            <p class="lead">Bir tıkla en sevdiğiniz lezzetleri hemen sipariş edin ve anında kapınıza gelsin. Lezzetli bir deneyim için beklemeye gerek yok!</p>
                            <p>Favori yemeklerinizi şimdi sipariş edin ve hızlıca kapınıza gelsin. Lezzet dolu anlar için bir adım uzağınızdayız!</p>
                            <p><a href="#0" class="btn_1 medium gradient pulse_bt mt-2">Sipariş Ver</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <?php require_once "footer.php"; ?>