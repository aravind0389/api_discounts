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
}
