<?php
declare(strict_types=1);

namespace Lcobucci\MyApi\Retrieval;

use Lcobucci\MyApi\Book;
use Lcobucci\MyApi\BookCollection;

final class FetchBookHandler
{
    /**
     * @var BookCollection
     */
    private $collection;

    public function __construct(BookCollection $collection)
    {
        $this->collection = $collection;
    }

    public function handle(FetchBook $query): Book
    {
        return $this->collection->find($query->id);
    }
}
