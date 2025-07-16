# PrecioCupon
Magento 2 modificación del precio con Precio Cupón COMPATIBLE con HYVA
Extensión para modificación de precios mediate atributo de cupón
Debes crear en tu módulo una nueva plantilla compatible, como por ejemplo:

view/frontend/templates/hyva/price/final_price.phtml
Y en tu di.xml, sobreescribir el bloque o usar un plugin para que cargue tu template solo si está en Hyvä.

composer.json del proyecto Magento
Agrega el repositorio en tu composer.json:

"repositories": {
  "santi": {
    "type": "vcs",
    "url": "https://github.com/santimolto/module-precio-cupon"
  }
}


Y luego instálalo con:
composer require santi/module-precio-cupon:dev-main

# Santi_PrecioCupon

Este módulo para Magento 2 aplica un precio especial personalizado definido mediante un atributo de producto como `precio_cupon`, `precio_cupon_fr`, etc.

### 🎯 Funcionalidad

- Si existe un valor en `precio_cupon` (o similar), y es menor que el `special_price` o el `price`, se aplicará como precio final.
- Se muestra el precio original tachado si corresponde.
- Funciona en: ficha de producto, listado de categoría, carrito, minicarrito y checkout.

### 🛠 Instalación

1. Añade el repositorio a tu `composer.json`:

```json
"repositories": {
  "santi": {
    "type": "git",
    "url": "https://github.com/santimolto/PrecioCupon.git"
  }
}
