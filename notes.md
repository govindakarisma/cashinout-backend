## 1. Setup Project

1. Install Laravel

-   Install n Config auth ui
-   Install n Config sanctum

2. Instal Vue JS 3

Instalasi Vue JS menggunakan Vue CLI

## 2. Setup Table dan Relasi

1. Membuat migrations table users dan cashes
2. Membuat relasi user has many cash

## 3. Menyiapkan Endpoint untuk User

Uji coba API dengan menampilkan data user yang sedang login

Membuat seolah olah user dalam kondisi auth pada file `api.php` _(Routers)_ dengan melakukan inisiasi class Auth

```php
  Auth::loginUsingId(2);
```

## 4. Menyiapkan Endpoint untuk Transaksi (Cash)

1. Membuat validation (rule input data)
2. Create data dengan menyertakan uploader
3. Declare mass assignment

## 5. Menampilkan Balance, Debit dan Kredit

Data ditampilkan berdasakan user_id yang sama dengan id user authenticated.

```php
  Auth::user()->cashes()
```

1. Penghitungan debit

    Melakukan filter dengan mengambil data dari tanggal pertama bulan (januari misalnya) hingga waktu sekarang `now()`

    ```php
    ->whereBetween('when', [now()->firstOfMonth(), now()])
    ```

    Kemudian filter data yang nilainya lebih besar sama dengan (>=) 0

    ```php
    ->where('when', '>=', 0)
    ```

    Setelah filter data dengan berbagai ketentuan yang telah dilewati, lakukan penghitungan `amount`

    ```php
    ->get('amount)->sum('amount')
    ```

2. Perhitungan kredit

    Sama seperti **perhitungan debit**, namun bedanya melakukan filter data `amount` lebih kecil dari (<) 0

    ```php
    ->where('when', '<', 0)
    ```

3. Perhitungan Balance

    Cukup mudah karena `amount` menggunakan tipe data double

    ```php
    ->get('amount')->sum('amount')
    ```

## 6. Menampilkan Transaksi menggunakan Laravel Resource

1. Membuat format number

    Membuat helper function dengan membuat file `helper.php` pada `App`, lalu mengisinya dengan function.

    ```php
    function formatPrice($value)
    {
      return str_replace(',', '.', number_format($value));
    }
    ```

    Lalu daftarkan `helper.php` pada `composer.json`

    ```json
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/"
        },
        /** Tambahkan script seperti dibawah */
        "files": [
            "app/helpers.php"
        ]
    }
    ```

    Kemudian jalankan perintah pada command line dengan perintah `composer dump-autoload` agar function pada helper dapat dipanggil secara global

2. Make Cash Resource

    Menggunakan function `format()` agar waktu mudah dibaca. Namun sebelum menggunakan function tersebut, kolom yang menyimpan tanggal dan waktu eloquent laravel menganggapnya adalah sebuah `string` bukan `datetime`, oleh karena itu harus mendaftarkan pada model dengan `protected $guarded = ['when']` agar dianggap sebagai objek DateTime

## 7. Setup Frontend

Kunjungi `config\cors.php` untuk menambahkan endpoint yang dapat diakses aplikasi frontend dan `supports_credentials` menjadi `true` untuk bisa melakukan auth melalui frontend.

```php
  return [
    'paths' => [
        'api/*',
        'sanctum/csrf-cookie',
        'register',
        'login'
    ],
    /** ...Code lainnya */
    'supports_credentials' => true,
  ]
```

Jangan lupa untuk memasukkan `SESSION_DOAMIN=localhost` dan `SANCTUM_STATEFUL_DOMAINS=localhost:8080` _(sesuaikan dengan hostname dan port frontend)_ pada file `.env`

Tahapan ini akan dilanjutkan pada project vuejs cashinout
