<?php

use Illuminate\Database\Seeder;
use App\Model\Shift;
class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Shift::create([
            'name_shift' => 'Giao ca sáng',
            'timestart' => '06:00:00',
            'timeend' => '08:00:00'
        ]);
        Shift::create([
            'name_shift' => 'Ca sáng',
            'timestart' => '08:00:00',
            'timeend' => '12:00:00'
        ]);
        Shift::create([
            'name_shift' => 'Giao ca trưa',
            'timestart' => '12:00:00',
            'timeend' => '13:00:00'
        ]);
        Shift::create([
            'name_shift' => 'Ca chiều',
            'timestart' => '13:00:00',
            'timeend' => '17:00:00'
        ]);
        Shift::create([
            'name_shift' => 'Giao ca tối',
            'timestart' => '17:00:00',
            'timeend' => '18:00:00'
        ]);
        Shift::create([
            'name_shift' => 'Ca tối',
            'timestart' => '18:00:00',
            'timeend' => '22:00:00'
        ]);
        Shift::create([
            'name_shift' => 'Ca Khuya',
            'timestart' => '22:00:00',
            'timeend' => '24:00:00'
        ]);
    }
}
