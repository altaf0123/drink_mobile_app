<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user=[
                'email' => $this->faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'interested_in'=>$this->faker->randomElement(['male','female','both']),
                'profile_video'=>'video-placeholder.mp4',
                'phone_no'=>$this->faker->e164PhoneNumber,
                'country'=>$this->faker->country,
                'date_of_birth'=>$this->faker->date('Y-m-d','2000-01-01'),
                'is_profile_complete'=>1,
                'location_range'=>rand(50.0,1000),
                'height_inch'=>$this->faker->randomElement([6.4,6.7,7.8,9.45,9.21,12.2,14.5,5.7,9.9,8.7]),
                'height_feet'=>$this->faker->randomElement([6.4,6.7,7.8,9.45,9.21,12.2,14.5,5.7,9.9,8.7]),
                'weight_lbs'=>$this->faker->randomElement([23.4,36.7,57.58,69.45,39.21,124.2,144.5,52.7,91.9,83.7]),
                'profession'=>$this->faker->randomElement(['doctor','singer','teacher','artist','businessman','pilot','soldier','engineer','banker']),
                'ethnicity_preferences'=>json_encode($this->faker->randomElements(['asian','american','african','arab','white','black','blonde'],2)),
                'account_verified'=>1,
                'remember_token' => Str::random(10),
        ];
        $gender = $this->faker->randomElement(['male','female','other']);
        if($gender=='male'){
            $user['name']=$this->faker->name('male');
            $user['profile_picture']='avatar-m.jpeg';
            $user['gender']='male';
        }
        if($gender=='female'){
            $user['name']=$this->faker->name('female');
            $user['profile_picture']='avatar-f.jpg';
            $user['gender']='female';
        }
        if($gender=='other'){
            $user['name']=$this->faker->name;
            $user['profile_picture']='avatar-g.jpg';
            $user['gender']='other';

        }
        return $user;
    }
}
