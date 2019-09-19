<?php

use Illuminate\Database\Seeder;
use App\Model\TagsList;
use App\Model\ConfigAutoTag;
class TagListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ds = [0,1,2,3,4,5,29,30];
        //
        TagsList::create([
            'name_tag' => 'DS1',
            'id_tag' => 0,
            'type'=> 0
        ]);
        TagsList::create([
            'name_tag' => 'DS2',
            'id_tag' => 1,
            'type'=> 0
        ]);
        TagsList::create([
            'name_tag' => 'DS3',
            'id_tag' => 2,
            'type'=> 0
        ]);
        TagsList::create([
            'name_tag' => 'DS4',
            'id_tag' => 3,
            'type'=> 0
        ]);
        TagsList::create([
            'name_tag' => 'DS5',
            'id_tag' => 4,
            'type'=> 0
        ]);
        TagsList::create([
            'name_tag' => 'DS6',
            'id_tag' => 5,
            'type'=> 0
        ]);
        TagsList::create([
            'name_tag' => 'DS7',
            'id_tag' => 29,
            'type'=> 0
        ]);
        TagsList::create([
            'name_tag' => 'DS8',
            'id_tag' => 30,
            'type'=> 0
        ]);

        ConfigAutoTag::create([
            'position' => 0,
            'token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1aWQiOiIzOGVkMDZiNy1hMzM4LTQxZjAtYjcyZC0wMGE4MDExZTdjNmUiLCJpYXQiOjE1NjU4NDUzMTcsImZiX25hbWUiOiJDYW8gQmFkYSIsImZiX2lkIjoiNzIyMjY4NzY3OTEwOTkwIiwiZXhwIjoxNTczNjIxMzE3fQ.OrMnQa--TuY4OoZ_P5yeD3LJDZHQtP6zI9iDwbXt5do',
            'page_id' => '2158311617763563|203805870401023'
        ]);
    }
}
