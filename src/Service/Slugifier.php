<?php

namespace App\Service;


class Slugifier
{
    public function slugify( $string ): string
    {
        $slug = "SLUG+" . $string . "+SLUG";

        return $slug;
    }
}