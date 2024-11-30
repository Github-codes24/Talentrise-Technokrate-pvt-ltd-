<?php 
ob_start();
require('top.php');
if(isset($_GET['id'])){
	$product_id=mysqli_real_escape_string($con,$_GET['id']);
	if($product_id>0){
		$get_product=get_product($con,'','',$product_id);
	}else{
		?>
		<script>
		window.location.href='index.php';
		</script>
		<?php
	}
	
	$resMultipleImages=mysqli_query($con,"select product_images from product_images where product_id='$product_id'");
	$multipleImages=[];
	if(mysqli_num_rows($resMultipleImages)>0){
		while($rowMultipleImages=mysqli_fetch_assoc($resMultipleImages)){
			$multipleImages[]=$rowMultipleImages['product_images'];
		}
	}
	
	$resAttr=mysqli_query($con,"select product_attributes.*,color_master.color,size_master.size from product_attributes 
	left join color_master on product_attributes.color_id=color_master.id and color_master.status=1 
	left join size_master on product_attributes.size_id=size_master.id and size_master.status=1
	where product_attributes.product_id='$product_id'");
	$productAttr=[];
	$colorArr=[];
	$sizeArr=[];
	if(mysqli_num_rows($resAttr)>0){
		while($rowAttr=mysqli_fetch_assoc($resAttr)){
			$productAttr[]=$rowAttr;
			$colorArr[$rowAttr['color_id']][]=$rowAttr['color'];
			$sizeArr[$rowAttr['size_id']][]=$rowAttr['size'];
			
			$colorArr1[]=$rowAttr['color'];
			$sizeArr1[]=$rowAttr['size'];
		}
	}
	$is_size=count(array_filter($sizeArr1));
	$is_color=count(array_filter($colorArr1));
	//$colorArr=array_unique($colorArr);
	//$sizeArr=array_unique($sizeArr1);
}else{
	?>
	<script>
	window.location.href='index.php';
	</script>
	<?php
}

if(isset($_POST['review_submit'])){
	$rating=get_safe_value($con,$_POST['rating']);
	$review=get_safe_value($con,$_POST['review']);
	
	$added_on=date('Y-m-d h:i:s');
	mysqli_query($con,"insert into product_review(product_id,user_id,rating,review,status,added_on) values('$product_id','".$_SESSION['USER_ID']."','$rating','$review','1','$added_on')");
	header('location:product.php?id='.$product_id);
	die();
}


$product_review_res=mysqli_query($con,"select users.name,product_review.id,product_review.rating,product_review.review,product_review.added_on from users,product_review where product_review.status=1 and product_review.user_id=users.id and product_review.product_id='$product_id' order by product_review.added_on desc");

?>

        <!-- Start Product Details Area -->
        <section class="htc__product__details bg__white ptb--100">
            <!-- Start Product Details Top -->
            <div class="htc__product__details__top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
                            <div class="htc__product__details__tab__content">
                                <!-- Start Product Big Images -->
                                <div class="product__big__images">
                                    <div class="portfolio-full-image tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active imageZoom" id="img-tab-1">
                                            <img  width="" data-origin="<?php echo PRODUCT_IMAGE_SITE_PATH.$get_product['0']['image']?>" src="<?php echo PRODUCT_IMAGE_SITE_PATH.$get_product['0']['image']?>">
                                        </div>
										
										<?php if(isset($multipleImages[0])){?>
										<div id="multiple_images">
											<?php
											foreach($multipleImages as $list){
			echo "<img src='".PRODUCT_MULTIPLE_IMAGE_SITE_PATH.$list."' onclick=showMultipleImage('".PRODUCT_MULTIPLE_IMAGE_SITE_PATH.$list."')>";
											}
											?>
											
										</div>
										<?php } ?>
                                    </div>
                                </div>
                                <!-- End Product Big Images -->
                                <style>
/* Add this CSS code */
.product__big__images {
    margin-top: 20px; /* Add margin to the top */
}

#multiple_images img {
    margin-right: 10px; /* Add margin between the images */
}
</style>

                            </div>
                        </div>
                        <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12 smt-40 xmt-40">
                            <div class="ht__product__dtl">
                                <h2><?php echo $get_product['0']['name']?></h2>
                           <p class="pro__info"><?php echo $get_product['0']['short_desc']?></p>    
                               
                                <div class="ht__pro__desc">
									<?php 
									$cart_show='yes';
									$is_cart_box_show="hide";
									if($is_color==0 && $is_size==0){
										$is_cart_box_show="";
									?>
								
                                    <div class="sin__desc">
										<?php
											$getProductAttr=getProductAttr($con,$get_product['0']['id']);
										
											$productSoldQtyByProductId=productSoldQtyByProductId($con,$get_product['0']['id'],$getProductAttr);
											
											$pending_qty=$get_product['0']['qty']-$productSoldQtyByProductId;
											
											$cart_show='yes';
											if($get_product['0']['qty']>$productSoldQtyByProductId){
												$stock='In Stock';			
											}else{
												$stock='Not in Stock';
												$cart_show='';
											}
										
										?>
                                        <p><span>Availability:</span> <?php echo $stock?></p>
                                    </div>
									<?php } ?>
                                    <div class="product-info-delivery">
        <div class="lead-time">
            <div class="image-container">
                <img alt="delivery" src="//www.vividads.com.au/cdn/shop/t/142/assets/black-time-icon.svg?v=154363779411411669731666830421" data-src="//www.vividads.com.au/cdn/shop/t/142/assets/black-time-icon.svg?v=154363779411411669731666830421" class="ls-is-cached lazyloaded" width="35" height="35">
            </div>
        
            
        
            
                <div class="fs14"><b>Production: <br>24 hour*</b> <div class="relative inline-block hidden-sm hidden-xs"><img alt="info" class="hs-lazyload hs-id-a5d1d42d ls-is-cached lazyloaded" data-src="//www.vividads.com.au/cdn/shop/t/142/assets/info-black.svg?v=89716064132208844901666836512" height="15" width="15" src="//www.vividads.com.au/cdn/shop/t/142/assets/info-black.svg?v=89716064132208844901666836512">        
                  <div class="lead-time-tooltip">
                
