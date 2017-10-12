<?php
declare(strict_types=1);

namespace Lcobucci\MyApi\Retrieval;

use Lcobucci\MyApi\Book;
use Lcobucci\MyApi\BookCollection;

final class FindBooksHandler
{
    /**
     * @var BookCollection
     */
    private $collection;

    public function __construct(BookCollection $collection)
    {
        $this->collection = $collection;
    }

    public function handle(FindBooks $query): array
    {
        return $this->collection->findAll($query->title, $query->author);
    }
}
