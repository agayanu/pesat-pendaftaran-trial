<p align="center"><a href="https://smapluspgri.sch.id/" target="_blank"><img src="https://smapluspgri.info/images/icons/favicon.png" width="100"></a></p>

<p align="center">
<b>SMA PLUS PGRI CIBINONG</b>
</p>

## About

SmartReg adalah aplikasi untuk membantu anda dalam mengelola data PPDB. Adapun beberapa fitur yang didapatkan, diantaranya:

- Dapat di akses di semua gadget (Laptop/Komputer, Phone/Smartphone dan Tablet).
- Tersedia 34K++ data sekolah di indonesia, dan masih dapat ditambahkan ataupun dikelola.
- Tersedia 7K++ data kecamatan, 500++ data Kabupaten dan Kota, dan 34 Provinsi di indonesia, dan masih dapat ditambahkan ataupun dikelola.
- Pendaftaran dapat di setting menggunakan pembiayaan ataupun tidak.
- Auto Generate Virtual Account Bank.
- Item kelengkapan data siswa yang lengkap.
- Whatsapp dan email gateway saat pendaftaran dan pembayaran.
- Bukti Pendaftaran Online dan Offline PDF.
- Bukti Pembayaran PDF.
- Pemotongan otomatis detail pembayaran sesuai yang ditentukan.
- Download Data Excel.
- Live Report perjalanan PPDB.

## Requirement

- Apache and Mysql
- PHP >= 7.3.7
- Composer

## Installation

- rename file ".env.example" to ".env", and open it
- make your own database, and configure in ".env" file like this :
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```
- set your mail server account in ".env" file like this :
```bash
MAIL_MAILER=smtp
MAIL_HOST=your_out_going_server_url
MAIL_PORT=your_out_going_server_port
MAIL_USERNAME=your_mail_username
MAIL_PASSWORD=your_mail_password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=your_mail
MAIL_FROM_NAME="Your School Name"
```
- open terminal, and type 
```bash
composer install
```
- stay in terminal, and type
```bash
php artisan key:generate
```
- stay in terminal, and type
```bash
php artisan migrate
```
- stay in terminal, and type
```bash
php artisan db:seed
```
- access your url in browser like
```bash
localhost/pesat-pendaftaran/public/login
```
- login admin with this account :
```bash
email: admin@smapluspgri.sch.id
pass: 123456789
```
- set your profile school before use it

## License

The Pesat Pendaftaran is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
