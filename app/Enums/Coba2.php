<?php

namespace App\Enums;

class Coba2 implements CobaInterface
{
    public function halo(string $name)
    {
        dd("Halo nama saya $name");
    }
    public function selamatTinggal(string $name ,string $pesan)
    {
        dd("selamat Tinggal $name $pesan");
    }

    public function biodata(string $name,int $umur) 
    {
        dd("Biodata : Nama = $name, Umur = $umur");
    }
}