Production time is  24hrs  if the artwork is approved by 6 pm AEST on a working day.<br>
                    The production timeline starts after proof approval. Based on volume and product complexity, each order has a different length of production time.
                </div></div></div>          
                    
        </div>                
        <div class="shipping">
            <div class="image-container">
                <img alt="delivery-icon" src="//www.vividads.com.au/cdn/shop/t/142/assets/delivery-icon-box.svg?v=39668590523460072141666571759" height="36" data-src="//www.vividads.com.au/cdn/shop/t/142/assets/delivery-icon-box.svg?v=39668590523460072141666571759" class="ls-is-cached lazyloaded" width="35">
            </div>
            <div class="fs14"><b>Shipping: <br>$14.95*</b>
                <div class="relative inline-block hidden-sm hidden-xs"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 12.35 12.31" style="enable-background:new 0 0 12.35 12.31;" xml:space="preserve" width=" 15 ">
<style type="text/css">	
	.st9{fill:#FFFFFF;}
	.st12{fill:#272425;}	
</style>
<g>
	<circle class="st12" cx="6.18" cy="6.16" r="5.99"></circle>
	<g>
		<g>
			<path class="st9" d="M7.39,8.32C7.53,8.4,7.67,8.48,7.81,8.56c-0.03,0.06-0.07,0.12-0.1,0.18C7.47,9.15,7.2,9.55,6.85,9.88
				c-0.27,0.26-0.58,0.46-0.95,0.55C5.7,10.48,5.5,10.5,5.3,10.46c-0.36-0.07-0.62-0.33-0.68-0.7C4.58,9.47,4.61,9.18,4.69,8.9
				C4.94,7.94,5.2,6.98,5.46,6.02c0.01-0.06,0.03-0.11,0.04-0.17c0.02-0.16-0.05-0.28-0.2-0.34c-0.09-0.03-0.2-0.05-0.3-0.05
				c-0.13-0.01-0.25,0-0.38,0c-0.02,0-0.04,0-0.06,0c0.05-0.15,0.09-0.29,0.13-0.43C4.7,4.97,4.72,4.94,4.79,4.94
				c0.8-0.03,1.59-0.06,2.39-0.1c0.03,0,0.05,0,0.09,0c0,0.02-0.01,0.04-0.01,0.05C6.88,6.3,6.51,7.7,6.13,9.11
				C6.1,9.23,6.08,9.34,6.06,9.46C6.05,9.54,6.05,9.63,6.13,9.68C6.2,9.74,6.29,9.71,6.35,9.66c0.1-0.07,0.21-0.16,0.29-0.25
				c0.29-0.31,0.51-0.67,0.71-1.04C7.37,8.36,7.38,8.34,7.39,8.32z"></path>
		</g>
		<g>
			<path class="st9" d="M7.71,2.79c0,0.53-0.42,0.94-0.95,0.94c-0.52,0-0.94-0.42-0.94-0.95c0-0.53,0.42-0.94,0.95-0.94
				C7.3,1.85,7.71,2.27,7.71,2.79z"></path>
		</g>
	</g>
</g>
</svg>
</div>
            </div>        	
        </div>
    </div>
<style>
    .product-info-delivery .shipping .image-container {
    max-width: 40px;
    margin-right: 6px;
    width: 100%;
}
.product-info-delivery {
    display: flex;
    width: 60%;
}
    .product-info-delivery .shipping {
    position: relative;
    line-height: normal;
    display: flex;
    align-items: center;
    padding: 5px;
    margin: 5px;
    width: 41%;
    /* justify-content: center; */
    border-radius: 10px;
    background: #f1f1f1;
}
	.image-container {
    max-width: 40px;
    margin-right: 6px;
    width: 100%;
}
	.lead-time {
		position: relative;
    line-height: normal;
    display: flex;
    align-items: center;
    padding: 5px;
    margin: 5px;
    width: 41%;
    /* height: 58px; */
    border-radius: 10px;
    background: #f1f1f1;
    /* margin-left: 38%; */
	}
	
	/* Style for the tooltip */
.lead-time-tooltip {
    display: none;
    position: absolute;
    background-color: #fff;
    border: 1px solid #ccc;
    padding: 10px;
    z-index: 1;
    width: 250px; /* Adjust tooltip width as needed */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add shadow effect */
}

/* Triangle shape for tooltip */
.lead-time-tooltip:before {
    content: ''; 
    position: absolute;
    top: -10px;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: transparent transparent #ccc transparent;
}

/* Show tooltip text when hovering over the image */
.image-container img:hover + .lead-time-tooltip {
    display: block;
}

</style>
<script>document.addEventListener("DOMContentLoaded", function() {
    var leadTime = document.querySelector(".lead-time");
    var leadTimeTooltip = leadTime.querySelector(".lead-time-tooltip");

    leadTime.addEventListener("mouseenter", function() {
        leadTimeTooltip.style.display = "block";
    });

    leadTime.addEventListener("mouseleave", function() {
        leadTimeTooltip.style.display = "none";
    });
});
</script>

				
		<?php if($is_color > 0): ?>
    <div class="sin__desc align--left">
        <p><span>color:</span></p>
        <ul class="pro__color" id="colorList">
            <?php foreach($colorArr as $key => $val): ?>
                <li>
                    <a href="javascript:void(0)" onclick="selectColor(this, '<?php echo $key; ?>','<?php echo $get_product['0']['id']; ?>','color')" style="background: <?php echo $val[0]; ?>; border-radius: 50%; display: inline-block; width: 30px; height: 30px;"></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <script>
        function selectColor(element, key, productId, attribute) {
            // Reset all colors to default size
            var colorList = document.getElementById('colorList').getElementsByTagName('a');
            for (var i = 0; i < colorList.length; i++) {
                colorList[i].style.width = '30px';
                colorList[i].style.height = '30px';
            }
            
            // Increase the size of the selected color
            element.style.width = '40px';
            element.style.height = '40px';

            // Perform other actions here, such as loading attributes
            loadAttr(key, productId, attribute);
        }
    </script>
<?php endif; ?>

									
																			
									<?php if($is_size>0){?>
									<div class="sin__desc align--left">
										<p><span>size:</span></p>
										<select class="select__size" id="size_attr" onchange="showQty()" style="
											width: 259px;
											height: 40px;
											border-radius: 5px;
											border-color: rgb(142, 198, 71);
											
                                            margin-left: 91px;
										">
										
											<option value="">Size</option>
											<?php 
											foreach($sizeArr as $key=>$val){
												echo "<option value='".$key."'>".$val[0]."</option>";
											}
											?>
											
										</select>
									</div>
									<?php } ?>
                                  <?php
$res = mysqli_query($con, "SELECT * FROM product_attributes WHERE product_id = '$product_id'");
if($res && mysqli_num_rows($res) > 0) {
    // Data is available, so render the dropdowns
    while($row = mysqli_fetch_assoc($res)) {
        // Render dropdown for Paper
        if(!empty($row['paper'])) {
            echo "<div class='sin__desc align--left'>";
            echo "<p><span>Paper:</span></p>";
            echo "<select class='select__size' id='paper_attr' style='width: 259px; height: 40px; margin-left: 22px; border-radius: 5px; border-color: rgb(142, 198, 71); margin-left: 76px;'>";
            echo "<option value=''>Select Paper</option>";
            echo "<option value='".$row['paper']."'>".$row['paper']."</option><br>";
            echo "</select>";
            echo "</div>";
        }

        // Render dropdown for Future Color
        if(!empty($row['future_color'])) {
            echo "<div class='sin__desc align--left'>";
            echo "<p><span>Future Color:</span></p>";
            echo "<select class='select__size' id='future_color_attr' style='width: 259px; height: 40px; margin-left: 22px; border-radius: 5px; border-color: rgb(142, 198, 71); margin-left: 38px;'>";
            echo "<option value=''>Select Future Color</option>";
            echo "<option value='".$row['future_color']."'>".$row['future_color']."</option><br>";
            echo "</select>";
            echo "</div>";
        }

        // Render dropdown for Rounded Corner
        if(!empty($row['rounded_corner'])) {
            echo "<div class='sin__desc align--left'>";
            echo "<p><span>Rounded Corner:</span></p>";
            echo "<select class='select__size' id='rounded_corner_attr' style='width: 259px; height: 40px; margin-left: 22px; border-radius: 5px; border-color: rgb(142, 198, 71); margin-left: 2px;'>";
            echo "<option value=''>Select Rounded Corner</option>";
            echo "<option value='".$row['rounded_corner']."'>".$row['rounded_corner']."</option><br>";
            echo "</select>";
            echo "</div>";
        }

        // Render dropdown for Coating
        if(!empty($row['coating'])) {
            echo "<div class='sin__desc align--left'>";
            echo "<p><span>Coating:</span></p>";
            echo "<select class='select__size' id='coating_attr' style='width: 259px; height: 40px; margin-left: 22px; border-radius: 5px; border-color: rgb(142, 198, 71); margin-left: 62px;'>";
            echo "<option value=''>Select Coating</option>";
            echo "<option value='".$row['coating']."'>".$row['coating']."</option><br>";
            echo "</select>";
            echo "</div>";
        }
    }
} else {
    // Data is not available, so hide the dropdowns
    echo "<style>";
    echo ".sin__desc { display: none; }";
    echo "</style>";
}
?>



									
									
									
									<?php
									$isQtyHide="hide";
									if($is_color==0 && $is_size==0){
										$isQtyHide="";
									}
									?>
									
									
									<div class="sin__desc align--left <?php echo $isQtyHide?>" id="cart_qty">
										<?php
										if($cart_show!=''){
										?>
                                        <p><span>Qty:</span> 
										<select id="qty"  class="select__size" style="
											width: 259px;
											height: 40px;
											margin-left: 22px;
											border-radius: 5px;
											border-color: rgb(142, 198, 71);
                                            margin-left: 92px;
										">
											<?php
											for($i=1;$i<=$pending_qty;$i++){
												echo "<option>$i</option>";
											}
											?>
										</select>
										</p>
										<?php } ?>
                                    </div>
                                   

                                 
<style>
 /* Your existing styles */
.image-container {
    max-width: 40px;
    margin-right: 6px;
    width: 100%;
}

/* Style for the tooltip */
.lead-time-tooltip {
    display: none;
    position: absolute;
    background-color: #fff;
    border: 1px solid #ccc;
    padding: 10px;
    z-index: 1;
    width: 250px; /* Adjust tooltip width as needed */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add shadow effect */
    top: calc(100% + 10px); /* Position below the button */
    left: 0; /* Align with the button */
}

/* Triangle shape for tooltip */
.lead-time-tooltip:before {
    content: ''; 
    position: absolute;
    top: -10px;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: transparent transparent #ccc transparent;
}

/* Show tooltip text when the button is clicked */
#buy-more-button:focus + #buy-more-section-wrapper .tp-container {
    display: block;
}

/* Styles for the buy-more section */
.buy-more-section-wrapper {
    position: relative;
    width: 39%;
    border: 1px solid #4fbd3b;
    border-radius: 3px;
    margin-left: 57px;
    /* padding: 0px; */
    margin-top: inherit;
}

#buy-more-button {
    padding: 14px 16px;
    font-size: 16px;
    color: var(--theme-blue-color);
    display: block;
    text-decoration: none;
}

