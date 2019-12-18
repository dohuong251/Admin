<?php

use Illuminate\Database\Seeder;

class PromotionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::connection("mysql")->table('promotions')->insert([
            'content' => '{"com_liveplayer_android":{"imageUrl":"http:\/\/www.mdcgate.com\/apps\/upload\/images\/black_friday\/start_web_message.jpg","title":"Black Friday Sale Off","notification":{"title":"Black Friday 2019","url":"http:\/\/www.mdcgate.com\/apps\/upload\/images\/black_friday\/notification.jpg"}},"com_mdc_iptvplayer_ios":{"imageUrl":"http:\/\/www.mdcgate.com\/apps\/upload\/images\/black_friday\/start_web_message.jpg","notification":{"title":"Black Friday 2019","url":"http:\/\/www.mdcgate.com\/apps\/upload\/images\/black_friday\/notification.jpg"}},"com_mdcmedia_liveplayer_ios":{"imageUrl":"http:\/\/www.mdcgate.com\/apps\/upload\/images\/black_friday\/start_web_message.jpg","promoBgUrl":"http:\/\/edge.mdcgate.com\/livemedia\/images\/img_header_promotion_full_blackfriday.jpg","promoText":"Black Friday !","notification":{"title":"Black Friday 2019","url":"http:\/\/www.mdcgate.com\/apps\/upload\/images\/black_friday\/notification.jpg"}},"com_ustv_player":{"imageUrl":"http:\/\/www.mdcgate.com\/apps\/upload\/images\/black_friday\/start_web_message.jpg","notification":{"title":"Black Friday 2019","url":"http:\/\/www.mdcgate.com\/apps\/upload\/images\/black_friday\/notification.jpg"}},"mdc_store":{"backgroundUrl":"\/apps\/public\/images\/backfriday\/background.png","leftImgUrl":"\/apps\/public\/images\/backfriday\/left.png","rightImgUrl":"\/apps\/public\/images\/backfriday\/right.png","mobile_sale_price":"3.49","desktop_sale_price":"13.99"}}',
            'notification_id' => '[]',
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => now()
        ]);
    }
}
