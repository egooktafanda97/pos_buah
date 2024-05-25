<?php

namespace App\Constant;

enum  HttpStatus: int
{
        // 2xx: Sukses
    case HTTP_OK = 200;            // Permintaan berhasil.
    case HTTP_CREATED = 201;       // Permintaan berhasil dan menghasilkan satu atau lebih sumber daya baru.
    case HTTP_NO_CONTENT = 204;    // Server berhasil memproses permintaan tetapi tidak mengembalikan konten apapun.
        // 4xx: Kesalahan Klien
    case HTTP_BAD_REQUEST = 400;       // Server tidak dapat memahami permintaan karena sintaks yang tidak valid.
    case HTTP_UNAUTHORIZED = 401;      // Klien harus mengotentikasi diri untuk mendapatkan respons yang diminta.
    case HTTP_FORBIDDEN = 403;         // Klien tidak memiliki hak akses ke konten.
    case HTTP_NOT_FOUND = 404;         // Server tidak dapat menemukan sumber daya yang diminta.
        // 5xx: Kesalahan Server
    case HTTP_INTERNAL_SERVER_ERROR = 500;    // Pesan kesalahan umum, diberikan ketika kondisi yang tidak terduga terjadi.
}
