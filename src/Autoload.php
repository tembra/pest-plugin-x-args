<?php

declare(strict_types=1);

namespace Tembra\Pest\Plugins\XArgs;

use Pest\Support\Container;

/**
 * Get the value of given argument.
 *
 * @return string|null
 */
function getXArg(string $argument): mixed
{
    /** @var Plugin $plugin */
    $plugin = Container::getInstance()->get(Plugin::class);

    return $plugin->getXArg($argument);
}

/**
 * Check if an argument exists.
 */
function hasXArg(string $argument): bool
{
    /** @var Plugin $plugin */
    $plugin = Container::getInstance()->get(Plugin::class);

    return $plugin->hasXArg($argument);
}
