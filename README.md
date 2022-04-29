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

## Execute

```bash
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```

Test

```bash
php bin/phpunit vendor/gupalo/bpmnworkflow-bundle
```
