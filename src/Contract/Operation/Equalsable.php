<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Equalsable
{
    /**
     * Check if the collection equals another collection..
     *
     * @param Collection<TKey, T> $other
     */
    public function equals(Collection $other): bool;
}