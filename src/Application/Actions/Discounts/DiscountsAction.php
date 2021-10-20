<?php
declare(strict_types=1);

namespace App\Application\Actions\Discounts;

use App\Application\Actions\Action;
use App\Domain\Discounts\DiscountsRepository;
use Psr\Log\LoggerInterface;

abstract class DiscountsAction extends Action
{
    /**
     * @var DiscountsRepository
     */
    protected $discountsRepository;

    /**
     * @param LoggerInterface $logger
     * @param DiscountsRepository $userRepository
     */
    public function __construct(LoggerInterface $logger,
                                DiscountsRepository $discountsRepository
    ) {
        parent::__construct($logger);    
        $this->discountsRepository = $discountsRepository;    
    }

    /**
     * Function to validate the order request  
    */
    public function validateRequest($request) {
        
        if($request->{'customer-id'}) {
            if($request->{'customer-id'} != "" && $request->items != 0 && count($request->items) > 0) {
                $result = true;
            } else {
                $result = false;
            }
        } else {
            $result = false;
        }

        return $result;
    }
}
