<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace SimplifiedMagento\FirstModule\Controller\Index;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;
use SimplifiedMagento\FirstModule\NotMagento\PencilInterface;

/**
 * Class Index
 */
class Index implements HttpGetActionInterface
{

    public function __construct(
        private PencilInterface $pencil,
        private ProductRepositoryInterface $productRepository
    ) {
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        $pencil = $this->pencil;
        //        dd("First Module");
        //        dd($pencil->getPencilType());

        dd(get_class($this->productRepository));
    }
}
