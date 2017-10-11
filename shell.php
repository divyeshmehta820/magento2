<?php 

echo 1111;die;
use Magento\Framework\App\Bootstrap;
 
require __DIR__ . '/app/bootstrap.php';
 
$params = $_SERVER;
 
$bootstrap = Bootstrap::create(BP, $params);
 
$obj = $bootstrap->getObjectManager();
 
$state = $obj->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');
 
$quoteId = 1;
$quote = $obj->get('Magento\Checkout\Model\Session')
             ->getQuote()
             ->load($quoteId);
 
echo '<pre>';
print_r($quote->getOrigData());
echo '</pre>';
 
$productId = 1;
$product = $obj->get('Magento\Catalog\Model\ProductRepository')
               ->getById($productId);
 
echo '<pre>';
print_r($product->getData());
echo '</pre>';

echo 11111;die;
$objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // instance of object manager
$product = $objectManager->create('\Magento\Catalog\Model\Product');
$product->setSku('my-sku'); // Set your sku here
$product->setName('Sample Simple Product'); // Name of Product
$product->setAttributeSetId(4); // Attribute set id
$product->setStatus(1); // Status on product enabled/ disabled 1/0
$product->setWeight(10); // weight of product
$product->setVisibility(4); // visibilty of product (catalog / search / catalog, search / Not visible individually)
$product->setTaxClassId(0); // Tax class id
$product->setTypeId('simple'); // type of product (simple/virtual/downloadable/configurable)
$product->setPrice(100); // price of product
$product->setStockData(
                        array(
                            'use_config_manage_stock' => 0,
                            'manage_stock' => 1,
                            'is_in_stock' => 1,
                            'qty' => 999999999
                        )
                    );
$product->save();

echo "====================================================";
// Adding Image to product
$imagePath = "sample.jpg"; // path of the image
$product->addImageToMediaGallery($imagePath, array('image', 'small_image', 'thumbnail'), false, false);
$product->save();

echo "==================================================";

// Adding Custom option to product
$options = array(
                array(
                    "sort_order"    => 1,
                    "title"         => "Custom Option 1",
                    "price_type"    => "fixed",
                    "price"         => "10",
                    "type"          => "field",
                    "is_require"   => 0
                ),
                array(
                    "sort_order"    => 2,
                    "title"         => "Custom Option 2",
                    "price_type"    => "fixed",
                    "price"         => "20",
                    "type"          => "field",
                    "is_require"   => 0
                )
            );
foreach ($options as $arrayOption) {
    $product->setHasOptions(1);
    $product->getResource()->save($product);
    $option = $objectManager->create('\Magento\Catalog\Model\Product\Option')
                    ->setProductId($product->getId())
                    ->setStoreId($product->getStoreId())
                    ->addData($arrayOption);
    $option->save();
    $product->addOption($option);

echo "================================================";


echo "How to assign associated products";


$productId = 12; // Configurable Product Id
$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
$product = $objectManager->create('Magento\Catalog\Model\Product')->load($productId); // Load Configurable Product
$attributeModel = $objectManager->create('Magento\ConfigurableProduct\Model\Product\Type\Configurable\Attribute');
$position = 0;
$attributes = array(134, 135); // Super Attribute Ids Used To Create Configurable Product
$associatedProductIds = array(2,4,5,6); //Product Ids Of Associated Products
foreach ($attributes as $attributeId) {
    $data = array('attribute_id' => $attributeId, 'product_id' => $productId, 'position' => $position);
    $position++;
    $attributeModel->setData($data)->save();
}
$product->setTypeId("configurable"); // Setting Product Type As Configurable
$product->setAffectConfigurableProductAttributes(4);
$objectManager->create('Magento\ConfigurableProduct\Model\Product\Type\Configurable')->setUsedProductAttributeIds($attributes, $product);
$product->setNewVariationsAttributeSetId(4); // Setting Attribute Set Id
$product->setAssociatedProductIds($associatedProductIds);// Setting Associated Products
$product->setCanSaveConfigurableAttributes(true);
$product->save();

?>