<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('categories')->insert(
            ['name' => '家庭常备', 'is_banner' => 1, 'logo' => 'http://o8r5bg2z1.bkt.clouddn.com/%E5%AE%B6%E5%BA%AD%E5%B8%B8%E5%A4%87.png']);
        DB::table('categories')->insert(
            ['name' => '常用药品', 'is_banner' => 1, 'logo' => 'http://o8r5bg2z1.bkt.clouddn.com/%E5%B8%B8%E7%94%A8%E8%8D%AF%E5%93%81.png']);
        DB::table('categories')->insert(
            ['name' => '老年中心', 'is_banner' => 1, 'logo' => 'http://o8r5bg2z1.bkt.clouddn.com/%E8%80%81%E5%B9%B4%E4%B8%AD%E5%BF%83.png']);
        DB::table('categories')->insert(
            ['name' => '营养保健', 'is_banner' => 1, 'logo' => 'http://o8r5bg2z1.bkt.clouddn.com/%E8%90%A5%E5%85%BB%E4%BF%9D%E5%81%A5.png']);
        DB::table('categories')->insert(
            ['name' => '母婴专区', 'is_banner' => 1, 'logo' => 'http://o8r5bg2z1.bkt.clouddn.com/%E6%AF%8D%E5%A9%B4%E7%94%A8%E5%93%81.png']);
        DB::table('categories')->insert(
            ['name' => '器械商城', 'is_banner' => 1, 'logo' => 'http://o8r5bg2z1.bkt.clouddn.com/%E5%99%A8%E6%A2%B0%E5%95%86%E5%9F%8E.png']);
        DB::table('categories')->insert(
            ['name' => '滋补养生', 'is_banner' => 1, 'logo' => 'http://o8r5bg2z1.bkt.clouddn.com/%E8%90%A5%E5%85%BB%E4%BF%9D%E5%81%A5.png']);
        DB::table('categories')->insert(
            ['name' => '美妆/个护', 'is_banner' => 1, 'logo' => 'http://o8r5bg2z1.bkt.clouddn.com/%E7%BE%8E%E5%A6%86-%E4%B8%AA%E6%8A%A4.png']);
        DB::table('categories')->insert(
            ['name' => '美妆/幸福生活', 'is_banner' => 1, 'logo' => 'http://o8r5bg2z1.bkt.clouddn.com/%E5%B9%B8%E7%A6%8F%E7%94%9F%E6%B4%BB.png']);
        DB::table('categories')->insert(
            ['name' => '儿科用药', 'is_banner' => 1, 'logo' => 'http://o8r5bg2z1.bkt.clouddn.com/%E5%84%BF%E7%A7%91%E7%94%A8%E8%8D%AF.png']);
        DB::table('categories')->insert(
            ['name' => '感冒呼吸', 'is_banner' => 1, 'logo' => 'http://o8r5bg2z1.bkt.clouddn.com/%E6%84%9F%E5%86%92%E5%91%BC%E5%90%B8.png']);
        DB::table('categories')->insert(
            ['name' => '胃肠用药', 'is_banner' => 1, 'logo' => 'http://o8r5bg2z1.bkt.clouddn.com/%E8%83%83%E8%82%A0%E7%94%A8%E8%8D%AF.png']);
        DB::table('categories')->insert(
            ['name' => '妇科用药', 'is_banner' => 1, 'logo' => 'http://o8r5bg2z1.bkt.clouddn.com/%E5%A6%87%E7%A7%91%E7%94%A8%E8%8D%AF.png']);
        DB::table('categories')->insert(
            ['name' => '男科用药', 'is_banner' => 1, 'logo' => 'http://o8r5bg2z1.bkt.clouddn.com/%E7%94%B7%E7%A7%91%E7%94%A8%E8%8D%AF.png']);
        DB::table('categories')->insert(
            ['name' => '皮肤用药', 'is_banner' => 1, 'logo' => 'http://o8r5bg2z1.bkt.clouddn.com/%E7%9A%AE%E8%82%A4%E7%94%A8%E8%8D%AF.png']);
        DB::table('categories')->insert(
            ['name' => '隐形眼镜', 'is_banner' => 1, 'logo' => 'http://o8r5bg2z1.bkt.clouddn.com/%E9%9A%90%E5%BD%A2%E7%9C%BC%E9%95%9C.png']);
        DB::table('categories')->insert(
            ['name' => '糖尿病专区']);
        DB::table('categories')->insert(
            ['name' => '慢病专区']);
        DB::table('categories')->insert(
            ['name' => '五官用药']);
        DB::table('categories')->insert(
            ['name' => '心脑血管']);
        DB::table('categories')->insert(
            ['name' => '男科用药']);
        DB::table('categories')->insert(
            ['name' => '神经科']);
        DB::table('categories')->insert(
            ['name' => '精神科']);
        DB::table('categories')->insert(
            ['name' => '消化系统']);
        DB::table('categories')->insert(
            ['name' => '皮肤/性病']);
        DB::table('categories')->insert(
            ['name' => '肝胆用药']);
        DB::table('categories')->insert(
            ['name' => '妇科用药']);
        DB::table('categories')->insert(
            ['name' => '内分泌科']);
        DB::table('categories')->insert(
            ['name' => '呼吸系统']);
        DB::table('categories')->insert(
            ['name' => '风湿骨科']);
        DB::table('categories')->insert(
            ['name' => '泌尿系统']);
        DB::table('categories')->insert(
            ['name' => '肿瘤用药']);
        DB::table('categories')->insert(
            ['name' => '滋补调理']);
        DB::table('categories')->insert(
            ['name' => '免疫/移植']);
        DB::table('categories')->insert(
            ['name' => '免疫/移植']);
        DB::table('categories')->insert(
            ['name' => '儿科用药']);
        DB::table('categories')->insert(
            ['name' => '母婴专区']);
        DB::table('categories')->insert(
            ['name' => '滋补养生']);
        DB::table('categories')->insert(
            ['name' => '器械商城']);
        DB::table('categories')->insert(
            ['name' => '老年中心']);
        DB::table('categories')->insert(
            ['name' => '幸福生活']
        );
    }
}
