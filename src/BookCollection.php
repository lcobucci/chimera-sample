<?php
declare(strict_types=1);

namespace Lcobucci\MyApi;

use Ramsey\Uuid\UuidInterface;

interface BookCollection
{
    public function append(Book $book): void;

    /**
     * @throws \OutOfBoundsException
     */
    public function find(UuidInterface $id): Book;

    /**
     * @return Book[]
     */
    public function findAll(?string $title = null, ?string $author = null): array;
}
