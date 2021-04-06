<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Video::create([
            'link' => 'https://www.youtube.com/embed/Hz9Hx1N9CqM'
        ]);
        Video::create([
            'link' => 'https://www.youtube.com/embed/h9Am4CYaLng'
        ]);
        Video::create([
            'link' => 'https://www.youtube.com/embed/YFfEFbC9_XQ'
        ]);
        Video::create([
            'link' => 'https://www.youtube.com/embed/RyLlPlpV3Fw'
        ]);
    }
}
