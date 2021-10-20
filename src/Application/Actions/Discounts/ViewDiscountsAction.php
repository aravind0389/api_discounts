<?php
declare(strict_types=1);

namespace App\Application\Actions\Discounts;

use Psr\Http\Message\ResponseInterface as Response;

class ViewDiscountsAction extends DiscountsAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $discountId = (int) $this->resolveArg('id');
        $discounts = $this->discountsRepository->findDiscountsOfId($discountId);

        $this->logger->info("User of id `${discountId}` was viewed.");

        return $this->respondWithData($discounts);
    }
}
