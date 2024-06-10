<?php

namespace App\Constant;

enum  HttpStatus: int
{
    // 2xx: Sukses
    const HTTP_OK = 200;            // Permintaan berhasil.
    const HTTP_CREATED = 201;       // Permintaan berhasil dan menghasilkan satu atau lebih sumber daya baru.
    const HTTP_NO_CONTENT = 204;    // Server berhasil memproses permintaan tetapi tidak mengembalikan konten apapun.
    const HTTP_BAD_REQUEST = 400;       // Server tidak dapat memahami permintaan karena sintaks yang tidak valid.
    const HTTP_UNAUTHORIZED = 401;      // Klien harus mengotentikasi diri untuk mendapatkan respons yang diminta.
    const HTTP_FORBIDDEN = 403;         // Klien tidak memiliki hak akses ke konten.
    const HTTP_NOT_FOUND = 404;         // Server tidak dapat menemukan sumber daya yang diminta.
    const HTTP_INTERNAL_SERVER_ERROR = 500;    // Pesan kesalahan umum, diberikan ketika kondisi yang tidak terduga terjadi.
}
