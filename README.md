# Pest X-Args Plugin

This repository contains the Pest X-Args Plugin.

This plugin add to Pest the functionality to accept `--x-` arguments and access them from the test cases.

> If you want to start testing your application with Pest, visit the main **[Pest Repository](https://github.com/pestphp/pest)**.

## Installation

Install the plugin with **[Composer »](https://getcomposer.org)**.

```bash
composer require tembra/pest-plugin-x-args --dev
```

## Versioning

This plugin is using **[Semantic Versioning »](https://semver.org/)**

- Major versions will always be the same as Pest
    - v2.x works with Pest v2.x

## Usage

Run Pest with any `--x-` argument you want to be available to test cases.

```bash
vendor/bin/pest --x-username=random --x-password=secret
```

If using a Composer script don't forget to use `--`, the special argument operator, after script name.

```bash
composer test-script-name -- --x-username=random --x-password=secret
```

In you test cases use the `hasXArg()` and `getXArg()` functions.

```php
use function Tembra\Pest\Plugins\XArgs\{hasXArg};
use function Tembra\Pest\Plugins\XArgs\{getXArg};

it('has --x-username and --x-password argument', function () {
    $hasUsername = hasXArg('username');
    $hasPassword = hasXArg('password');

    expect($hasUsername)->toBe(true)
        ->and($hasPassword)->toBe(true);
});

it('can login with valid credentials', function () {
    $username = getXArg('username');
    $password = getXArg('password');

    if (null === $username || null === $password) {
        $this->fail('You need to send valid username/password through command line.');
    }

    // try to login with $username and $password
    // and make expectations and/or assertions with result
});
```

## About arguments

The arguments are firstly processed by Pest through `Symfony\Component\Console\Input\Input` and then sent to this and others plugins. So everything that works there should work here.

Right away this plugin identifies the `--x-` argument and then the first equal sign (`=`) to break the argument in two parts. Then it removes the `--x-` from the first part.

Some statements:
- Arguments have a `key` and a `value`.
- In argument `--x-test=true` the key is `test` and the value is `true`.
- Both `key` and `value` are always of type `string`.
- Arguments may have only a `key` like `--x-active`. When this is the case the `value` is an empty string.
- Arguments `key` are case insensitive.
- Arguments `key` can not have an equal sign (`=`).
- Arguments `key` may use special chars if properly escaped, except the equal sign (`=`).
- Arguments with the same `key` overwrites each other. The last remains.
- Arguments without a `key` are not made available (e.g. `--x-=value`).
- Arguments `value` may be between quotes (e.g. `--x-key="complex value"`).
- Arguments `value` may use special chars if properly escaped.
- Unavailable arguments return `false` on `hasXArg()` and `null` on `getXArg()` calls.

To check some crazy usages you may look at `tests/PluginTest.php` and even run it with Pest 🚀.

## Motivation

Necessity to access specific and sensitive values (like a password) on test cases without the use of environment variables or files at all to do not take the risk to commit them to a local or remote code repository, even knowing that we could add these files to `.gitignore`.

## Contributing

Have any questions, found bugs or want to discuss/implement new functionalities? Do not hesitate to post an Issue and/or make a Pull Request if you can.

## More Pest

- Explore Pest docs at **[pestphp.com »](https://pestphp.com)**
- Follow Pest on Twitter at **[@pestphp »](https://twitter.com/pestphp)**
- Join Pest community at **[discord.gg/kaHY6p54JH »](https://discord.gg/kaHY6p54JH)** or **[t.me/+kYH5G4d5MV83ODk0 »](https://t.me/+kYH5G4d5MV83ODk0)**

Pest is an open-sourced software licensed under the **[MIT license](https://opensource.org/licenses/MIT)**.
