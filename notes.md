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
