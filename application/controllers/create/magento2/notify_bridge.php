<?php
use Magento\Framework\App\Bootstrap;


if(isset($_POST['postvar1'])){
    if($_POST['postvar1']=='key') {
        require __DIR__ . '/app/bootstrap.php';

        $params = $_SERVER;

        $bootstrap = Bootstrap::create(BP, $params);

        $obj = $bootstrap->getObjectManager();

        $state = $obj->get('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
        $state2 = $obj->get('\Magento\Framework\App\State');


        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $orderDatamodel = $objectManager->get('Magento\Sales\Model\Order')->getCollection();
        //arra for  all orders
        //$resultInfo = [];
        //check every order
        $orderResult = [];
        foreach ($orderDatamodel as $orderDatamodel1) {
            $getid = $orderDatamodel1->getData("increment_id");
            $orderInfo = $orderDatamodel1->getData();
            $orderData = $objectManager->create('Magento\Sales\Model\Order')->loadByIncrementId($getid);
            $getorderdata = $orderData->getData();
            //check if order is complate
            $shippingAddress = $orderData->getShippingAddress()->getData();

            $orderArr = array('order_id' => $getid, 'status' => $orderInfo['status'], 'total_item_count' => $orderInfo['total_item_count'], 'weight' => $orderInfo['weight'], 'base_grand_total' => $orderInfo['base_grand_total'], 'base_subtotal' => $orderInfo['base_subtotal'], 'shipping_description' => $orderInfo['shipping_description'], 'store_id' => $orderInfo['store_id']);
            $shipmentArr = array('region_id' => $shippingAddress['region_id'], 'customer_id' => $shippingAddress['customer_id'], 'fax' => $shippingAddress['fax'], 'region' => $shippingAddress['region'], 'postcode' => $shippingAddress['postcode'], 'lastname' => $shippingAddress['lastname'], 'street' => $shippingAddress['street'], 'email' => $shippingAddress['email'], 'telephone' => $shippingAddress['telephone'], 'city' => $shippingAddress['city'], 'country_id' => $shippingAddress['country_id'], 'firstname' => $shippingAddress['firstname'], 'prefix' => $shippingAddress['prefix'], 'middlename' => $shippingAddress['middlename'], 'company' => $shippingAddress['company']);
            $res = array('order' => $orderArr, 'shipping' => $shipmentArr);
            array_push($orderResult, $res);

        }
        echo json_encode($orderResult);
    }
}
?>