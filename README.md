# Módulo Magento 2 - Santi_PrecioCupon

Este módulo permite aplicar un precio personalizado a los productos simples mediante un atributo personalizado como `precio_cupon`, compatible con **Hyvä** y Magento 2.4.7-p6.

---

## 🧩 Funcionalidad

- Si existe el atributo `precio_cupon` (u otro similar por tienda), y su valor es menor que el precio final (`special_price` o `regular_price`), **se aplica como precio final**.
- El precio más alto entre `precio_cupon`, `special_price` o `regular_price` se muestra tachado.
- Se aplica automáticamente en:
  - Vista de producto
  - Listado de productos (categoría)
  - Minicarrito y carrito
  - Checkout

---

## ⚙️ Instalación

1. Añade el repositorio de GitHub en `composer.json` (si usas repositorio Git):

    ```json
    "repositories": {
      "santi/preciocupon": {
        "type": "git",
        "url": "https://github.com/santimolto/PrecioCupon.git"
      }
    }
    ```

2. Instala el módulo:

    ```bash
    composer require santi/preciocupon:dev-main
    bin/magento module:enable Santi_PrecioCupon
    bin/magento setup:upgrade
    bin/magento cache:flush
    ```

---

## 💡 Integración con Hyvä

El módulo **no añade bloques XML personalizados**, ya que modifica directamente la lógica del precio mediante **Plugin PHP** sobre `getFinalPrice()` del producto.

### 🔧 Cómo reflejar visualmente el precio cupón en Hyvä

Edita tu archivo `Hyvä`:

`app/design/frontend/<Vendor>/<theme>/Magento_Catalog/templates/product/view/price.phtml`

Agrega en la lógica donde se representa el precio:

```php
<?php
$precioCupon = $product->getData('precio_cupon');
$precioFinal = $product->getFinalPrice();
$precioRegular = $product->getPrice();

if ($precioCupon && $precioCupon < $precioRegular):
?>
    <div class="price-box">
        <span class="special-price"><?= $block->escapeHtml(__('Special price:')) ?> <?= $precioFinal ?> €</span>
        <span class="old-price"><s><?= $precioRegular ?> €</s></span>
    </div>
<?php else: ?>
    <div class="price-box">
        <span class="regular-price"><?= $precioRegular ?> €</span>
    </div>
<?php endif; ?>
```

> Puedes ajustar la lógica según el atributo personalizado que uses (`precio_cupon_fr`, `precio_cupon_it`, etc.).

---

## 📁 Estructura del módulo

```
Santi/
└── PrecioCupon/
    ├── etc/
    │   └── di.xml
    ├── Plugin/
    │   └── ModifyPrice.php
    ├── registration.php
    └── composer.json
```

---

## 🧪 Verificación

Puedes verificar que la lógica esté aplicada correctamente activando el log o inspeccionando `getFinalPrice()` en el frontend o mediante `bin/magento shell`.

---

## 🧑‍💻 Autor

Desarrollado por [@santimolto](https://github.com/santimolto)

---

## 📝 Licencia

Este módulo se distribuye bajo licencia MIT.
