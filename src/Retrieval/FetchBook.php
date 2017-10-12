<?php
declare(strict_types=1);

namespace Lcobucci\MyApi\Retrieval;

use Lcobucci\Chimera\ReadModelConverter\Query;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class FetchBook implements Query
{
    /**
     * @var UuidInterface
     */
    public $id;

    private function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    public static function fromRequest(ServerRequestInterface $request): self
    {
        return new self(Uuid::fromString($request->getAttribute('id')));
    }

    public function conversionCallback(): callable
    {
        return [BookDto::class, 'fromEntity'];
    }
}
