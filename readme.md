# EVERMOS - TASK 1: Online Store

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

- Menjalankan file php pada root project dengan command :
```
php TreasureHunt.php
```

# How To Check Endpoint Available
```
php artisan route:list
```

# How To Build & Run?
```
setup .env with .env.example
```
```
composer install
```
```
 sh ./start_server.sh
```
or
```
php -S localhost:{port} -t public
```

# GITFLOW-IMPLEMENTATION
- master
- develop
- feature
- bugfix
- hotfix
- release

If ticketing system in git repository just add #{issue_number} in commit message

# Api Docs
## Product

-----------
### Create Product
#### Method POST
```
localhost:8087/product/create
```
#### Request Payload
```
{
	"name": "Handphone",
	"price": 500000,
	"stock": 10,
	"category_product_id" : 1,
	"expired_date": "2020/12/12",
	"bpm_number": "string",
	"supplier_id" : 2,
	"price_event": 4000,
	"event_id": 2
}
```
#### Response
```
{
    "error": false,
    "message": "Successfully create product",
    "data": {
        "id": 10,
        "code": "P074457",
        "name": "Handphone",
        "price": "500000",
        "category_product_id": "[{'Master Category Product'}]",
        "expired_date": "2020/12/12",
        "bpom_number": null,
        "supplier_id": "[{'Master SUpplier'}]",
        "price_event": "4000",
        "event_id": "[{'Master Category Product'}]"
    }
}
```

--------------
### Detail
#### Method GET
```
localhost:8087/product/detail/{id}
```
#### Response
```
{
    "error": false,
    "message": "Successfully get product detail",
    "data": {
        "id": 4,
        "name": "Tas",
        "code": "P094868",
        "category_product_id": 1,
        "price": "500000",
        "expired_date": null,
        "bpom_number": null,
        "supplier_id": null,
        "packaging_id": null,
        "created_at": "2021-02-25 20:16:06",
        "created_by": null,
        "updated_at": null,
        "updated_by": null,
        "deleted_at": null,
        "deleted_by": null,
        "is_deleted": false,
        "price_event": null,
        "stock": 10,
        "event_id": null
    }
}
```
-----------
### Delete 
#### Method DELETE
```
localhost:8087/product/delete/{id}
```
#### Response
```
{
    "error": false,
    "message": "Product has been deleted"
}
```
---------------------------------
### Update
#### Method PUT
```
localhost:8087/product/update/{id}
```
#### Request Payload
```
{
	"name": "Headset",
	"price": 500000,
	"stock": 10,
	"category_product_id" : 1,
	"expired_date": "2020/12/12",
	"bpm_number": "string",
	"supplier_id" : 2,
	"price_event": 4000,
	"event_id": 2
}
```
#### Response
```
{
    "error": false,
    "message": "Successfully update product",
    "data": {
        "id": 5,
        "code": "P070562",
        "name": "Headset",
        "price": "500000",
        "category_product_id": "[{'Master Category Product'}]",
        "expired_date": "2020/12/12",
        "bpom_number": null,
        "supplier_id": "[{'Master SUpplier'}]",
        "price_event": "4000",
        "event_id": "[{'Master Category Product'}]"
    }
}
```
----------------------
### List
#### Method POST
```
localhost:8087/product/list
```
#### Request Payload
```
{
    "pagination": {
        "limit": 0,
        "page": 10,
        "column": "created_at",
        "ascending": false,
        "query":""
    }
}
```
#### Response
```
{
    "error": false,
    "message": "Successfully get list product",
    "length": 6,
    "data": [
        {
            "id": 5,
            "code": "P070562",
            "name": "Headset",
            "price": "500000",
            "category_product_id": "[{'Master Category Product'}]",
            "expired_date": "2020-12-12",
            "bpom_number": null,
            "supplier_id": "[{'Master SUpplier'}]",
            "price_event": "4000",
            "event_id": "[{'Master Category Product'}]"
        },
        {
            "id": 10,
            "code": "P074457",
            "name": "Handphone",
            "price": "500000",
            "category_product_id": "[{'Master Category Product'}]",
            "expired_date": "2020-12-12",
            "bpom_number": null,
            "supplier_id": "[{'Master SUpplier'}]",
            "price_event": "4000",
            "event_id": "[{'Master Category Product'}]"
        },
        {
            "id": 9,
            "code": "P016643",
            "name": "Handphone",
            "price": "500000",
            "category_product_id": "[{'Master Category Product'}]",
            "expired_date": "2020-12-12",
            "bpom_number": null,
            "supplier_id": "[{'Master SUpplier'}]",
            "price_event": "4000",
            "event_id": "[{'Master Category Product'}]"
        },
        {
            "id": 8,
            "code": "P033308",
            "name": "Handphone",
            "price": "500000",
            "category_product_id": "[{'Master Category Product'}]",
            "expired_date": "2020-12-12",
            "bpom_number": null,
            "supplier_id": "[{'Master SUpplier'}]",
            "price_event": "4000",
            "event_id": "[{'Master Category Product'}]"
        },
        {
            "id": 7,
            "code": "P026040",
            "name": "Tas",
            "price": "500000",
            "category_product_id": "[{'Master Category Product'}]",
            "expired_date": "2021-10-10",
            "bpom_number": null,
            "supplier_id": "[{'Master SUpplier'}]",
            "price_event": null,
            "event_id": "[{'Master Category Product'}]"
        },
        {
            "id": 6,
            "code": "P016145",
            "name": "Tas",
            "price": "500000",
            "category_product_id": "[{'Master Category Product'}]",
            "expired_date": "2021-10-10",
            "bpom_number": null,
            "supplier_id": "[{'Master SUpplier'}]",
            "price_event": null,
            "event_id": "[{'Master Category Product'}]"
        }
    ]
}
```
