# Magento Module Creation Guide

A comprehensive guide for creating custom modules in Magento 2.

## Table of Contents
- [Prerequisites](#prerequisites)
- [Module Structure](#module-structure)
- [Step-by-Step Module Creation](#step-by-step-module-creation)
- [Essential Files](#essential-files)
- [Common Commands](#common-commands)
- [Best Practices](#best-practices)
- [Examples](#examples)

## Prerequisites

Before creating a Magento module, ensure you have:

- **Magento 2 Installation**: A working Magento 2 environment
- **PHP Knowledge**: Basic understanding of PHP and object-oriented programming
- **Composer**: Package manager for PHP dependencies
- **Command Line Access**: Terminal/Command prompt access to your Magento installation
- **Text Editor/IDE**: For writing code (VS Code, PhpStorm, etc.)

## Module Structure

A basic Magento 2 module follows this directory structure:

```
app/code/SimplifiedMagento/Base/
├── registration.php
├── etc/
│   ├── module.xml
│   ├── di.xml (optional)
│   └── frontend/routes.xml (if creating frontend routes)
├── Controller/
├── Model/
├── Block/
├── Helper/
├── Observer/
├── Plugin/
└── view/
    ├── frontend/
    │   ├── layout/
    │   ├── templates/
    │   └── web/
    └── adminhtml/
        ├── layout/
        ├── templates/
        └── web/
```

## Step-by-Step Module Creation

### Step 1: Create Module Directory

Navigate to your Magento root directory and create the module folder:

```bash
mkdir -p app/code/SimplifiedMagento/Base
cd app/code/SimplifiedMagento/Base
```

**Example:**
```bash
mkdir -p app/code/MyCompany/HelloWorld
cd app/code/MyCompany/HelloWorld
```

### Step 2: Create registration.php

Create `registration.php` in your module root:

```php
<?php
use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'SimplifiedMagento_Base',
    __DIR__
);
```

### Step 3: Create module.xml

Create the `etc` directory and add `module.xml`:

```bash
mkdir etc
```

Create `etc/module.xml`:

```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
        xsi:noNamespaceSchemaLocation="urn:magento:framework:Module/etc/module.xsd">
    <module name="VendorName_ModuleName" setup_version="1.0.0">
        <!-- Dependencies (if any) -->
        <sequence>
            <module name="Magento_Catalog"/>
        </sequence>
    </module>
</config>
```

### Step 4: Enable the Module

Run the following commands from your Magento root directory:

```bash
# Enable the module
php bin/magento module:enable SimplifiedMagento_Base

# Run setup upgrade
php bin/magento setup:upgrade

# Compile DI (if needed)
php bin/magento setup:di:compile

# Deploy static content (if needed)
php bin/magento setup:static-content:deploy

# Clear cache
php bin/magento cache:flush
```

## Essential Files

### Controller Example

Create a frontend controller in `Controller/Index/Index.php`:

```php
<?php
namespace VendorName\ModuleName\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}
```

### Routes Configuration

Create `etc/frontend/routes.xml`:

```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
        xsi:noNamespaceSchemaLocation="urn:magento:framework:App/etc/routes.xsd">
    <router id="standard">
        <route id="base" frontName="base">
            <module name="SimplifiedMagento_Base"/>
        </route>
    </router>
</config>
```

### Layout File

Create `view/frontend/layout/modulename_index_index.xml`:

```xml
<?xml version="1.0"?>
<page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
      xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd">
    <head>
        <title>Module Page Title</title>
    </head>
    <body>
        <referenceContainer name="content">
            <block class="VendorName\ModuleName\Block\Index" 
                   name="modulename.index" 
                   template="VendorName_ModuleName::index.phtml"/>
        </referenceContainer>
    </body>
</page>
```

### Block Class

Create `Block/Index.php`:

```php
<?php
namespace VendorName\ModuleName\Block;

use Magento\Framework\View\Element\Template;

class Index extends Template
{
    public function getCustomMessage()
    {
        return "Hello from our custom module!";
    }
}
```

### Template File

Create `view/frontend/templates/index.phtml`:

```php
<div class="custom-module-content">
    <h2><?= __('Welcome to Our Module') ?></h2>
    <p><?= $block->getCustomMessage() ?></p>
</div>
```

## Common Commands

### Module Management
```bash
# List all modules
php bin/magento module:status

# Enable specific module
php bin/magento module:enable VendorName_ModuleName

# Disable specific module
php bin/magento module:disable VendorName_ModuleName

# Check module status
php bin/magento module:status VendorName_ModuleName
```

### Development Commands
```bash
# Setup upgrade (after module changes)
php bin/magento setup:upgrade

# Compile DI
php bin/magento setup:di:compile

# Deploy static content
php bin/magento setup:static-content:deploy -f

# Clear cache
php bin/magento cache:clean
php bin/magento cache:flush

# Reindex
php bin/magento indexer:reindex
```

### Database Setup
```bash
# Run database schema and data upgrades
php bin/magento setup:upgrade

# Check setup version
php bin/magento setup:db:status
```

## Best Practices

### Naming Conventions
- **Vendor Name**: Use your company name or unique identifier
- **Module Name**: Use PascalCase (e.g., HelloWorld, ProductManager)
- **File Names**: Follow PSR-4 standards
- **Class Names**: Use descriptive names with proper namespacing

### Code Structure
- Keep controllers lightweight
- Use dependency injection
- Follow Magento coding standards
- Implement proper error handling
- Use interfaces when possible

### Performance
- Minimize direct object manager usage
- Use factories and proxies appropriately
- Implement caching where needed
- Optimize database queries

### Security
- Validate and sanitize input data
- Use ACL (Access Control Lists) for admin functionality
- Implement proper CSRF protection
- Follow secure coding practices

## Examples

### Simple Helper Class

Create `Helper/Data.php`:

```php
<?php
namespace VendorName\ModuleName\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    public function isModuleEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            'vendorname_modulename/general/enabled',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    
    public function getConfigValue($field)
    {
        return $this->scopeConfig->getValue(
            'vendorname_modulename/general/' . $field,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
```

### Observer Example

Create `Observer/ProductSaveAfter.php`:

```php
<?php
namespace VendorName\ModuleName\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class ProductSaveAfter implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        $product = $observer->getEvent()->getProduct();
        
        // Your custom logic here
        error_log('Product saved: ' . $product->getName());
    }
}
```

Register the observer in `etc/events.xml`:

```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
        xsi:noNamespaceSchemaLocation="urn:magento:framework:Event/etc/events.xsd">
    <event name="catalog_product_save_after">
        <observer name="vendorname_modulename_product_save_after" 
                  instance="VendorName\ModuleName\Observer\ProductSaveAfter"/>
    </event>
</config>
```

## Troubleshooting

### Common Issues

1. **Module not appearing**: Check registration.php and module.xml syntax
2. **Permission errors**: Ensure proper file permissions (755 for directories, 644 for files)
3. **Cache issues**: Always clear cache after changes
4. **Layout not loading**: Verify layout XML file names and structure
5. **Class not found**: Run `setup:di:compile` and check namespaces

### Debug Tips

- Enable developer mode: `php bin/magento deploy:mode:set developer`
- Check logs: `var/log/system.log` and `var/log/exception.log`
- Use `var/generation` folder to check generated classes
- Verify file permissions and ownership

## Resources

- [Magento DevDocs](https://devdocs.magento.com/)
- [Magento Coding Standards](https://devdocs.magento.com/guides/v2.4/coding-standards/bk-coding-standards.html)
- [Magento Architecture](https://devdocs.magento.com/guides/v2.4/architecture/bk-architecture.html)

---

**Happy Coding!** 🚀

Remember to always test your modules thoroughly in a development environment before deploying to production.
