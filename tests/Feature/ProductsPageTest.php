<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProductsPageTest extends TestCase
{
    public function test_it_displays_the_product_catalog(): void
    {
        $response = $this->get('/produk');

        $response->assertOk()
            ->assertSeeText('FILTER PRODUK')
            ->assertSeeText('Keripik Singkong UMKM')
            ->assertSeeText('Miniatur Rumah Kayu');
    }

    public function test_it_filters_products_by_category(): void
    {
        $response = $this->get('/produk?category=kerajinan');

        $response->assertOk()
            ->assertSeeText('Tas Anyaman Bambu')
            ->assertDontSeeText('Keripik Singkong UMKM');
    }

    public function test_it_filters_products_by_location(): void
    {
        $response = $this->get('/produk?location=Ambulu');

        $response->assertOk()
            ->assertSeeText('Tas Anyaman Bambu')
            ->assertDontSeeText('Keripik Singkong UMKM');
    }

    public function test_it_shows_an_empty_state_when_no_products_match(): void
    {
        $response = $this->get('/produk?q=produk-yang-tidak-ada');

        $response->assertOk()
            ->assertSeeText('Produk belum ditemukan')
            ->assertDontSeeText('Keripik Singkong UMKM');
    }

    public function test_it_opens_a_product_detail_page(): void
    {
        $response = $this->get('/produk/keripik-singkong-umkm');

        $response->assertOk()
            ->assertSeeText('Keripik Singkong UMKM')
            ->assertSeeText('Deskripsi Produk')
            ->assertSeeText('Beli Sekarang')
            ->assertSeeText('Produk Terkait');
    }

    public function test_product_cards_link_to_their_detail_page(): void
    {
        $response = $this->get('/produk');

        $response->assertSee(route('products.show', 'keripik-singkong-umkm'));
    }
}
