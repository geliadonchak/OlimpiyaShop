<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ParseProducts extends Command
{
    protected $signature = 'products:parse';
    protected $description = 'Parse products from ' . self::SITE_NAME;

    public function __construct()
    {
        parent::__construct();
    }

    private const SITE_NAME = 'Olimp';
    private const SITE_URL = 'https://olimpvl.ru';

    private const ALL_CATEGORIES = [
        'Тренажеры и фитнес' => '/catalog/trenazhery_i_fitnes/',
        'Туризм и активный отдых' => '/catalog/turizm_i_aktivnyj_otdyx/'
    ];

    private $totalCount = 0;

    private const PRODUCTS_COUNT = 200;
    private const REGEXP_CATEGORIES = '/<li class="b-catalog-category__item">[^<]*<a[^>]*href="(?<url>[^"]*)"[^>]*title="(?<title>[^"]*)"/su';
    private const REGEXP_LAST_PAGE = '/<a class="b-pagination__pagelink"[^>]*>(?<pagesCount>[^<]*)<\/a>[^<]*<\/li>[^<]*<li[^>]*>[^<]*<[^>]*b-pagination__next"/';
    private const REGEXP_PRODUCT = '/b-product__item.*?<a[^>]*href="(?<url>[^"]*)".*?b-product__item--image[^>]*src="(?<image>[^"]*)".*?b-product__item-text[^>]*>(?<name>[^<]*).*?b-product__item--price.*?data-price="(?<price>[^"]*)"/su';
    private const REGEXP_PRODUCT_PAGE = '/b-tab-description">(?<description>.*?)<\/div.*?b-tab-features(?<attributesContainer>.*?)<\/tbody/su';
    private const REGEXP_ATTRS = '/b-table__row.*?b-table__item[^>]*>(?<name>.*?)<\/.*?b-table__item[^>]*>(?<value>.*?)<\//su';

    /**
     * @throws \Exception
     */
    private function parseProducts($categoryId, $page)
    {
        preg_match_all(self::REGEXP_PRODUCT, $page, $matched, PREG_SET_ORDER);
        foreach ($matched as $match) {
            $imageUrl = str_contains(self::SITE_URL, $match['image']) ? $match['image'] : self::SITE_URL . $match['image'];
            $image = file_get_contents($imageUrl);
            $description = '';

            Storage::put('public' . $match['image'], $image);

            $productPage = Http::get($match['url']);
            if (preg_match(self::REGEXP_PRODUCT_PAGE, $productPage->body(), $productMatch)) {
                $description = htmlspecialchars_decode(trim(strip_tags(
                    preg_replace('/<br>|<br\s?\/>/su', "\n", $productMatch['description'])
                )));

                if (preg_match_all(self::REGEXP_ATTRS, $productMatch['attributesContainer'], $attrsMatch, PREG_SET_ORDER)) {
                    // todo парсить аттрибуты
                }
            }

            Product::saveProduct(htmlspecialchars_decode($match['name']), $description, $match['price'], $match['image'], $categoryId, random_int(1, 5));
        }
        $this->totalCount += count($matched);
        echo date('H:i:s') . " Parsing " . count($matched) . " products\n";
    }

    private function parseSubCategories($name, $categoryUrl, $parentCategory)
    {
        echo date('H:i:s') . " Parsing $name category\n";
        $category = Category::saveCategory($name, $parentCategory);
        $page = Http::get(self::SITE_URL . $categoryUrl, [
            'PAGEN_2' => 1,
            'productCount' => self::PRODUCTS_COUNT
        ])->body();
        preg_match_all(self::REGEXP_CATEGORIES, $page, $matched, PREG_SET_ORDER);

        if (!$matched) {
            $this->parseProducts($category, $page);
            preg_match(self::REGEXP_LAST_PAGE, $page, $lastPageMatch);
            $lastPage = $lastPageMatch['pagesCount'] ?? 1;
            for ($i = 2; $i <= $lastPage; ++$i) {
                $this->parseProducts($category, Http::get(self::SITE_URL . $categoryUrl, [
                    'PAGEN_2' => $i,
                    'productCount' => self::PRODUCTS_COUNT
                ])->body());
            }

            return;
        }

        foreach ($matched as $match) {
            $this->parseSubCategories($match['title'], $match['url'], $category);
        }
    }

    public function handle()
    {
        Product::query()->delete();
        Category::query()->delete();

        echo date('H:i:s') . " Starting parsing categories\n";
        foreach (self::ALL_CATEGORIES as $name => $category) {
            $this->parseSubCategories($name, $category, null);
        }
        echo date('H:i:s') . "Finished parsing categories\n";
        echo "Parsed " . $this->totalCount . " products! :)";
        return 0;
    }
}
