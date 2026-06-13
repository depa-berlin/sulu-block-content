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

    public function testBundleMetadataContains29BlockTypes(): void
    {
        $this->extension->load([], $this->container);
        $meta = $this->container->getParameter('sulu_block_content.bundle_metadata');
        self::assertIsArray($meta);
        self::assertCount(29, $meta['blocks']);
    }

    public function testBundleMetadataContainsExpectedBlockTypes(): void
    {
        $this->extension->load([], $this->container);
        $meta = $this->container->getParameter('sulu_block_content.bundle_metadata');
        self::assertIsArray($meta);

        $expected = [
            'block--content-accordion',
            'block--content-text',
            'block--content-image',
            'block--content-button',
            'block--content-list',
        ];

        foreach ($expected as $blockType) {
            self::assertContains($blockType, $meta['blocks'], "Expected block type '{$blockType}' to be present");
        }
    }

    public function testAccordionHasAccordionItemAsChild(): void
    {
        $this->extension->load([], $this->container);
        $meta = $this->container->getParameter('sulu_block_content.bundle_metadata');
        self::assertIsArray($meta);

        self::assertArrayHasKey('block--content-accordion', $meta['children']);
        self::assertContains(
            'block--content-accordion-item',
            $meta['children']['block--content-accordion']
        );
    }

    public function testFaqHasAccordionItemAsChild(): void
    {
        $this->extension->load([], $this->container);
        $meta = $this->container->getParameter('sulu_block_content.bundle_metadata');
        self::assertIsArray($meta);

        self::assertArrayHasKey('block--content-faq', $meta['children']);
        self::assertContains(
            'block--content-accordion-item',
            $meta['children']['block--content-faq']
        );
    }

    public function testListHasListItemAsChild(): void
    {
        $this->extension->load([], $this->container);
        $meta = $this->container->getParameter('sulu_block_content.bundle_metadata');
        self::assertIsArray($meta);

        self::assertArrayHasKey('block--content-list', $meta['children']);
        self::assertContains(
            'block--content-list-item',
            $meta['children']['block--content-list']
        );
    }

    public function testButtonGridHasButtonAsChild(): void
    {
        $this->extension->load([], $this->container);
        $meta = $this->container->getParameter('sulu_block_content.bundle_metadata');
        self::assertIsArray($meta);

        self::assertArrayHasKey('block--content-button-grid', $meta['children']);
        self::assertContains(
            'block--content-button',
            $meta['children']['block--content-button-grid']
        );
    }

    public function testBoxContainsMultipleChildTypes(): void
    {
        $this->extension->load([], $this->container);
        $meta = $this->container->getParameter('sulu_block_content.bundle_metadata');
        self::assertIsArray($meta);

        self::assertArrayHasKey('block--content-box', $meta['children']);
        self::assertGreaterThan(10, \count($meta['children']['block--content-box']));
    }

    public function testChildrenValuesAreArraysOfStrings(): void
    {
        $this->extension->load([], $this->container);
        $meta = $this->container->getParameter('sulu_block_content.bundle_metadata');
        self::assertIsArray($meta);

        foreach ($meta['children'] as $parent => $children) {
            self::assertIsArray($children, "Children of '{$parent}' must be an array");
            foreach ($children as $child) {
                self::assertIsString($child);
            }
        }
    }
}
