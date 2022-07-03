<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\iterators\IterableIteratorAggregate;

/**
 * @immutable
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Equals extends AbstractOperation
{
    /**
     * @return Closure(iterable<mixed, mixed>): Closure(iterable<mixed, mixed>): Generator<int, bool, mixed, false|mixed>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param iterable<mixed, mixed> $other
             *
             * @return Closure(iterable<mixed, mixed>): Generator<int, bool, mixed, false|mixed>
             */
            static function (iterable $other): Closure {
                /**
                 * @param iterable<mixed, mixed> $iterable
                 *
                 * @return Generator<int, bool, mixed, false|mixed>
                 */
                return static function (iterable $iterable) use ($other): Generator {
                    $otherAggregate = new IterableIteratorAggregate($other);
                    $iteratorAggregate = new IterableIteratorAggregate($iterable);

                    $iterator = $iteratorAggregate->getIterator();
                    $other = $otherAggregate->getIterator();

                    while ($other->valid() && $iterator->valid()) {
                        $iterator->next();
                        $other->next();
                    }

                    if ($other->valid() !== $iterator->valid()) {
                        return yield false;
                    }

                    $containsCallback =
                        /**
                         * @param mixed $current
                         */
                        static fn (int $index, $current): bool => (new Contains())()($current)($otherAggregate)->current();

                    yield from (new Every())()($containsCallback)($iteratorAggregate);
                };
            };
    }
}
