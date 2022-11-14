<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    // protected $table = 'users';
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;
    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['full_name', 'created_diff'];

    public function GetFullNameAttribute(){
        return $this->name . ' ' . $this->email;
    }

    public function GetCreatedDiffAttribute(){
        // $now = Carbon::now();
        // $created = new Carbon($this->created_at);
        return $this->created_at->diffForHumans();
        // return ($created->diff($now)->days < 1) ? 'Today' : $created->diffForHumans($now);
    }

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

}
