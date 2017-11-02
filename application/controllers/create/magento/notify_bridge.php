<?php
require_once('app/Mage.php');
ini_set('display_errors', 1);
Mage::app('admin');

if(isset($_POST['postvar1'])){
    if($_POST['postvar1']=='key'){
        $m = 0;
        $fromDate = date('Y-m-d H:i:s', strtotime("2017-06-10"));
        $toDate = date('Y-m-d H:i:s', strtotime("2017-06-13"));

        /* Get the collection */
        $orders = Mage::getModel('sales/order')->getCollection()
            ->addFieldToFilter('status', array('eq' => Mage_Sales_Model_Order::STATE_COMPLETE))
            ->addAttributeToFilter('created_at', array('from'=>$fromDate, 'to'=>$toDate))
            ->addAttributeToSelect('*');

        $orderResult = [];
        foreach ($orders as $order){
            $orderInfo = $order->getData();
            $OrderId = $order->getIncrementId();
            //print_r($orderInfo);
            $orderId = $OrderId;
            $order = Mage::getModel('sales/order')->loadByIncrementId($orderId);
            $shippingAddress = $order->getShippingAddress()->getData();

            $orderArr = array('order_id'=>$OrderId,'total_item_count'=>$orderInfo['total_item_count'],'weight'=>$orderInfo['weight'],'base_grand_total'=>$orderInfo['base_grand_total'],'base_subtotal'=>$orderInfo['base_subtotal'],'status'=>$orderInfo['status'],'shipping_description'=>$orderInfo['shipping_description'],'store_id'=>$orderInfo['store_id']);
            $shipmentArr = array('region_id'=>$shippingAddress['region_id'],'customer_id'=>$shippingAddress['customer_id'],'fax'=>$shippingAddress['fax'],'region'=>$shippingAddress['region'],'postcode'=>$shippingAddress['postcode'],'lastname'=>$shippingAddress['lastname'],'street'=>$shippingAddress['street'],'email'=>$shippingAddress['email'],'telephone'=>$shippingAddress['telephone'],'city'=>$shippingAddress['city'],'country_id'=>$shippingAddress['country_id'],'firstname'=>$shippingAddress['firstname'],'prefix'=>$shippingAddress['prefix'],'middlename'=>$shippingAddress['middlename'],'company'=>$shippingAddress['company']);
            $res = array('order'=>$orderArr,'shipping'=>$shipmentArr);
            array_push($orderResult,$res);
        }
        echo json_encode($orderResult);
    }

}

?>
