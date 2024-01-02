<?php


if (!function_exists('component')) {
    function component(string|null $name = null, array $data = [], array $options = []): string
    {
        return view("components/$name", $data, $options);
    }
}


if (!function_exists('pages')) {
    function pages(string|null $name = null, array $data = [], array $options = []): string
    {
        return view("pages/$name", $data, $options);
    }
}

function LandingPages(string|null $name = null, array $data = [], array $options = []): string
{
    return pages("LandingPages/$name", $data, $options);
}

function PrivatePages(string|null $name = null, array $data = [], array $options = []): string
{
    return pages("Private/$name", $data, $options);
}
