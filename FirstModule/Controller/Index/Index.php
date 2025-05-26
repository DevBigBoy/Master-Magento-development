<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace SimplifiedMagento\FirstModule\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * Class Index
 */
class Index implements HttpGetActionInterface
{

    /**
     * @inheritdoc
     */
    public function execute()
    {
        dd("First Module");
    }
}
