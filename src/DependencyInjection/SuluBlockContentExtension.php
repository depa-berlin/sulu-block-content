<?php

declare(strict_types=1);

namespace Depa\SuluBlockContentBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class SuluBlockContentExtension extends Extension implements PrependExtensionInterface
{
    private const BLOCKS = [
        'block--content-accordion', 'block--content-accordion-item',
        'block--content-account-address', 'block--content-action-button',
        'block--content-asset-container', 'block--content-box',
        'block--content-button', 'block--content-button-content',
        'block--content-button-grid', 'block--content-button-multiline',
        'block--content-col-headline', 'block--content-col-lead',
        'block--content-col-lead-html', 'block--content-faq',
        'block--content-form', 'block--content-headline',
        'block--content-html', 'block--content-html-template',
        'block--content-image', 'block--content-inline-svg',
        'block--content-lead', 'block--content-lead-html',
        'block--content-list', 'block--content-list-item',
        'block--content-snippet', 'block--content-text',
        'block--content-title', 'block--content-title-icon',
        'block--content-video',
    ];

    private const CHILDREN = [
        'block--content-accordion'      => ['block--content-accordion-item'],
        'block--content-faq'            => ['block--content-accordion-item'],
        'block--content-list'           => ['block--content-list-item'],
        'block--content-button-grid'    => ['block--content-button'],
        'block--content-button-content' => [
            'block--content-text', 'block--content-html', 'block--content-image',
        ],
        'block--content-box'            => [
            'block--content-text', 'block--content-html',
            'block--content-lead', 'block--content-lead-html',
            'block--content-image', 'block--content-inline-svg',
            'block--content-video', 'block--content-button',
            'block--content-button-content', 'block--content-button-multiline',
            'block--content-button-grid', 'block--content-col-lead',
            'block--content-col-lead-html', 'block--content-col-headline',
            'block--content-headline', 'block--content-title',
            'block--content-faq', 'block--content-accordion',
            'block--content-list', 'block--content-form',
        ],
        'block--content-form'           => [
            'block--content-text', 'block--content-html',
            'block--content-lead', 'block--content-lead-html',
            'block--content-image', 'block--content-button',
            'block--content-button-content', 'block--content-button-multiline',
            'block--content-button-grid', 'block--content-col-lead',
            'block--content-col-lead-html', 'block--content-headline',
            'block--content-title', 'block--content-list',
        ],
    ];

    public function load(array $configs, ContainerBuilder $container): void
    {
        if ($container->hasExtension('framework')) {
            $container->prependExtensionConfig('framework', [
                'translator' => [
                    'paths' => [__DIR__ . '/../../Resources/translations'],
                ],
            ]);
        }

        $container->setParameter('sulu_block_content.bundle_metadata', [
            'bundle'   => 'SuluBlockContentBundle',
            'package'  => 'depa-berlin/sulu-block-content',
            'blocks'   => self::BLOCKS,
            'children' => self::CHILDREN,
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