.tp-container {
    display: none;
    position: absolute;
    top: calc(100% + 5px); /* Position below the button */
    left: 0; /* Align with the button */
    width: 100%; /* Take full width */
    background-color: #fff;
    border: 1px solid #e2e2e2;
    border-top: none;
    border-radius: 0 0 3px 3px;
    margin-top: 6px;
}
</style>
<div class="requiredesignstep"><label>How would you like to submit your design file?</label>                               
                  <div class="flex-wrapper sm:block">
                      
                      <div class="option clicked" id="design_exist"><a href="#" class=""><b>Upload <br>finished artwork</b><br><p class="additional-info">Print-Ready Files</p></a></div>
                      
<div class="option" id="design_assist"><a href="#" class=""><b>Let us design <br>one for you</b><br><p class="additional-info">*Charges apply</p></a></div></div>
              </div>


              <style>
                .requiredesignstep {
    margin: 10px 0;
    padding: 0 10px 10px;
    background: #f6f6f6;
    border-radius: 10px;
}

.requiredesignstep label {
    color: #3C3C3C;
    font-size: 16px;
    display: inline-block;
    max-width: 100%;
    margin-bottom: 5px;
    font-weight: 700;
    margin: 13px 0px;
}

.flex-wrapper {
    display: flex;
}

