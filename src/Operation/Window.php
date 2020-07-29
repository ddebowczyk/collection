<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;
use loophp\collection\Transformation\Run;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
final class Window extends AbstractOperation implements Operation
{
    public function __construct(int ...$length)
    {
        $this->storage['length'] = $length;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             * @psalm-param list<int> $length
             *
             * @psalm-return \Generator<int, list<T>>
             */
            static function (Iterator $iterator, array $length): Generator {
                $length = new IterableIterator((new Run(new Loop()))($length));

                for ($i = 0; iterator_count($iterator) > $i; ++$i) {
                    yield iterator_to_array((new Run(new Slice($i, $length->current())))($iterator));
                    $length->next();
                }
            };
    }
}
