<?php

namespace App\Utils;

use Illuminate\Support\Str;

class Helpers
{
    public static function generete_noReq($kode_instansi)
    {
        $randomNumber = rand(1000000000, 9999999999);
        $bankCode = $kode_instansi;
        $accountNumber = $bankCode . $randomNumber;
        return $accountNumber;
    }

    public static function generateUserKey(): string
    {
        // Ambil waktu saat ini dalam detik dan milidetik
        $time = explode(' ', microtime());
        $timestamp = $time[1] . substr($time[0], 2, 3);

        // Ambil nomor urut terakhir dari tabel user
        $last_user = \App\Models\User::orderBy('id', 'desc')->first();
        $last_id = $last_user ? $last_user->id : 0;

        // Generate nomor urut baru
        $new_id = $last_id + 1;

        // Format nomor urut dengan nol di depan hingga mencapai 5 digit
        $formatted_id = str_pad($new_id, 5, '0', STR_PAD_LEFT);

        // Gabungkan waktu dan nomor urut untuk mendapatkan key baru
        $key = $timestamp . $formatted_id;

        // Cek apakah key sudah ada di tabel user
        $exists = \App\Models\User::where('keys', $key)->exists();

        // Jika key sudah ada, generate key baru hingga ditemukan yang unik
        while ($exists) {
            $new_id++;
            $formatted_id = str_pad($new_id, 5, '0', STR_PAD_LEFT);
            $key = $timestamp . $formatted_id;
            $exists = \App\Models\User::where('keys', $key)->exists();
        }

        return $key;
    }

    public static function Images($request, $nameFile, $path)
    {
        try {
            if ($request->hasFile($nameFile)) {
                $image = $request->file($nameFile);
                $image_name = Str::random() . time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path($path);
                $image->move($destinationPath, $image_name);
                return (object)["status" => true, "msg" => "success", "name" => $image_name, "full-path" => $path . "/" . $image_name];
            } else {
                return (object)["status" => false, "msg" => "oops!! error"];
            }
        } catch (\Exception $e) {
            return (object)["status" => false, "msg" => "oops!! error"];
        }
    }



    public static function JosonValidate($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}
