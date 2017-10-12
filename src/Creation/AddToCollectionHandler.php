<?php
declare(strict_types=1);

namespace Lcobucci\MyApi\Creation;

use Lcobucci\MyApi\Book;
use Lcobucci\MyApi\BookCollection;

final class AddToCollectionHandler
{
    /**
     * @var BookCollection
     */
    private $collection;

    public function __construct(BookCollection $collection)
    {
        $this->collection = $collection;
    }

    public function handle(AddToCollection $command): void
    {
        $book = new Book(
            $command->id,
            $command->title,
            $command->author
        );

        $this->collection->append($book);
    }
}
