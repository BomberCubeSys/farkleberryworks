<?php require('views/farkleberryHeader.php');
require(APP_NON_WEB_BASE_DIR.'includes/LoginState.php');
  isLoggedInGeneral();
  ?>
<div id="container" class="container">
    <div class="row">
        <div id="content" class="col-sm-12">
            <div class="row products-category">
                <?php foreach ($vm->products as $product) {

                // Get product data
                $listPrice = $product->listPrice;
                $discountPercent = $product->discountPercent;
                $description = $product->description;

                // Calculate unit price
                $discountAmount = round($listPrice * ($discountPercent / 100.0), 2);
                $unitPrice = $listPrice - $discountAmount;

                // Get first paragraph of description
                $descriptionWithTags = addTags($description);
                $i = strpos($descriptionWithTags, "</p>");
                $descriptionParagraph = substr($descriptionWithTags, 3, $i - 3);
                ?>
                    <div class="product-layout product-grid col-lg-3 col-mid-3 col-sm-4 col-xs-12">
                        <div class="product-thumb">
                            <div class="image">
                                <img src="content/images/<?php echo $product->productCode; ?>.jpg" alt="&nbsp;" title="" class="img-responsive"/>
                            </div>
                            <div>
                                <div class="caption">
                                    <h5><?php echo $product->name; ?></h5>
                                    <p><?php echo $descriptionParagraph; ?></p>
                                    <p class="price">$<?php echo $product->listPrice; ?></p>
                                </div>
                                <button class="btn btn-primary" type="submit" value="Add To Cart"><span>Add To Cart</span></button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php require('views/farkleberryFooter.php');
