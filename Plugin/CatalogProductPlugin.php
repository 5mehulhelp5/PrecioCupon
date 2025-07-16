<?php
namespace Santi\PrecioCupon\Plugin;

use Magento\Catalog\Model\Product;
use Psr\Log\LoggerInterface;

class CatalogProductPlugin
{
    protected $storeManager;
    protected $logger;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        LoggerInterface $logger
    ) {
        $this->storeManager = $storeManager;
        $this->logger = $logger;
    }

    public function afterGetFinalPrice($subject, $result)
    {
        try {
            $storeId = $this->storeManager->getStore()->getId();
            $priceKey = match ($storeId) {
                2, 23 => 'precio_cupon',
                4     => 'precio_cupon_it',
                7     => 'precio_cupon_fr',
                21    => 'precio_cupon_pt',
                19    => 'precio_cupon_nl',
                20    => 'precio_cupon_de',
                default => null
            };

            if (!$priceKey) {
                $this->logger->info("Santi_PrecioCupon: storeId $storeId no tiene atributo asignado.");
                return $result;
            }

            $customPrice = $subject->getData($priceKey);
            $this->logger->info("Santi_PrecioCupon (CATALOG): SKU " . $subject->getSku() . ", Atributo $priceKey = $customPrice");

            $customPrice = str_replace(',', '.', $customPrice);
            if (is_numeric($customPrice) && (float) $customPrice > 0) {
                return (float) $customPrice;
            }

        } catch (\Exception $e) {
            $this->logger->error("Santi_PrecioCupon ERROR CATALOG: " . $e->getMessage());
        }

        return $result;
    }
}