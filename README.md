CnertaBreadcrumbBundle
======================

The CnertaBreadcrumbBundle provide an easy way to create a breadcrumb with [KnpMenuBundle](https://github.com/KnpLabs/KnpMenuBundle) for Symfony2

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/74030a1e-6b96-4eb0-b34e-cad8cf6b640c/big.png)](https://insight.sensiolabs.com/projects/74030a1e-6b96-4eb0-b34e-cad8cf6b640c)

[![Build Status](https://travis-ci.org/AgrosupDijon-Eduter/BreadcrumbBundle.png)](https://travis-ci.org/AgrosupDijon-Eduter/BreadcrumbBundle)
[![Latest Stable Version](https://poser.pugx.org/cnerta/breadcrumb-bundle/v/stable.png)](https://packagist.org/packages/cnerta/breadcrumb-bundle)
[![Latest Unstable Version](https://poser.pugx.org/cnerta/breadcrumb-bundle/v/unstable.png)](https://packagist.org/packages/cnerta/breadcrumb-bundle)

Install the Bundle
------------------

1. Add the sources in your composer.json

```json
     "require": {
        // ...
        "cnerta/breadcrumb-bundle": "1.0.*"
    }
```

2. Then add it to your AppKernel class::

```php
    // in AppKernel::registerBundles()
    $bundles = array(
        // ...
        new Cnerta\BreadcrumbBundle\CnertaBreadcrumbBundle(),
        // ...
    );
```

Default configuration
---------------------
You don't have to configure anything. This part is only usefull if you want to setup a default breadcrumb template.

config.yml

```yaml

    cnerta_breadcrumb:
        twig:
            template: CnertaBreadcrumbBundle::cnerta_breadcrumb.html.twig
```

Rendering Breadcrumb
--------------------

First create your menu with the [KnpMenuBundle](https://github.com/KnpLabs/KnpMenuBundle/blob/master/Resources/doc/index.md#first-menu).

Next, in your twig template call : 
```jinja
    {{ cnerta_breadcrumb_render('MyWonderfullBundle:Builder:Menu') }}
```
Or if you just want to get the breadcrumb array and make your stuff : 
```jinja
    {% set currentItem = cnerta_breadcrumb_get('MyWonderfullBundle:Builder:Menu') %}
    {# some crasy stuff #}
    {% for item in currentItem %}
        {% if loop.index != 1 %}
            {% if loop.index > 1 %} &gt; {% endif %}
            {% if not loop.last %}<a href="{{ item.uri }}">{{ item.label }}</a>
            {% else %}<span>{{ item.label }}</span>{% endif %}
        {% endif %}
    {% endfor %}

```

If you want to use your own template for rendering  : 
```jinja
    {{ cnerta_breadcrumb_render('MyWonderfullBundle:Builder:Menu', {'template': 'MyWonderfullBundle:Breadcrumb:myBreadcrumb.html.twig'}) }}
```

Unit test the Bundle
--------------------
Before running phpunit you must load dependencies.
This will only load the required vendors needed for run test.
```bash
     composer install --dev
```

After that you can run phpunit.
```bash
      phpunit -c phpunit.xml.dist
```
