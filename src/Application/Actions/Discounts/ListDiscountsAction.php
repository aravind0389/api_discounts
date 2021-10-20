<?php
declare(strict_types=1);

namespace App\Application\Actions\Discounts;

use Psr\Http\Message\ResponseInterface as Response; 

class ListDiscountsAction extends DiscountsAction
{
    /**
     * {@inheritdoc}
    */
    protected function action(): Response {        

        $postData = $this->getFormData();     
        $this->logger->info("Request Data");
        $this->logger->info(json_encode($postData));   
        $responseData = $this->selectDiscount($postData);  
        $this->logger->info("Response Data");
        $this->logger->info(json_encode($responseData));      
        return $this->respondWithData($responseData);
    }

    /**
    * Function to select a discount
    */
    protected function selectDiscount($orderDetails) {

        //Total order value        
        $orderValue = $orderDetails->total;
        $this->logger->info("Select discount based on order value");

        //Query for product to get product categoryId
        $productDetails = $this->assignProductCategoryId($orderDetails);

        foreach($productDetails->items as $key => $values) {
            
            if($values->category == 2 && $values->quantity >= 5) {                    
                $discountsDetail = $this->computeDiscounts(2, $orderValue, $values);
                $values->discountType = $discountsDetail["discountType"];
                $values->discountQuantity = $discountsDetail["discountQuantity"];
                $values->quantity = $values->quantity +  $discountsDetail["discountQuantity"];
            } else if($values->category == 1 && $values->quantity >= 2) {                   
                $discountsDetail = $this->computeDiscounts(3, $orderValue, $productDetails);    
                $orderDetails = $discountsDetail["productDetails"];
                $orderValue = $orderDetails->total - $discountsDetail["discountPrice"]; 
            }
        }
        
        $discountPrice = 0;
        $discountType = ""; 
        $customerId = $orderDetails->{'customer-id'};                 
        $customerDetail = $this->discountsRepository->findCustomerById($customerId);
        $customerRevenue = (count($customerDetail) > 0) ? $customerDetail[0]['revenue'] : 0;   
        if($customerRevenue >= 1000) {
            $discountsDetail = $this->computeDiscounts(1, $orderValue, []);
            $discountPrice = $discountsDetail["discountPrice"];
            $discountType = $discountsDetail["discountType"]; 
        }
                    
        $responseData = $orderDetails;
        $responseData->discountPrice = $discountPrice;
        $responseData->discountType = $discountType; 
        $responseData->payableAmount = $orderValue - $discountPrice;            
        return $responseData;
        
    }

    /**
    * Function to compute discounts
    */
    protected function computeDiscounts($discountType, $orderValue, $productDetails) {

        //Compute discount based on discount type
        switch($discountType) {
            case 1:
                $this->logger->info("Discount Type1 Applied");
                $discountType = "Bought for over € 1000, gets a discount of 10% on the whole order";
                $discountPrice = $this->computePercentage($orderValue, 10);

                return array(
                    "discountType" => $discountType,
                    "discountPrice" => $discountPrice,
                    "discountQuantity" => 0
                );
            break;
            case 2:
                $this->logger->info("Discount Type2 Applied");
                $discountType = "For every product of category Switches, when you buy five, you get a sixth for free.";
                $discountQuantity = floor($productDetails->quantity/5);
                
                return array(
                    "discountType" => $discountType,
                    "discountPrice" => 0,
                    "discountQuantity" => $discountQuantity
                );
            break;
            case 3:
                $this->logger->info("Discount Type3 Applied");
                $discountType = "If you buy two or more products of category Tools, you get a 20% discount on the cheapest product.";                
                usort($productDetails->items, array($this, "compare"));
                $discountProduct = $productDetails->items[0];
                $discountProduct->discountPrice =  $this->computePercentage($discountProduct->total, 20);
                $discountProduct->discountType = $discountType;
                $discountProduct->total = $discountProduct->total - $discountProduct->discountPrice; 
                $productDetails->items[0] = $discountProduct;
                
                return array(
                    "discountType" => $discountType,
                    "discountPrice" => $discountProduct->discountPrice,
                    "discountQuantity" => 0, 
                    "productDetails" => $productDetails
                );
            break;
        }

        
    }

    /**
    * Function to compute discount percentage
    *  priceVal => Total price of the order
    * discountPercentage => Discount percentage to deduct from total price 
    */
    protected function computePercentage($orderValue, $discountPercentage) {      

        $percentInDecimal = $discountPercentage / 100;
        $percent = $percentInDecimal * $orderValue;
        return number_format((float)$percent, 2, '.', '');;
    }

    /**
    * Function to assign categoryid to products
    *  orderDetails => Array of objects with products in the order 
    */
    protected function assignProductCategoryId($orderDetails) {

        foreach($orderDetails->items as $key => $values) {
            $productId = $values->{'product-id'};
            $productDetails = $this->discountsRepository->findProductsById($productId);            
            $orderDetails->items[$key]->category = $productDetails[0]['category']; 
        }

       return $orderDetails;
    }

    /**
    * Function to compare and sort for cheapest product first in the order list
    *  orderDetails => Array of objects with products in the order 
    */
    protected function compare($a, $b) {
        return $a->total > $b->total;
    }

}