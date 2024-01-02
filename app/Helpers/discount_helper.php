<?php


if (!function_exists('discountPrice')) {
    function discountPrice($price, $discount): int
    {
        $discountedPrice = $price - ($price * $discount / 100);
        return $discountedPrice;
    }
}

if (!function_exists('toRupiah')) {

    function toRupiah($data)
    {
        return number_to_currency($data, 'IDR');
    }
}
