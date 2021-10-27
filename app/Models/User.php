<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\Likeable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens , HasFactory, Notifiable , Likeable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function attributes(){
        return $this->hasMany(UserAttributes::class,'user_id');
    }


    public function getAtrributes(){
        return $this->attributes()->select('users_attributes.attribute_value','users_attributes.attribute_key');
    }



    public function updateLocation($request){
        $this->lat = $request->lat;
        $this->long = $request->long;
        if($request->radius){
            $this->location_range = $request->radius;
        }
        $this->save();
    }




    public function saveAttributes($request){
       if(isset($request->likes) && is_array($request->likes)){
            UserAttributes::updateOrCreate([
                'user_id'   => $this->id,
                'attribute_key'      => 'likes'
            ],[
                'user_id'            => $this->id,
                'attribute_key'      => 'likes',
                'attribute_value'      => json_encode($request->likes),
            ]);
       }
        if(isset($request->dislikes) && is_array($request->dislikes)){
            UserAttributes::updateOrCreate([
                'user_id'   => $this->id,
                'attribute_key'      => 'dislikes'
            ],[
                'user_id'            => $this->id,
                'attribute_key'      => 'dislikes',
                'attribute_value'      =>json_encode( $request->dislikes),
            ]);
        }
        if(isset($request->movies) && is_array($request->movies)){
            UserAttributes::updateOrCreate([
                'user_id'   => $this->id,
                'attribute_key'      => 'movies'
            ],[
                'user_id'            => $this->id,
                'attribute_key'      => 'movies',
                'attribute_value'      =>json_encode( $request->movies),
            ]);
        }
        if(isset($request->hobbies) && is_array($request->hobbies)){
            UserAttributes::updateOrCreate([
                'user_id'   => $this->id,
                'attribute_key'      => 'hobbies'
            ],[
                'user_id'            => $this->id,
                'attribute_key'      => 'hobbies',
                'attribute_value'      =>json_encode( $request->hobbies),
            ]);
        }
        if(isset($request->music) && is_array($request->music)){
            UserAttributes::updateOrCreate([
                'user_id'   => $this->id,
                'attribute_key'      => 'music'
            ],[
                'user_id'            => $this->id,
                'attribute_key'      => 'music',
                'attribute_value'      =>json_encode( $request->music),
            ]);
        }
        if(isset($request->books) && is_array($request->books)){
            UserAttributes::updateOrCreate([
                'user_id'   => $this->id,
                'attribute_key'      => 'books'
            ],[
                'user_id'            => $this->id,
                'attribute_key'      => 'books',
                'attribute_value'      =>json_encode( $request->books),
            ]);
        }
        if(isset($request->tv_shows) && is_array($request->tv_shows)){
            UserAttributes::updateOrCreate([
                'user_id'   => $this->id,
                'attribute_key'      => 'tv_shows'
            ],[
                'user_id'            => $this->id,
                'attribute_key'      => 'tv_shows',
                'attribute_value'      =>json_encode( $request->tv_shows),
            ]);
        }
        if(isset($request->ethnicity_preferences) && is_array($request->ethnicity_preferences)){
            UserAttributes::updateOrCreate([
                'user_id'   => $this->id,
                'attribute_key'      => 'ethnicity_preferences'
            ],[
                'user_id'            => $this->id,
                'attribute_key'      => 'ethnicity_preferences',
                'attribute_value'      =>json_encode( $request->ethnicity_preferences),
            ]);
        }
        return $this;
    }



    public function uploadMedia($file,$type){

        $name = time().'.'.$file->getClientOriginalExtension();
        $destinationPath = public_path('/uploads');
        // $destinationPath= public_path(). '/uploads/';
        $file->move($destinationPath, $name);
        // $fullPath = $destinationPath.$name;
        // dd($fullPath);
        if($type=='profile_video') $this->profile_video = $name;
        if($type=='profile_picture') $this->profile_picture = $name;
        // if($type=='profile_picture') $this->profile_picture = $fullPath;
        return $this;
    }
}
