<?php

declare(strict_types=1);

namespace Depa\SuluBlockContentBundle\Tests\Unit\DependencyInjection;

use Depa\SuluBlockContentBundle\DependencyInjection\SuluBlockContentExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SuluBlockContentExtensionTest extends TestCase
{
    private ContainerBuilder $container;
    private SuluBlockContentExtension $extension;

    protected function setUp(): void
    {
        $this->container = new ContainerBuilder();
        $this->extension = new SuluBlockContentExtension();
    }

    public function testLoadSetsBundleMetadataParameter(): void
    {
        $this->extension->load([], $this->container);
        self::assertTrue($this->container->hasParameter('sulu_block_content.bundle_metadata'));
    }

    public function testBundleMetadataHasRequiredKeys(): void
    {
        $this->extension->load([], $this->container);
        $meta = $this->container->getParameter('sulu_block_content.bundle_metadata');
        self::assertIsArray($meta);
        self::assertArrayHasKey('bundle', $meta);
        self::assertArrayHasKey('package', $meta);
        self::assertArrayHasKey('blocks', $meta);
        self::assertArrayHasKey('children', $meta);
    }

    public function testBundleMetadataContainsCorrectBundleName(): void
    {
        $this->extension->load([], $this->container);
        $meta = $this->container->getParameter('sulu_block_content.bundle_metadata');
        self::assertIsArray($meta);
        self::assertSame('SuluBlockContentBundle', $meta['bundle']);
    }

    public function testBundleMetadataContainsCorrectPackageName(): void
    {
        $this->extension->load([], $this->container);
        $meta = $this->container->getParameter('sulu_block_content.bundle_metadata');
        self::assertIsArray($meta);
        self::assertSame('depa-berlin/sulu-block-content', $meta['package']);
    }

    public function testBundleMetadataContainsAtLeastOneBlock(): void
    {
        $this->extension->load([], $this->container);
        $meta = $this->container->getParameter('sulu_block_content.bundle_metadata');
        self::assertIsArray($meta);
        self::assertNotEmpty($meta['blocks']);
    }

    public function testBlocksAreSortedAndUnique(): void
    {
        $this->extension->load([], $this->container);
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
        $this->extension->load([], $this->container);
        $meta = $this->container->getParameter('sulu_block_content.bundle_metadata');
        self::assertIsArray($meta);

        foreach (['block--content-text', 'block--content-image', 'block--content-accordion'] as $expected) {
            self::assertContains($expected, $meta['blocks']);
        }
    }

    public function testAccordionHasChildrenFromXml(): void
    {
        $this->extension->load([], $this->container);
        $meta = $this->container->getParameter('sulu_block_content.bundle_metadata');
        self::assertIsArray($meta);

        self::assertArrayHasKey('block--content-accordion', $meta['children']);
        self::assertContains('block--content-accordion-item', $meta['children']['block--content-accordion']);
    }

    public function testChildrenValuesAreArraysOfStrings(): void
    {
        $this->extension->load([], $this->container);
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
