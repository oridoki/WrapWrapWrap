#Wrap Wrap Wrap

You are sick to create wrappers each time you are using core methods like ftp? 

With Wrap Wrap Wrap you can easily mock each annoying call to this core functions, giving you a clean interface to work with

##Installation

###Step 1: Download Wrap Wrap Wrap using composer

Add Wrap Wrap Wrap in your composer.json:

```json
{
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



