# Integrasi Aplikasi dengan GoSign Kota Gorontalo menggunakan PHP

## Instalasi

Instalasi menggunakan composer :

```
composer require gorontalokota/gosign-client
```

## Cara Menggunakan

### Membuat Permohonan Dokumen

```php
require(__DIR__ . "/vendor/autoload.php");

use GosignClient\Config;
use GosignClient\SignRequest;

Config::$isProduction = false;
Config::$clientKey = "client";
Config::$secretKey = "secret";

try {
    $params = array(
        'client_id'     => 'required',
        'document_id'   => 'required', //Dokumen ID (* disarankan UUID
        'title'         => 'required', //Judul Dokumen
        'assign_to'     => 'required', //NIK Penandatangan
        'document_url'  => 'required', //URL File Dokumen (* Wajib Https
        'document_status' => 'required', //Status Dokumen Yang dikirim
        'sign_symbol'     => '*', //Simbol untuk untuk koordinat lokasi tanda tangan (ex. *,@,#,|,^,$
        'sign_category'   => 'visible', // Kategori Tanda tangan (* Visible atau Invisible
        'sign_reason'     => 'required', // Alasan Penandatanganan
    );
    $request = SignRequest::create($params);
    echo $request->message;
}
catch (\Exception $e) {
    echo $e->getMessage();
}


```

### Response Callback Dari Gosign (*Webhook
#### Buat Satu Route Callback untuk memproses response setelah Dokumen Berhasil atau ditolak dari Gosign

```php
require(__DIR__ . "/vendor/autoload.php");

use GosignClient\Config;
use GosignClient\SignResponse;

Config::$isProduction = false;
Config::$clientKey = "client";
Config::$secretKey = "secret";

try {
    $response = new SignResponse->getResponse();
}
catch (\Exception $e) {
    echo $e->getMessage();
}
```

