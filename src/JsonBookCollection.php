<?php
declare(strict_types=1);

namespace Lcobucci\MyApi;

use Lcobucci\Persistence\NaiveJsonRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use function array_filter;
use function array_values;

final class JsonBookCollection extends NaiveJsonRepository implements BookCollection
{
    public function append(Book $book): void
    {
        $this->items[(string) $book->getId()] = $book;
    }

    public function find(UuidInterface $id): Book
    {
        if (! isset($this->items[(string) $id])) {
            throw new \OutOfBoundsException('Book not found');
        }

        return $this->items[(string) $id];
    }

    public function findAll(?string $title = null, ?string $author = null): array
    {
        if ($title === null && $author === null) {
            return parent::findAll();
        }

        return array_values(
            array_filter(
                $this->items,
                function (Book $book) use ($title, $author) {
                    return ($title && mb_stripos($book->getTitle(), $title) !== false)
                        || ($author && mb_stripos($book->getAuthor(), $author) !== false);
                }
            )
        );
    }

    protected function convertItemToObject(array $item)
    {
        return new Book(
            Uuid::fromString($item['id']),
            $item['title'],
            $item['author']
        );
    }

    /**
     * @param Book $object
     */
    protected function convertObjectToItem($object): array
    {
        return [
            'id'     => (string) $object->getId(),
            'title'  => $object->getTitle(),
            'author' => $object->getAuthor(),
        ];
    }
}
