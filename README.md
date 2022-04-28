# README #

## Install

Add to bundle.php
```bash
Gupalo\BpmnWorkflowBundle\BpmnWorkflowBundle::class => ['all' => true]
```
Add to doctrine.yaml

```bash
mappings:
  BpmnWorkflowBundle:
    type: attribute
```

Execute

```bash
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```

Test

```bash
php bin/phpunit vendor/gupalo/bpmnworkflow-bundle 
```