<?php

declare(strict_types=1);

namespace Depa\SuluBlockContentBundle\Tests\Unit;

use Depa\SuluBlockContentBundle\SuluBlockContentBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

class SuluBlockContentBundleTest extends TestCase
{
    private ContainerBuilder $container;
    private SuluBlockContentBundle $bundle;

    protected function setUp(): void
    {
        $this->container = new ContainerBuilder();
        // AbstractBundle's internal BundleExtension needs these to build the
        // ContainerConfigurator passed to prependExtension()/loadExtension().
        $this->container->setParameter('kernel.environment', 'test');
        $this->container->setParameter('kernel.build_dir', sys_get_temp_dir());
        $this->bundle = new SuluBlockContentBundle();
    }

    private function load(): void
    {
        $extension = $this->bundle->getContainerExtension();
        self::assertInstanceOf(ExtensionInterface::class, $extension);
        $extension->load([], $this->container);
    }

    public function testLoadSetsBundleMetadataParameter(): void
    {
        $this->load();
        self::assertTrue($this->container->hasParameter('sulu_block_content.bundle_metadata'));
    }

    public function testBundleMetadataHasRequiredKeys(): void
    {
        $this->load();
        $meta = $this->container->getParameter('sulu_block_content.bundle_metadata');
        self::assertIsArray($meta);
        self::assertArrayHasKey('bundle', $meta);
        self::assertArrayHasKey('package', $meta);
        self::assertArrayHasKey('blocks', $meta);
        self::assertArrayHasKey('children', $meta);
    }

    public function testBundleMetadataContainsCorrectBundleName(): void
    {
        $this->load();
        $meta = $this->container->getParameter('sulu_block_content.bundle_metadata');
        self::assertIsArray($meta);
        self::assertSame('SuluBlockContentBundle', $meta['bundle']);
    }

    public function testBundleMetadataContainsCorrectPackageName(): void
    {
        $this->load();
        $meta = $this->container->getParameter('sulu_block_content.bundle_metadata');
        self::assertIsArray($meta);
        self::assertSame('depa/sulu-block-content', $meta['package']);
    }

    public function testBundleMetadataContainsAtLeastOneBlock(): void
    {
        $this->load();
        $meta = $this->container->getParameter('sulu_block_content.bundle_metadata');
        self::assertIsArray($meta);
        self::assertNotEmpty($meta['blocks']);
    }

    public function testBlocksAreSortedAndUnique(): void
    {
        $this->load();
        $meta = $this->container->getParameter('sulu_block_content.bundle_metadata');
        self::assertIsArray($meta);
        $blocks = $meta['blocks'];
        $sorted = $blocks;
        sort($sorted);
        self::assertSame($sorted, $blocks, 'blocks must be sorted');
        self::assertSame(array_unique($blocks), $blocks, 'blocks must be unique');
    }

    public function testKnownContentBlocksArePresent(): void
    {
        $this->load();
        $meta = $this->container->getParameter('sulu_block_content.bundle_metadata');
        self::assertIsArray($meta);

        foreach (['block--content-text', 'block--content-image', 'block--content-accordion'] as $expected) {
            self::assertContains($expected, $meta['blocks']);
        }
    }

    public function testAccordionHasChildrenFromXml(): void
    {
        $this->load();
        $meta = $this->container->getParameter('sulu_block_content.bundle_metadata');
        self::assertIsArray($meta);

        self::assertArrayHasKey('block--content-accordion', $meta['children']);
        self::assertContains('block--content-accordion-item', $meta['children']['block--content-accordion']);
    }

    public function testChildrenValuesAreArraysOfStrings(): void
    {
        $this->load();
        $meta = $this->container->getParameter('sulu_block_content.bundle_metadata');
        self::assertIsArray($meta);

        foreach ($meta['children'] as $parent => $kids) {
            self::assertIsArray($kids, "Children of '{$parent}' must be an array");
            foreach ($kids as $child) {
                self::assertIsString($child);
            }
        }
    }
}
