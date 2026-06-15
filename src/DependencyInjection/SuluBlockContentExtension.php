<?php

declare(strict_types=1);

namespace Depa\SuluBlockContentBundle\DependencyInjection;

use Depa\SuluBlockHelperBundle\DependencyInjection\AbstractBlockExtension;

class SuluBlockContentExtension extends AbstractBlockExtension
{
    protected function getBundleName(): string
    {
        return 'SuluBlockContentBundle';
    }

    protected function getPackageName(): string
    {
        return 'depa/sulu-block-content';
    }

    protected function getMetadataParameterName(): string
    {
        return 'sulu_block_content.bundle_metadata';
    }

    protected function getSuluAdminTemplateKey(): string
    {
        return 'sulu_block_content';
    }
}
