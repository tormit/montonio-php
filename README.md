# Montonio PHP SDK

[Montonio.com EN](https://montonio.com/en/maksed/)

[Montonio.com ET](https://montonio.com/et/maksed/)

## Installation

Add update composer.json, add

```json
"repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/tormit/montonio-php.git"
        },
]
```

Then

```bash
composer require veltix/montonio-php
```

## Getting started
```php

// https://partner.montonio.com/dashboard/stores
$publicKey = 'Avalik võti';
$secretKey = 'Salajane võti';

$montonio = new \Montonio\Payments\PaymentSDK(
    $publicKey, $secretKey, 'sandbox'
);
```

