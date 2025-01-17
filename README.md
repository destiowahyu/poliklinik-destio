# CARA MENJALANKAN
1. Nyalakan **Apache** dan **MySQL** pada xampp. jika menggunakan aplikasi lain dapat di sesuaikan
2. Lakukan git clone dengan cara masuk ke folder `xampp/htdocs` lalu klik kanan, pilih _**gitbash here**_ **atau** klik kanan, pilih _**open in terminal**_ (Pastikan gitbash sudah terinstall)
3. Ketikan di terminal :

   ```
   git clone https://github.com/destiowahyu/poliklinik-destio.git
   ```

   lalu tekan enter
5. Lalu tunggu sampai proses download selesai
6. Buka alamat di browser :
   ```
   http://localhost/poliklinik-destio
   ```

# DATABASE
Buat database dengan nama : `poliklinik-destio`

lalu import file database `poliklinik-destio.sql` yang ada di folder db

# USER ROLE
### username dan password sesusai role :

ADMIN :

username : `admin`
password : `admin`


DOKTER :

username : `dokter`
password : `dokter`


PASIEN :

username : `pasien`
password : `pasien`

# ATURAN LOGIN
login admin dan dokter di halaman ***login dokter***

login pasien di halaman ***login pasien***
