<?php
declare(strict_types=1);

namespace App\Domain\Discounts;

interface DiscountsRepository
{
    /**
     * @return Products[]
    */
    public function findProductsById($productId): array;

    /**
     * @return CustomerDetail[]
    */
    public function findCustomerById($customerId): array;

    /**
     * @param int $id
     * @return Discounts
     * @throws DiscountsNotFoundException
     */
    // public function findUserOfId(int $id): User;
}
