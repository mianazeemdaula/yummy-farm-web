<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens;

    use SpatialTrait;

    protected $spatialFields = [
        'location',
    ];


    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'pivot'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getImageAttribute($value)
    {
        $avatar = '';
        if($value == null){
            $avatar = "https://ui-avatars.com/api/?name=".str_replace(' ','+',$this->name)."&size=250";
        }else if( strpos($value, 'http') !== false){
            $avatar = $value;
        }else{
            $avatar = asset($value);
        }
        return $avatar;
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notifications::class);
    }

   
    public function favorite()
    {
        return $this->belongsToMany('App\Models\User','favorite_sellers','customer_id', 'seller_id');
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('business_name', 'like', '%'.$search.'%')
                ->orWhere('username', 'like', '%'.$search.'%')
                ->orWhere('address_line_2', 'like', '%'.$search.'%');
    }

    public function products()
    {
        return $this->hasMany(Product::class,'seller_id');
    }

    public function tutorCountReviews()
    {
        return $this->hasOneThrough(Review::class, Lession::class,'tutor_id')->selectRaw('count(lession_id) as value')->groupBy('tutor_id');
    }

    public function tutorToughtHours()
    {
        return $this->hasOneThrough(LessionLogs::class, Lession::class,'tutor_id')->selectRaw("SUM(TIMESTAMPDIFF(MINUTE,start_time,end_time) / 60) as value")->groupBy('tutor_id');
    }

    public function libraries()
    {
        return $this->hasMany('App\Models\Library','student_id');
    }

    //
    public function studentReportTutor()
    {
        return $this->hasMany('App\Models\ReportTutor','student_id');
    }

    public function tutorReportStudent()
    {
        return $this->hasMany('App\Models\ReportTutor','tutor_id');
    }

    public function instrumentHistory()
    {
        return $this->belongsToMany('App\Models\Instrument','user_instrument_history','user_id','instrument_id')->withTimestamps();
    }

    public function instrumentFavorite()
    {
        return $this->belongsToMany('App\Models\Instrument','user_instrument_favorite','user_id','instrument_id')->withTimestamps();
    }

    public function tutorTimes()
    {
        return $this->hasMany('App\Models\TutorTime');
    }

    public function scopeWithAndWhereHas($query, $relation, $constraint){
        return $query->whereHas($relation, $constraint)
                     ->with([$relation => $constraint]);
    }
}
