<?php 
require('top.php');

$resBanner=mysqli_query($con,"select * from banner where status='1' order by order_no asc");

?>
<div class="slider__container slider--one bg__cat--3 full-screen-slider">
    <div class="slide__container slider__activation__wrap owl-carousel">
        <?php while($rowBanner=mysqli_fetch_assoc($resBanner)){?>
        <div class="single__slide">
            <div class="slide__inner">
                <img src="<?php echo BANNER_SITE_PATH.$rowBanner['image']?>" alt="Banner Image">
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<style>
    .slider__container {
    position: relative;
    overflow: hidden;
}

.slide__container {
    display: flex;
}

.single__slide {
    flex: 0 0 100%; /* Responsive width for each slide */
    max-width: 100%; /* Ensure slides don't exceed container width */
    transition: transform 0.5s ease; /* Smooth transition for slide animation */
}

.slide__inner {
    width: 100%;
    height: auto;
}

.slide__inner img {
    width: 100%;
    height: auto;
    display: block;
}

/* Optional: Add additional styles for the slider navigation, pagination, etc. */

</style>

<br>

<div class="container">
    <div class="row">
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-truck"></i> <b>FREE DELIVERY & INSTALLATION </b></h5>
                    <p class="card-text">*Terms & Condition Apply</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-undo"></i> <b>EASY RETURNS</b></h5>
                    <p class="card-text">Hassle-free return within 7 days</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-globe"></i> <b>ONLINE EXCLUSIVE</b></h5>
                    <p class="card-text">Products at best prices</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-shopping-basket"></i> <b>CLICK & COLLECT</b></h5>
                    <p class="card-text">Order online, collect in store</p>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>

<style>
 .card {
    height: 100%; /* Set height to 100% */
    /* border: 1px solid #ddd; */
    border-radius: 5px;
    margin-bottom: 20px;
}

.card-title {
    font-weight: bold;
}

.card-text {
    color: #555;
}

.card-body {
    padding: 20px;
    height: 100%; /* Set height to 100% */
}

.card-body i {
    margin-right: 10px;
    font-size: 18px;
    color: #007bff;
}

.htc__category__area .category {
    border: 1px solid #fff;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 30px;
    overflow: hidden;
    background-color: #fff;
    height: 316px;
}

.htc__category__area .category img {
    width: 89%;
    height: 200px;
    display: block;
    border-bottom: 1px solid #eee;
    padding-bottom: 15px;
    margin-bottom: 15px;
}

.htc__category__area .product__action {
    list-style: none;
    padding: 0;
    margin: 0;
}

.htc__category__area .product__action li {
    display: inline-block;
    margin-right: 10px;
}

.htc__category__area .fr__product__inner {
    overflow: hidden;
}

.htc__category__area .fr__product__inner h4 a {
    color: #333;
    text-decoration: none;
}

.htc__category__area .fr__pro__prize {
    margin-top: 10px;
    padding-left: 0;
    list-style: none;
}

.htc__category__area .fr__pro__prize li {
    display: inline-block;
    margin-right: 10px;
    font-size: 14px;
    color: #999;
}

.htc__category__area .fr__pro__prize .old__prize {
    text-decoration: line-through;
    color: #999;
}

.htc__category__area .fr__pro__prize .old__prize:before {
    content: '$';
}

.htc__category__area .fr__pro__prize .new__price {
    color: #ff5722;
    font-weight: bold;
}

/* .htc__category__area .section__title--2 {
    margin-bottom: 0px;
} */

.htc__category__area .title__line {
    display: inline-block;
    position: relative;
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 20px;
    text-transform: uppercase;
}

.htc__category__area .title__line:after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 50%;
    width: 50px;
    height: 2px;
    background-color: #ff5722;
    margin-left: -25px;
}
.htc__category__area .category:hover {
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Example shadow effect */
    transition: box-shadow 0.3s ease; /* Smooth transition */
}


/* Add this CSS code */
.htc__category__area .category {
    position: relative;
    transition: transform 0.3s ease; /* Smooth transition */
}

.htc__category__area .category:hover {
    transform: translateY(-10px); /* Move the container up by 10px */
}


