<?php

declare(strict_types=1);

namespace Depa\SuluBlockContentBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class SuluBlockContentExtension extends Extension implements PrependExtensionInterface
{
    use BlockMetadataLoaderTrait;

    public function load(array $configs, ContainerBuilder $container): void
    {
        if ($container->hasExtension('framework')) {
            $container->prependExtensionConfig('framework', [
                'translator' => [
                    'paths' => [__DIR__ . '/../../Resources/translations'],
                ],
            ]);
        }

        $metadata = $this->loadMetadataFromXml(__DIR__ . '/../../Resources/config/blocks');

        $container->setParameter('sulu_block_content.bundle_metadata', [
            'bundle'   => 'SuluBlockContentBundle',
            'package'  => 'depa-berlin/sulu-block-content',
            'blocks'   => $metadata['blocks'],
            'children' => $metadata['children'],
        ]);
    }

    public function prepend(ContainerBuilder $container): void
    {
        if ($container->hasExtension('twig')) {
            $container->prependExtensionConfig('twig', [
                'paths' => [
                    __DIR__ . '/../../Resources/views' => null,
                ],
            ]);
        }

        if ($container->hasExtension('sulu_admin')) {
            $container->prependExtensionConfig('sulu_admin', [
                'templates' => [
                    'block' => [
                        'directories' => [
                            'sulu_block_content' => __DIR__ . '/../../Resources/config/blocks',
                        ],
                    ],
                ],
            ]);
        }
    }
}
