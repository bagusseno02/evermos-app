# EVERMOS - TASK 1: Online Store

--------------------------------------------
### 1. PERMASALAHAN :
Masalah tersebut terjadi dikarenakan adanya request secara bersamaan **(concurrency request)**  
Contoh Kasus :
- Transaksi A, menjalankan perintah `UPDATE` pada data stok (tetapi belum dicommit). Transaksi B, membaca data stok tersebut. Lalu Transaksi B tidak jadi menjalankan perintah `UPDATE` tersebut dengan perintah `ROLLBACK`, dengan ini transaksi B membaca data stok yang tidak valid
- Transaksi A melakukan pembelian produk yang sama dengan Transaksi B secara bersamaan atau berdekatan, maka dapat digambarkan seperti berikut :

-------     ------ ----------   -------
    Transaksi A                         Transaksi B
    Select 2 Item Dari 10
                                        Select 3 Item Dari 10               
    Update Stok Item Menjadi 8  
                                        Update Stok Item Menjadi 7
    Commit          
                                        Commit

Ketika Proses diatas terjadi maka akan didapatkan total stok : 7, seharusnya 5. fenomena atau issue diatas biasa disebut dirty read.

### 2. SOLUSI :
Kita dapat menggunakan **queue** akan tetapi akan terjadi masalah baru ketika **concurrency request** terlalu banyak akan berpengaruh terhadap performa aplikasi, maka dari itu solusi efektif untuk mengatasi hal tersebut adalah dengan **isolation level**, kita dapat set **isolation level** menjadi ``Read Commited``.
Selanjutnya kita perlu menambakan _keyword_ ```for update``` pada akhir query select. `For Update` memberitahukan bahwa sedang ada transaksi sehingga transaksi lain harus menunggu proses _locking_ di _release_. _locking_ di _release_ saat transaksi selesai dan transaksi berikutnya dapat dilanjutkan.

## EVERMOS - TASK 2: Treasure Hunt

------------------------------------------------
- Menjalankan file php pada root project dengan command :
```
php TreasureHunt.php
```

# Library
- Dockerize
- Custom Package [coreapi/api-utilities]
- Swagger Documentation

# Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/lumen-framework/v/unstable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](http://lumen.laravel.com/docs).

## Security Vulnerabilities

If you discover a security vulnerability within Lumen, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
