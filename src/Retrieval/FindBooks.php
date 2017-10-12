<?php
declare(strict_types=1);

namespace Lcobucci\MyApi\Retrieval;

use Lcobucci\Chimera\ReadModelConverter\Query;
use Psr\Http\Message\ServerRequestInterface;

final class FindBooks implements Query
{
    /**
     * @var string|null
     */
    public $title;

    /**
     * @var string|null
     */
    public $author;

    private function __construct(?string $title, ?string $author)
    {
        $this->author = $author;
        $this->title  = $title;
    }

    public static function fromRequest(ServerRequestInterface $request): self
    {
        return new self(
            $request->getQueryParams()['title'] ?? null,
            $request->getQueryParams()['author'] ?? null
        );
    }

    public function conversionCallback(): callable
    {
        return [BookDto::class, 'fromEntity'];
    }
}