</style>
<!-- <hr> -->
<!-- <hr> -->
        <!-- Start Category Area -->
        <section class="htc__category__area ">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="section__title--2 text-center">
                            <h2 class="title__line">New Arrivals</h2>
                        </div>
                    </div>
                </div>
                <div class="htc__product__container">
                    <div class="row">
                        <div class="product__list clearfix mt--30">
							<?php
							$get_product=get_product($con,10);
							foreach($get_product as $list){
							?>
                            <!-- Start Single Category -->
                            <div class="col-md-4 col-lg-3 col-sm-4 col-xs-6">
                                <div class="category">
                                    <div class="ht__cat__thumb">
                                        <a href="product.php?id=<?php echo $list['id']?>">
                                            <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$list['image']?>" alt="product images">
                                        </a>
                                    </div>
                                    <div class="fr__hover__info">
										<ul class="product__action">
											<li><a href="javascript:void(0)" onclick="wishlist_manage('<?php echo $list['id']?>','add')"><i class="icon-heart icons"></i></a></li>
											<li><a href="product.php?id=<?php echo $list['id']?>" ><i class="icon-handbag icons"></i></a></li>
										</ul>
									</div>
                                    <div class="fr__product__inner">
                                        <h4><a href="product.php?id=<?php echo $list['id']?>"><?php echo $list['name']?></a></h4>
                                        <ul class="fr__pro__prize">
                                            <li class="old__prize">$<?php echo $list['mrp']?></li>
                                            <li>$<?php echo $list['price']?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Category -->
							<?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Category Area -->
        <!-- Start Product Area -->
        <section class="ftr__product__area ">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="section__title--2 text-center">
                            <h2 class="title__line">Best Seller</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="product__list clearfix mt--30">
							<?php
							$get_product=get_product($con,4,'','','','','yes');
							foreach($get_product as $list){
							?>
                            <!-- Start Single Category -->
                            <div class="col-md-4 col-lg-3 col-sm-4 col-xs-6">
                                <div class="category">
                                    <div class="ht__cat__thumb">
                                        <a href="product.php?id=<?php echo $list['id']?>">
                                            <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$list['image']?>" alt="product images">
                                        </a>
                                    </div>
                                    <div class="fr__hover__info">
										<ul class="product__action">
											<li><a href="javascript:void(0)" onclick="wishlist_manage('<?php echo $list['id']?>','add')"><i class="icon-heart icons"></i></a></li>
											<li><a href="product.php?id=<?php echo $list['id']?>" ><i class="icon-handbag icons"></i></a></li>
										</ul>
									</div>
                                    <div class="fr__product__inner">
                                        <h4><a href="product.php?id=<?php echo $list['id']?>"><?php echo $list['name']?></a></h4>
                                        <ul class="fr__pro__prize">
                                            <li class="old__prize"><?php echo $list['mrp']?></li>
                                            <li><?php echo $list['price']?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Category -->
							<?php } ?>
                        </div>
                </div>
            </div>
        </section>
        <style>
            .ftr__product__area .category {
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 30px;
    overflow: hidden;
    background-color: #fff;
}

.ftr__product__area .category img {
    width: 100%;
    height: auto;
    display: block;
    border-bottom: 1px solid #eee;
    padding-bottom: 15px;
    margin-bottom: 15px;
}

.ftr__product__area .product__action {
    list-style: none;
    padding: 0;
    margin: 0;
}

.ftr__product__area .product__action li {
    display: inline-block;
    margin-right: 10px;
}

.ftr__product__area .fr__product__inner {
    overflow: hidden;
}

.ftr__product__area .fr__product__inner h4 a {
    color: #333;
    text-decoration: none;
}

.ftr__product__area .fr__pro__prize {
    margin-top: 10px;
    padding-left: 0;
    list-style: none;
}

.ftr__product__area .fr__pro__prize li {
    display: inline-block;
    margin-right: 10px;
    font-size: 14px;
    color: #999;
}

.ftr__product__area .fr__pro__prize .old__prize {
    text-decoration: line-through;
    color: #999;
}

.ftr__product__area .fr__pro__prize .old__prize:before {
    content: '$';
}

.ftr__product__area .fr__pro__prize .new__price {
    color: #ff5722;
    font-weight: bold;
}



.ftr__product__area .title__line {
    display: inline-block;
    position: relative;
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 20px;
    text-transform: uppercase;
}

.ftr__product__area .title__line:after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 50%;
    width: 50px;
    height: 2px;
    background-color: #ff5722;
    margin-left: -25px;
}

        </style>
        <!-- End Product Area -->
		<input type="hidden" id="qty" value="1"/>
<?php require('footer.php')?>        