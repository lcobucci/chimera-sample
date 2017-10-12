<?php
declare(strict_types=1);

namespace Lcobucci\MyApi\Creation;

use Lcobucci\Chimera\Routing\Attributes;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\UuidInterface;

final class AddToCollection
{
    /**
     * @var UuidInterface
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $author;

    private function __construct(UuidInterface $id, string $title, string $author)
    {
        $this->id     = $id;
        $this->title  = $title;
        $this->author = $author;
    }

    public static function fromRequest(ServerRequestInterface $request): self
    {
        $data = json_decode((string) $request->getBody(), true);

        if (json_last_error() !== JSON_ERROR_NONE || ! isset($data['title'], $data['author'])) {
            throw new \InvalidArgumentException('You must send a valid JSON object with "title" and "author"');
        }

        return new self(
            $request->getAttribute(Attributes::GENERATED_ID),
            $data['title'],
            $data['author']
        );
    }
}