.requiredesignstep .option:first-child {
    margin-left: 0;
}
.option.clicked {
    border: 4px solid rgba(0, 125, 250, .6);
}
.requiredesignstep .option {
    transition: opacity .2s ease-in-out;
}

.requiredesignstep .option a {
    display: block;
    font-size: 16px;
    text-decoration: none;
    letter-spacing: 0;
    text-align: center;
    color: #3C3C3C;
}
.requiredesignstep .option {
    padding: 10px 5px;
    text-align: left;
    margin: 5px;
    border: 2px solid #e2e2e2;
    color: black;
    line-height: 16px;
    letter-spacing: 0.5px;
    cursor: pointer;
    border-radius: 5px;
    color: #3C3C3C;
    font-size: 16px;
}
.requiredesignstep .option {
    flex-basis: 33%;
    background: white;
}

.requiredesignstep .option {
    transition: opacity .2s ease-in-out;
}
.requiredesignstep .option {
    transition: opacity .2s ease-in-out;
}
.requiredesignstep .option {
    position: relative;
}

.option .additional-info {
    color: #323232;
    text-transform: capitalize;
    display: block;
    text-align: center;
    padding-top: 5px;
    font-size: 14px;
}
              </style>



						<div id="cart_attr_msg"></div>
									
                                    <div class="sin__desc align--left">
                                        <p><span>Categories:</span></p>
                                        <ul class="pro__cat__list">
                                            <li><a href="#"><?php echo $get_product['0']['categories']?></a></li>
										
                                        </ul>

                                    </div>
												<ul class="pro__prize">
				<li class="old__prize" style="font-size: 26px;"><del>$<?php echo number_format($get_product['0']['mrp'], 2) ?></del></li>
				<li class="new__price" style="font-size: 30px;">$<?php echo number_format($get_product['0']['price'], 2) ?></li>
			</ul>


							
                                    </div>
									
                                </div>
								
								<div id="is_cart_box_show" class="<?php echo $is_cart_box_show?>">
								
									<a class="fr__btn" href="javascript:void(0)" onclick="manage_cart('<?php echo $get_product['0']['id']?>','add')">Add to cart</a>
									
									<a class="fr__btn buy_now" href="javascript:void(0)" onclick="manage_cart('<?php echo $get_product['0']['id']?>','add','yes')">Buy Now</a>
								
								</div>
								
								
                            </div>
							
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Product Details Top -->
        </section>
		<input type="hidden" id="cid"/>
		<input type="hidden" id="sid"/>
		
        <!-- End Product Details Area 
		<!-- Start Product Description -->
        <section class="htc__produc__decription bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <!-- Start List And Grid View -->
                        <ul class="pro__details__tab" role="tablist">
                            <li role="presentation" class="description active"><a href="#description" role="tab" data-toggle="tab">Product details</a></li>
							<li role="presentation" class="description active"><a href="#description" role="tab" data-toggle="tab">Paper Stocks</a></li>
							<li role="presentation" class="description active"><a href="#description" role="tab" data-toggle="tab">File Setup</a></li>
							<li role="presentation" class="description active"><a href="#description" role="tab" data-toggle="tab">Template</a></li>
							<li role="presentation" class="review"><a href="#review" role="tab" data-toggle="tab" class="active show" aria-selected="true">review</a></li>
                        </ul>
                        <!-- End List And Grid View -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="ht__pro__details__content">
                            <!-- Start Single Content -->
                            <div role="tabpanel" id="description" class="pro__single__content tab-pane fade in active">
                                <div class="pro__tab__content__inner">
                                    <?php echo $get_product['0']['description']?>
                                </div>
                            </div>
							<!-- <style>
    .ht__pro__details__content {
        border: 1px solid #fff; /* Add border */
        /* border-radius: 7px; Add border radius */
        padding: 20px; /* Add padding for spacing */
        margin-top: 20px; /* Add margin to separate from content above */
		background: #fff;
    border-bottom-left-radius: 20px;
    border-bottom-right-radius: 20px;
    }
