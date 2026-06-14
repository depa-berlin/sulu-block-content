# sulu-block-content

Content block collection for Sulu CMS — 29 configurable content blocks including text, images, buttons, accordions, lists, and more.

## Included Blocks

| Block | Description |
|---|---|
| `block--content-accordion` | Collapsible accordion container |
| `block--content-accordion-item` | Accordion item (child of accordion/faq) |
| `block--content-box` | Flexible content container with multiple sub-blocks |
| `block--content-button` | Single CTA button |
| `block--content-button-grid` | Grid of buttons |
| `block--content-button-content` | Button with rich content |
| `block--content-button-multiline` | Multiline button variant |
| `block--content-col-headline` | Column headline |
| `block--content-col-lead` | Column lead text |
| `block--content-col-lead-html` | Column lead text (HTML) |
| `block--content-faq` | FAQ block (uses accordion-item children) |
| `block--content-form` | Sulu form integration block |
| `block--content-headline` | Standalone headline |
| `block--content-html` | Raw HTML block |
| `block--content-html-template` | HTML with variable substitution |
| `block--content-image` | Image with ARIA and loading config |
| `block--content-inline-svg` | Inline SVG block |
| `block--content-lead` | Lead paragraph |
| `block--content-lead-html` | Lead paragraph (HTML) |
| `block--content-list` | List container |
| `block--content-list-item` | List item |
| `block--content-snippet` | Sulu snippet integration |
| `block--content-text` | Rich text block |
| `block--content-title` | Page title block |
| `block--content-title-icon` | Title with icon |
| `block--content-video` | Video embed block |
| `block--content-account-address` | Organisation address block |
| `block--content-action-button` | Action/trigger button |
| `block--content-asset-container` | Asset download container |

## Requirements

- PHP 8.2+
- Symfony 7.0+
- Sulu CMS 3.0+
- `depa-berlin/sulu-block-helper`

## Installation

```bash
composer require depa-berlin/sulu-block-content
```

Register in `config/bundles.php`:

```php
Depa\SuluBlockHelperBundle\SuluBlockHelperBundle::class => ['all' => true],
Depa\SuluBlockContentBundle\SuluBlockContentBundle::class => ['all' => true],
```

## License

Proprietary — Copyright (c) depa Berlin GmbH & Co. KG. All rights reserved.
See [LICENSE](LICENSE) for details.
