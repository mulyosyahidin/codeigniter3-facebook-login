# Login dengan Facebook di CodeIgniter 3

Repo ini berisi penggunaan Facebook Graph SDK v2.10 untuk authentikasi pengguna, terdiri dari "Daftar dengan Facebook" dan "Login dengan Facebook"

## Alur Pendaftaran
- User klik link "Daftar dengan Facebook"
- Menghubungkan dengan Facebook Graph
- Mendapatkan data dari Facebook Graph (nama, email dan id user)
- Memeriksa apakah user sudah terdaftar atau belum
1. Jika sudah: dikembalikan ke halaman register dengan pesan "User sudah terdaftar, tinggal login saja"
2. Jika belum: masukkan data ke database, redirect ke halaman dasboard

## Alur Login
- User klik link "Daftar dengan Facebook"
- Menghubungkan dengan Facebook Graph
- Mendapatkan data dari Facebook Graph (nama, email dan id user)
- Memeriksa apakah user sudah terdaftar atau belum
-- Jika sudah: set session login dan redirect ke dasbor
-- Jika belum: kembalikan ke halaman register dengan pesan "Belum terdaftar"
