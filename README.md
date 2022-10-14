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
        'client_id'       => 'required',
        'document_id'     => 'required', //Dokumen ID (* disarankan UUID
        'title'           => 'required', //Judul Dokumen
        'assign_to'       => 'required', //NIK Penandatangan
        'document_url'    => 'required', //URL File Dokumen (* Wajib Https
        'document_status' => 'required', //Status Dokumen Yang dikirim
        'sign_symbol'     => '*', //Simbol untuk untuk koordinat lokasi tanda tangan (ex. *,@,#,|,^,$
        'sign_category'   => 'visible', // Kategori Tanda tangan (* Visible atau Invisible
        'sign_reason'     => 'required', // Alasan Penandatanganan\
        'sign_type'       => 'image atau qrcode', //Wajib isi jika category "visible"
        'sign_image'      => 'required', //url image TTE jika type image
        'custom_image'    => 'true/false',  //Jika menggunakan image custom dengan text
        'custom_image_text' => 'tipe json', //contoh dibawah
        'sign_width'      => '100', //ukuran lebar qrcode/image dalam pixel
        'sign_height'     => '100', //ukuran tinggi qrcode/image dalam pixel
                    
    );
    $request = SignRequest::create($params);
    echo $request->message;
}
catch (\Exception $e) {
    echo $e->getMessage();
}


//Contoh Request Custom Image Text
$custom_text = array(
            "text" => "Ditetapkan di Gorontalo,/n Pada tanggal {{date}},",
            "text_size" => 52,
            "x" => 5,
            "y" => 50,
            "align" => "center|left|right",
            "font" => "font.ttf",
            "color" => "#000000",
        );
        
$custom_image_text = json_encode($custom_text, true);

[Link testing Image custom](https://gosign.gorontalokota.go.id/try/custom-image)
[I'm an inline-style link](https://www.google.com)

[I'm an inline-style link with title](https://www.google.com "Google's Homepage")

[I'm a reference-style link][Arbitrary case-insensitive reference text]

[I'm a relative reference to a repository file](../blob/master/LICENSE)

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

