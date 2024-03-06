<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class MenuController extends Controller
{
    public function getMenuItems()
    {
        // Replace this with your logic to fetch menu items from the database or other source
        $menuItems = [
            ['id' => 1, 'label' => 'Home', 'url' => '/'],

            ['id' => 2, 'label' => 'Product Name List', 'url' => '/about'],
            ['id' => 3, 'label' => 'Add Product Name', 'url' => '/contact'],
            ['id' => 4, 'label' => 'Product Category List', 'url' => '/contact'],
            ['id' => 5, 'label' => 'Add Product Category', 'url' => '/contact'],
            ['id' => 6, 'label' => 'Sell', 'url' => '/contact'],
            ['id' => 7, 'label' => 'Purchase', 'url' => '/contact'],

            ['id' => 8, 'label' => 'Add Customer', 'url' => '/contact'],
            ['id' => 9, 'label' => 'Customer List', 'url' => '/contact'],
            ['id' => 10, 'label' => 'Due Collection', 'url' => '/contact'],

            ['id' => 8, 'label' => 'Add Vendor', 'url' => '/contact'],
            ['id' => 9, 'label' => 'Vendor List', 'url' => '/contact'],
            ['id' => 10, 'label' => 'Debt Pay', 'url' => '/contact'],


            // Add more menu items as needed
        ];

        return response()->json($menuItems);
    }
}
