<?php

if (! function_exists('formatRupiah')) {
    function formatRupiah($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}
function formatAngka($amount)
{
    return number_format($amount, 0, ',', '.');
}
