<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Compactable
{
    /**
     * Combine a collection of items with some other keys.
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function compact(): Base;
}
