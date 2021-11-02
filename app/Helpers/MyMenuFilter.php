<?php
namespace App\Helpers;

use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class MyMenuFilter implements FilterInterface
{
    public function transform($item)
    {
        if (isset($item['permission']) && auth()->user()->role == ($item['permission'])) {
            return false;
        }
        return $item;
    }
}
