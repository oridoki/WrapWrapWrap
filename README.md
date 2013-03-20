#Wrap Wrap Wrap

You are sick to create wrappers each time you are using core methods like ftp? 

With Wrap Wrap Wrap you can easily mock each annoying call to this core functions, giving you a clean interface to work with

##Installation

###Step 1: Download Wrap Wrap Wrap using composer

Add Wrap Wrap Wrap in your composer.json:

```json
{
    "repositories": [{
        "type": "package",
        "package": {
            "name": "Oridoki/WrapWrapWrap",
            "version": "master",
            "source": {
                "url": "git@github.com:oridoki/WrapWrapWrap.git",
                "type": "git",
                "reference": "master"
            }
        }
    }],
    "require": {
        "Oridoki/WrapWrapWrap": "*"
    }
}
```

Now tell composer to download the bundle by running the command:

```bash
$ php composer.phar update Oridoki/WrapWrapWrap
```

Composer will install the bundle to your project's `vendor/Oridoki` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Oridoki\WrapWrapWrapBundle(),
    );
}
```


##License

This bundle is under the MIT license. See the complete license in the bundle:

    LICENSE


##About

UserBundle is a [oridoki](https://github.com/oridoki) initiative.


##Reporting an issue or a feature request

Issues and feature requests are tracked in the [Github issue tracker](https://github.com/adriacidre/WrapWrapWrap/issues).

When reporting a bug, it may be a good idea to reproduce it in a basic project built using the [Symfony Standard Edition](https://github.com/symfony/symfony-standard) to allow developers of the bundle to reproduce the issue by simply cloning it and following some steps.


