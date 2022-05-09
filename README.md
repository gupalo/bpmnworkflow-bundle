BpmnWorkflow Bundle
===================

## Install

```bash
composer require gupalo/bpmnworkflow-bundle
```

Add to `config/bundles.php`
```php
Gupalo\BpmnWorkflowBundle\BpmnWorkflowBundle::class => ['all' => true]
```

Add to `config/packages/doctrine.yaml`
```yaml
mappings:
    BpmnWorkflowBundle:
        type: attribute
```

Add to config/routes/annotations.yaml

```yaml
bpmnWorkflow:
    resource: '@BpmnWorkflowBundle/Resources/config/routes.yaml'
```

Add to config/packages/twig.yaml

```yaml
twig:
    default_path: '%kernel.project_dir%/templates'
    form_themes:
        - bootstrap_4_layout.html.twig
        - '@BpmnWorkflow/_elements/bpmn_form_style.html.twig'
```


## Execute

```bash
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
php bin/console assets:install
```

## Test

For test in main app need install require-dev dependency

```bash
composer require symfony/phpunit-bridge --dev
composer require phpunit/phpunit --dev
composer require nelmio/alice --dev
```

Add to composer.json autoload-dev section

```json
"autoload-dev": {
    "psr-4": {
        "App\\Tests\\": "tests/",
        "Gupalo\\BpmnWorkflowBundle\\Tests\\": "vendor/gupalo/bpmnworkflow-bundle/tests/"
    }
}
```

Execute

```bash
composer dump-autoload
php vendor/bin/phpunit vendor/gupalo/bpmnworkflow-bundle
```
