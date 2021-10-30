<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens, HasRoles;
    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'clock_24', 'time_zone'
    ];

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

    protected $with = ['userable'];



    public function getImageAttribute($value)
    {
        $avatar = '';
        if($value == null){
            $avatar = "https://ui-avatars.com/api/?name=".$this->name."&size=250";
        }else if( strpos($value, 'http') !== false){
            $avatar = $value;
        }else{
            $avatar = asset($value);
        }
        return $avatar;
    }

    public function getTutor($id)
    {
        return $this->where('id',$id)->with(['instruments', 'languages', 'tutorVideos','tutorRating','tutorCountReviews', 'tutorToughtHours'])->first();
    }


    public function userable()
    {
        return $this->morphTo();
    }

    public function favouriteTutors()
    {
        return $this->belongsToMany('App\Models\User','favourite_tutor_users','student_id','tutor_id');
    }

    public function instruments()
    {
        return $this->belongsToMany('App\Models\Instrument',null,'tutor_id');
    }

    // public function instrumentCats()
    // {
    //     return $this->belongsToMany('App\Models\InstrumentCategory',null,'tutor_id');
    // }

    public function tutorVideos()
    {
        return $this->hasMany(TutorVideos::class, 'tutor_id', 'id');
    }

    public function languages()
    {
        return $this->belongsToMany('App\Models\Language',null,'tutor_id');
    }

    public function tutorLessions()
    {
        return $this->hasMany('App\Models\Lession','tutor_id');
    }

    public function activeStudents()
    {
        return $this->tutorLessions()->selectRaw('count(id) as value')->groupBy('tutor_id');
    }

    public function tutorRating()
    {
        return $this->hasOneThrough(Review::class, Lession::class,'tutor_id')->selectRaw('avg(rating) as value')->groupBy('tutor_id');
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
