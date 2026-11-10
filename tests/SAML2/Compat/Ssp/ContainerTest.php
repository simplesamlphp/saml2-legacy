<?php

declare(strict_types=1);

namespace SAML2\Compat\Ssp;

use ReflectionClass;

/**
 * ContainerSingleton::getInstance() falls back to this container when none was set,
 * so it must implement every abstract method of AbstractContainer.
 */
class ContainerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @return void
     */
    public function testImplementsEveryAbstractMethod(): void
    {
        $this->assertTrue((new ReflectionClass(Container::class))->isInstantiable());
    }


    /**
     * The constructor needs SimpleSAMLphp's utility classes, which this library does not depend on.
     *
     * @return void
     */
    public function testInflateSizeLimitMatchesSimpleSamlphp(): void
    {
        $container = (new ReflectionClass(Container::class))->newInstanceWithoutConstructor();

        $this->assertSame(100 * 1024, $container->getInflateSizeLimit());
    }
}
