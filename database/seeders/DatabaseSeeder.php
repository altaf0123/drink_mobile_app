<?php

namespace Database\Seeders;
use App\Models\Content;
use Faker\Generator as Faker;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Request;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->generateContent();
         \App\Models\User::factory(200000)->create()->each(function ($user){
             $faker = \Faker\Factory::create();
             $req = new Request();
             $req->likes = $faker->randomElements(['apple','mango','banana','fish','dance','teach','makeup','talk'],2);
             $req->dislikes = $faker->randomElements(['grapes','orange','ketchup','peas','fight','cry'],2);
             $req->movies = $faker->randomElements(['game of thrones','The expandables' ,'the witcher','prates of carraibean','wonder woman','captain america','need for speed','troy','mad max fury','chronicles of narnia','harry potter','the batman action','jurassic park','the trial of chicago','mulan','fifty shades of grey','the saw','rambo'],3);
             $req->music  = $faker->randomElements(['rock','jazz','classical','disco','funk','heavy metal','folk music','reggae','religious','electro','hip hop'],3);
             $req->books =$faker->randomElements(['In Search of Lost Time','Ulysses by James Joyce','Don Quixote by Miguel de Cervantes','The Great Gatsby','One Hundred Years of Solitude','Beloved','Invisible Man','Hamlet','To the Lighthouse'],3);
             $req->tv_shows =$faker->randomElements(['The crown','Stranger Things','Into the badlands','Breaking Bad','Mad men','West world','The 100','Homeland','Fargo','The wire','South Park','Criminal minds','Vikings','Twin peaks','Lucifer','House of cards'],4);
             $req->hobbies =$faker->randomElements(['writing','swimming','dancing','blogging','vlogging','drama','hiking','fashion','stamp collecting','sketching','puzzles','lego building','gardening','parkour','walking','tourism','hooping'],3);
             $req->ethnicity_preferences =$faker->randomElements(['asian','american','african','arab','white','black','blonde'],3);
             $user->saveAttributes($req);
         });


    }



    function generateContent(){
        $body = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.';
        $content = new Content();
        $content->type = 'terms-and-conditions';
        $content->body =$body;
        $content->save();

        $content = new Content();
        $content->type = 'privacy-policy';
        $content->body =$body;
        $content->save();
    }

}
