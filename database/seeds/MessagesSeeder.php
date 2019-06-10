<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
class MessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i = 0; $i < 80; $i++)
        {
            App\Message::create(['text'=>$faker->text,
                                'object'=>$faker->sentence,
                                'recipientId'=>rand(2, 15),
                                'senderId'=>1,
                                'state'=>'unread']);

            App\Message::create(['text'=>$faker->text,
                                'object'=>$faker->sentence,
                                'recipientId'=>1,
                                'senderId'=>rand(2, 15),
                                'state'=>'unread']);

        }

    }
}