</style> -->

                            <!-- End Single Content -->
                            
							<div role="tabpanel" id="review" class="pro__single__content tab-pane fade active show">
                                <div class="pro__tab__content__inner">
                                    <?php 
									if(mysqli_num_rows($product_review_res)>0){
									
									while($product_review_row=mysqli_fetch_assoc($product_review_res)){
									?>
									
									<article class="row">
										<div class="col-md-12 col-sm-12">
										  <div class="panel panel-default arrow left">
											<div class="panel-body">
											  <header class="text-left">
												<div><span class="comment-rating"> <?php echo $product_review_row['rating']?></span> (<?php echo $product_review_row['name']?>)</div>
												<time class="comment-date"> 
<?php
$added_on=strtotime($product_review_row['added_on']);
echo date('d M Y',$added_on);
?>
												
												
												
												</time>
											  </header>
											  <div class="comment-post">
												<p>
												  <?php echo $product_review_row['review']?>
												</p>
											  </div>
											</div>
										  </div>
										</div>
									</article>
									<?php } }else { 
										echo "<h3 class='submit_review_hint'>No review added</h3><br/>";
									}
									?>
									
									
                                    <h3 class="review_heading">Enter your review</h3><br/>
									<?php
									if(isset($_SESSION['USER_LOGIN'])){
									?>
									<div class="row" id="post-review-box" style=>
									   <div class="col-md-12">
										  <form action="" method="post">
											 <select class="form-control" name="rating" required>
												  <option value="">Select Rating</option>
												  <option>Worst</option>
												  <option>Bad</option>
												  <option>Good</option>
												  <option>Very Good</option>
												  <option>Fantastic</option>
											 </select>	<br/>
											 <textarea class="form-control" cols="50" id="new-review" name="review" placeholder="Enter your review here..." rows="5"></textarea>
											 <div class="text-right mt10">
												<button class="btn btn-success btn-lg" type="submit" name="review_submit">Submit</button>
											 </div>
										  </form>
									   </div>
									</div>
									<?php } else {
										echo "<span class='submit_review_hint'>Please <a href='login.php'>login</a> to submit your review</span>";
									}
									?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
		<!-- <style> -->
    <!-- /* Style for tabs */ -->
	<style>
