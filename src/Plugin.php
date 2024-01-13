<?php

declare(strict_types=1);

namespace Tembra\Pest\Plugins\XArgs;

use Pest\Contracts\Plugins\HandlesArguments;
use Pest\Plugins\Concerns\HandleArguments;

/**
 * @internal
 */
final class Plugin implements HandlesArguments
{
    use HandleArguments;

    /**
     * Repository where arguments are stored.
     *
     * @var array<string, string>
     */
    private static array $xArgs = [];

    /**
     * @var string[]
     */
    private const DEFAULT_KEY_VALUE = ['', ''];

    /**
     * {@inheritDoc}
     */
    public function handleArguments(array $originals): array
    {
        $arguments = $originals;

        foreach ($originals as $argument) {
            if (str_starts_with($argument, '--x-')) {
                $this->addXArg($argument);

                $arguments = $this->popArgument($argument, $arguments);
            }
        }

        return $arguments;
    }

    /**
     * Get the value of given argument.
     *
     * @return string|null
     */
    public function getXArg(string $argument): mixed
    {
        if (! $this->hasXArg($argument)) {
            return null;
        }

        return self::$xArgs[strtolower($argument)];
    }

    /**
     * Check if an argument exists.
     */
    public function hasXArg(string $argument): bool
    {
        return array_key_exists(strtolower($argument), self::$xArgs);
    }

    /**
     * Add a new argument to the repository.
     */
    private function addXArg(string $argument): void
    {
        [$key, $value] = $this->getKeyValue($argument);

        if ($key !== '') {
            self::$xArgs[$key] = $value;
        }
    }

    /**
     * Get key/value from argument.
     *
     * @return string[]
     */
    private function getKeyValue(string $argument): array
    {
        [$key, $value] = explode('=', $argument, 2) + self::DEFAULT_KEY_VALUE;

        $key = strtolower(substr($key, 4));

        return [
            $key,
            $value,
        ];
    }
}
