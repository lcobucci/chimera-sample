<?php
declare(strict_types=1);

namespace Lcobucci\Persistence;

use function array_map;
use function array_values;
use function file_exists;
use function file_get_contents;
use function file_put_contents;
use function json_decode;
use function json_encode;
use function sha1;
use function sha1_file;

abstract class NaiveJsonRepository
{
    /**
     * @var string
     */
    private $filename;

    /**
     * @var array
     */
    protected $items = [];

    public function __construct(string $filename)
    {
        $this->filename = $filename;

        if (file_exists($filename)) {
            $this->items = $this->fromContent(file_get_contents($this->filename));
        }
    }

    public function __destruct()
    {
        $content = $this->toContent();

        if (!file_exists($this->filename) || sha1($content) !== sha1_file($this->filename)) {
            file_put_contents($this->filename, $content, LOCK_EX);
        }
    }

    private function fromContent(string $json): array
    {
        $items = [];

        foreach (json_decode($json, true) as $item) {
            $items[$item['id']] = $this->convertItemToObject($item);
        }

        return $items;
    }

    abstract protected function convertItemToObject(array $item);

    private function toContent(): string
    {
        $data = array_map(
            [$this, 'convertObjectToItem'],
            $this->findAll()
        );

        return json_encode($data);
    }

    abstract protected function convertObjectToItem($object): array;

    public function findAll(): array
    {
        return array_values($this->items);
    }
}
