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
        $products = $this->products();

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

    public function show(string $slug)
    {
        $product = collect($this->products())->firstWhere('slug', $slug);

        abort_if($product === null, 404);

        return view('user.product-detail', [
            'product' => $product,
            'categoryLabel' => self::CATEGORIES[$product['category']],
            'categories' => self::CATEGORIES,
            'relatedProducts' => array_values(array_filter(
                $this->products(),
                fn (array $relatedProduct): bool => $relatedProduct['slug'] !== $product['slug']
                    && $relatedProduct['category'] === $product['category']
            )),
        ]);
    }

    private function products(): array
    {
        return [
            [
                'slug' => 'keripik-singkong-umkm',
                'name' => 'Keripik Singkong UMKM',
                'category' => 'kuliner',
                'price' => 18000,
                'location' => 'Sumbersari, Jember',
                'image' => 'assets/user/products/keripik-umkm.jpg',
                'description' => 'Keripik singkong renyah dengan cita rasa gurih, dibuat dari bahan pilihan oleh pelaku UMKM lokal.',
            ],
            [
                'slug' => 'kue-kering-homemade',
                'name' => 'Kue Kering Homemade',
                'category' => 'kuliner',
                'price' => 35000,
                'location' => 'Kaliwates, Jember',
                'image' => 'assets/user/products/camilan-lokal.jpg',
                'description' => 'Kue kering homemade yang cocok untuk camilan keluarga maupun sajian saat berkumpul.',
            ],
            [
                'slug' => 'tas-anyaman-bambu',
                'name' => 'Tas Anyaman Bambu',
                'category' => 'kerajinan',
                'price' => 85000,
                'location' => 'Ambulu, Jember',
                'image' => 'assets/user/products/keranjang-anyaman.jpg',
                'description' => 'Tas anyaman bambu handmade dengan desain ringan, kuat, dan cocok untuk penggunaan sehari-hari.',
            ],
            [
                'slug' => 'miniatur-rumah-kayu',
                'name' => 'Miniatur Rumah Kayu',
                'category' => 'kerajinan',
                'price' => 125000,
                'location' => 'Patrang, Jember',
                'image' => 'assets/user/products/miniatur-kayu.jpg',
                'description' => 'Miniatur rumah kayu yang dibuat dengan detail dan ketelitian untuk dekorasi ruangan.',
            ],
            [
                'slug' => 'paket-keripik-lokal',
                'name' => 'Paket Keripik Lokal',
                'category' => 'kuliner',
                'price' => 25000,
                'location' => 'Tanggul, Jember',
                'image' => 'assets/user/products/keripik-umkm.jpg',
                'description' => 'Paket keripik lokal pilihan untuk menemani waktu santai atau dijadikan oleh-oleh.',
            ],
            [
                'slug' => 'hampers-camilan-umkm',
                'name' => 'Hampers Camilan UMKM',
                'category' => 'oleh-oleh',
                'price' => 65000,
                'location' => 'Panti, Jember',
                'image' => 'assets/user/products/camilan-lokal.jpg',
                'description' => 'Hampers berisi camilan UMKM lokal yang praktis untuk hadiah dan oleh-oleh.',
            ],
            [
                'slug' => 'keranjang-anyaman-mini',
                'name' => 'Keranjang Anyaman Mini',
                'category' => 'kerajinan',
                'price' => 65000,
                'location' => 'Ajung, Jember',
                'image' => 'assets/user/products/keranjang-anyaman.jpg',
                'description' => 'Keranjang anyaman mini yang serbaguna untuk menyimpan barang kecil di rumah.',
            ],
            [
                'slug' => 'hiasan-rumah-kayu',
                'name' => 'Hiasan Rumah Kayu',
                'category' => 'kerajinan',
                'price' => 40000,
                'location' => 'Panti, Jember',
                'image' => 'assets/user/products/miniatur-kayu.jpg',
                'description' => 'Hiasan rumah berbahan kayu untuk memberikan sentuhan hangat pada ruangan.',
            ],
        ];
    }
}
