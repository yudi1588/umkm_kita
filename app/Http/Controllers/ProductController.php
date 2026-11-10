<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    private const CATEGORIES = [
        'kuliner' => 'Makanan & Minuman',
        'fashion' => 'Fashion',
        'kerajinan' => 'Kerajinan',
        'pertanian' => 'Pertanian',
        'kopi' => 'Kopi',
        'oleh-oleh' => 'Oleh-Oleh',
        'perawatan' => 'Kecantikan & Perawatan',
    ];

    private const CATEGORY_ICONS = [
        'kuliner' => 'fa-cutlery',
        'fashion' => 'fa-shopping-bag',
        'kerajinan' => 'fa-gift',
        'pertanian' => 'fa-leaf',
        'kopi' => 'fa-coffee',
        'oleh-oleh' => 'fa-shopping-basket',
        'perawatan' => 'fa-heart',
    ];

    private const LOCATIONS = [
        'Sumbersari',
        'Kaliwates',
        'Tanggul',
        'Patrang',
        'Ambulu',
        'Panti',
        'Ajung',
    ];

    public function index(Request $request)
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', 'in:kuliner,fashion,kerajinan,pertanian,kopi,oleh-oleh,perawatan'],
            'location' => ['nullable', 'in:'.implode(',', self::LOCATIONS)],
        ]);

        $query = trim($validated['q'] ?? '');
        $category = $validated['category'] ?? '';
        $location = $validated['location'] ?? '';
        $products = [
            [
                'name' => 'Keripik Singkong UMKM',
                'category' => 'kuliner',
                'price' => 18000,
                'location' => 'Sumbersari, Jember',
                'image' => 'assets/user/products/keripik-umkm.jpg',
            ],
            [
                'name' => 'Kue Kering Homemade',
                'category' => 'kuliner',
                'price' => 35000,
                'location' => 'Kaliwates, Jember',
                'image' => 'assets/user/products/camilan-lokal.jpg',
            ],
            [
                'name' => 'Tas Anyaman Bambu',
                'category' => 'kerajinan',
                'price' => 85000,
                'location' => 'Ambulu, Jember',
                'image' => 'assets/user/products/keranjang-anyaman.jpg',
            ],
            [
                'name' => 'Miniatur Rumah Kayu',
                'category' => 'kerajinan',
                'price' => 125000,
                'location' => 'Patrang, Jember',
                'image' => 'assets/user/products/miniatur-kayu.jpg',
            ],
            [
                'name' => 'Paket Keripik Lokal',
                'category' => 'kuliner',
                'price' => 25000,
                'location' => 'Tanggul, Jember',
                'image' => 'assets/user/products/keripik-umkm.jpg',
            ],
            [
                'name' => 'Hampers Camilan UMKM',
                'category' => 'oleh-oleh',
                'price' => 65000,
                'location' => 'Panti, Jember',
                'image' => 'assets/user/products/camilan-lokal.jpg',
            ],
            [
                'name' => 'Keranjang Anyaman Mini',
                'category' => 'kerajinan',
                'price' => 65000,
                'location' => 'Ajung, Jember',
                'image' => 'assets/user/products/keranjang-anyaman.jpg',
            ],
            [
                'name' => 'Hiasan Rumah Kayu',
                'category' => 'kerajinan',
                'price' => 40000,
                'location' => 'Panti, Jember',
                'image' => 'assets/user/products/miniatur-kayu.jpg',
            ],
        ];

        $filteredProducts = array_values(array_filter($products, function ($product) use ($query, $category, $location) {
            $matchesCategory = $category === '' || $product['category'] === $category;
            $matchesLocation = $location === '' || str_starts_with($product['location'], $location.',');
            $searchableText = Str::lower(implode(' ', [
                $product['name'],
                self::CATEGORIES[$product['category']],
                $product['location'],
            ]));

            return $matchesCategory
                && $matchesLocation
                && ($query === '' || Str::contains($searchableText, Str::lower($query)));
        }));

        return view('user.products', [
            'products' => $filteredProducts,
            'productCount' => count($filteredProducts),
            'categories' => self::CATEGORIES,
            'categoryIcons' => self::CATEGORY_ICONS,
            'locations' => self::LOCATIONS,
            'query' => $query,
            'activeCategory' => $category,
            'activeLocation' => $location,
        ]);
    }
}