/* General Styles */
.container {
    margin-top: 20px;
}
.bg__white {
    background-color: #fff;
}
/* Product Description Tab Styles */
.pro__details__tab {
    display: flex;
    list-style-type: none;
    padding: 0;
    justify-content: space-between;
}
.pro__details__tab li {
    flex: 1;
}
.pro__details__tab li a {
    display: block;
    text-align: center;
    text-decoration: none;
    color: #333;
    padding: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}
.pro__details__tab li a.active {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
}
/* Product Description Content Styles */
.ht__pro__details__content {
    border: 1px solid #fff;
    padding: 20px;
    margin-top: 20px;
    background: #fff;
    border-bottom-left-radius: 20px;
    border-bottom-right-radius: 20px;
}
.ht__pro__details__content .submit_review_hint {
    margin-top: 20px;
}
.ht__pro__details__content .review_heading {
    margin-top: 20px;
}
@media (max-width: 768px) {
    .pro__details__tab {
        flex-wrap: wrap;
    }
    .pro__details__tab li {
        flex: 0 0 100%; /* Take full width on smaller screens */
        margin-bottom: 10px; /* Add some space between tabs */
    }
}
</style>


<!-- </style> -->

        <!-- End Product Description -->
        
		<?php
		//unset($_COOKIE['recently_viewed']);
		if(isset($_COOKIE['recently_viewed'])){
			$arrRecentView=unserialize($_COOKIE['recently_viewed']);
			$countRecentView=count($arrRecentView);
			$countStartRecentView=$countRecentView-4;
			if($countStartRecentView>4){
				$arrRecentView=array_slice($arrRecentView,$countStartRecentView,4);
			}
			$recentViewId=implode(",",$arrRecentView);
			$res=mysqli_query($con,"select * from product where id IN ($recentViewId) and status=1");
			
		?>
		<section class="htc__produc__decription bg__white">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h3 class="recently-viewed-heading">Recently Viewed</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="ht__pro__details__content">
                    <div class="row">
                        <?php while($list=mysqli_fetch_assoc($res)){?>
                        <div class="col-xs-6 col-sm-3 recently-viewed-item">
                            <div class="category">
                                <div class="ht__cat__thumb">
                                    <a href="product.php?id=<?php echo $list['id']?>">
                                        <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$list['image']?>" alt="Product Image">
                                    </a>
                                </div>
                                <div class="fr__hover__info">
                                    <ul class="product__action">
                                        <li><a href="javascript:void(0)" onclick="wishlist_manage('<?php echo $list['id']?>','add')"><i class="icon-heart icons"></i></a></li>
                                        <li><a href="javascript:void(0)" onclick="manage_cart('<?php echo $list['id']?>','add')"><i class="icon-handbag icons"></i></a></li>
                                    </ul>
                                </div>
                                <div class="fr__product__inner">
                                    <h4 class="product-title"><a href="product.php?id=<?php echo $list['id']?>"><?php echo $list['name']?></a></h4>
                                    <ul class="pro__prize">
                                        <li class="old__prize"><del>$<?php echo number_format($list['mrp'], 2) ?></del></li>
                                        <li class="new__price">$<?php echo number_format($list['price'], 2) ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

		<style>
			/* Recently Viewed Styles */
.recently-viewed-heading {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 20px;
}

.recently-viewed-item {
    margin-bottom: 20px; /* Add space between items */
}

.category {
    border: 1px solid #eee; /* Add border */
    border-radius: 5px; /* Add border radius */
    padding: 15px; /* Add padding */
    transition: all 0.3s ease; /* Add transition for hover effect */
}

.category:hover {
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add shadow on hover */
}

.product-title {
    font-size: 16px;
    margin-bottom: 10px;
}

.pro__prize {
    list-style: none;
    padding: 0;
    margin: 0;
}

.old__prize {
    font-size: 16px;
    color: #999; /* Add color for old price */
}

.new__price {
    font-size: 18px;
    font-weight: bold;
    color: #333; /* Add color for new price */
}

		</style>
		<?php 
			$arrRec=unserialize($_COOKIE['recently_viewed']);
			if(($key=array_search($product_id,$arrRec))!==false){
				unset($arrRec[$key]);
			}
			$arrRec[]=$product_id;
		}else{
			$arrRec[]=$product_id;
		}
		setcookie('recently_viewed',serialize($arrRec),time()+60*60*24*365);
		?>
		
			<script>
			function showMultipleImage(im){
				jQuery('#img-tab-1').html("<img src='"+im+"' data-origin='"+im+"'/>");
				jQuery('.imageZoom').imgZoom();
			}
			let is_color='<?php echo $is_color?>';
			let is_size='<?php echo $is_size?>';
			let pid='<?php echo $product_id?>';
			</script>			
<?php 
require('footer.php');
ob_flush();
?>        