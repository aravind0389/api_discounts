<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Discounts;

use App\Domain\Discounts\Discounts;
use App\Domain\Discounts\DiscountsNotFoundException;
use App\Domain\Discounts\DiscountsRepository;
use PDO;

class InMemoryDiscountsRepository implements DiscountsRepository
{

    private $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function findProductsById($productId): array
    {

        $sql = "SELECT * FROM products WHERE productId = '".$productId."'";
        $query = $this->connection->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_ASSOC);

        return array_values($result);
    }

    public function findCustomerById($customerId): array
    {

        $sql = "SELECT * FROM customers WHERE id = ".$customerId;        
        $query = $this->connection->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_ASSOC);

        return array_values($result);
    }
}
