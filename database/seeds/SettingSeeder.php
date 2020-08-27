<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;
class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::setMany([
            'default_locale' => 'ar',
            'default_timezone' => 'Africa/Cairo',
            'reviews_enabled' => true,
            'auto_approve_reviews' => true,
            'supported_currency' => ['USD','LE','SAR'],
            'default_currency' => 'USD',
            'store_email' => 'admin@ecommerce.test',
            'search_engine' => 'mysql',
            'local_shipping_cost' => 0,
            'outer_shipping_cost' => 0,
            'free_shipping_cost' => 0,
            'translatable' => [
                'store_name' => ['en' => 'zakaria store',
                'ar' => 'متجر زكريا'
            ],
                'free_shipping_label' => ['en' => 'free shipping',
                'ar' => 'شحن مجاني'
            ],
                'local_label' => ['en' => 'Local shipping',
                'ar' => 'التوصيل المحلي'
            ],
                'outer_label' => ['en' => 'outer shipping',
                'ar' => 'التوصيل الخارجي',
            ],

            ]
        ]);
    }
}
