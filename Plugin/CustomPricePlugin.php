<?php
namespace Santi\PrecioCupon\Plugin;

use Magento\Quote\Model\Quote\Item;
use Psr\Log\LoggerInterface;

class CustomPricePlugin
{
    protected $storeManager;
    protected $productRepository;
    protected $logger;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        LoggerInterface $logger
    ) {
        $this->storeManager = $storeManager;
        $this->productRepository = $productRepository;
        $this->logger = $logger;
    }

    public function afterGetPrice(Item $subject, $result)
    {
        try {
            $storeId = $this->storeManager->getStore()->getId();
            $product = $this->productRepository->getById($subject->getProductId());

            switch ($storeId) {
                case 2: $priceKey = 'precio_cupon'; break;
                case 4: $priceKey = 'precio_cupon_it'; break;
                case 7: $priceKey = 'precio_cupon_fr'; break;
                case 21: $priceKey = 'precio_cupon_pt'; break;
                case 19: $priceKey = 'precio_cupon_nl'; break;
                case 20: $priceKey = 'precio_cupon_de'; break;
                case 23: $priceKey = 'precio_cupon'; break;
                default:
                    $this->logger->info("Santi_PrecioCupon: storeId $storeId no tiene atributo asignado.");
                    return $result;
            }

            $customPrice = $product->getData($priceKey);
            $this->logger->info("Santi_PrecioCupon: SKU " . $product->getSku() . ", Atributo $priceKey = $customPrice");
            $customPrice = str_replace(',', '.', $customPrice);
            if (is_numeric($customPrice)) {
                return (float) $customPrice;
            } else {
                $this->logger->info("Santi_PrecioCupon: El atributo no es numérico o no está definido.");
            }
        } catch (\Exception $e) {
            $this->logger->error("Santi_PrecioCupon Error: " . $e->getMessage());
        }

        return $result;
    }
}
