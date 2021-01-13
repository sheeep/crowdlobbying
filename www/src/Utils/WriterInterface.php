<?php

declare(strict_types=1);

namespace App\Utils;

use App\Entity\Campaign;

interface WriterInterface
{
    public function write(Campaign $campaign): ?string;
}
