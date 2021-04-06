<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Direction;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

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
    
    public function placement()
    {
        return $this->belongsTo(User::class, 'placement_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(User::class, 'placement_id', 'id');
    }

    public function orderByChildren()
    {
        return $this->children()->orderBy('direction')->get();
    }

    public function left()
    {
        return $this->children()->where(['direction' => Direction::Left])->first();
        // return $this->children()->where('direction', 0);
    }

    public function middle()
    {
        return $this->children()->where(['direction' => Direction::Middle])->first();
    }

    public function right()
    {
        return $this->children()->where(['direction' => Direction::Right])->first();
    }

    public function sponsor()
    {
        return $this->belongsTo(User::class, 'sponsor_id', 'id');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'sponsor_id', 'id');
    }


    // Count User
    public function countUser($user)
    {
        if (!$user) return 0;
        return 1 + $this->countUser($user->left()) + $this->countUser($user->middle()) + $this->countUser($user->right());
    }

    public function countLeft()
    {
        return $this->countUser($this->left());
    }

    public function countMiddle()
    {
        return $this->countUser($this->middle());
    }

    public function countRight()
    {
        return $this->countUser($this->right());
    }

    /**
     * The userInfo hasOne that belong to the user.
     */
    public function userInfo()
    {
        return $this->hasOne(UserInfo::class);
    }

    /**
     * The incomeBalance hasOne that belong to the user.
     */
    public function incomeBalance()
    {
        return $this->hasOne(IncomeBalance::class);
    }

    /**
     * The shopBalance hasOne that belong to the user.
     */
    public function shopBalance()
    {
        return $this->hasOne(ShopBalance::class);
    }

    /**
     * The videos that belong to the user.
     */
    public function videos()
    {
        return $this->belongsToMany(Video::class);
    }

    /**
     * Get the sponsorIncomes for the user.
     */
    public function sponsorIncomes()
    {
        return $this->hasMany(SponsorIncome::class);
    }

    /**
     * Get the generationIncomes for the user.
     */
    public function generationIncomes()
    {
        return $this->hasMany(GenerationIncome::class);
    }

    /**
     * Get the levelIncomes for the user.
     */
    public function levelIncomes()
    {
        return $this->hasMany(LevelIncome::class);
    }

    /**
     * Get the shareIncomes for the user.
     */
    public function shareIncomes()
    {
        return $this->hasMany(ShareIncome::class);
    }

    /**
     * Get the withdraws for the user.
     */
    public function withdraws()
    {
        return $this->hasMany(Withdraw::class);
    }

    /**
     * Get the money_exchanges for the user.
     */
    public function money_exchanges()
    {
        return $this->hasMany(MoneyExchange::class);
    }

    /**
     * Get the contacts for the user.
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Get the chats for the user.
     */
    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    /**
     * Get the chats for the user.
     */
    public function staff_chats()
    {
        return $this->hasMany(Chat::class, 'staff_id', 'id');
    }

    /**
     * Get the site income for the user.
     */
    public function siteIncomes()
    {
        return $this->hasMany(SiteIncome::class);
    }

    /**
     * Get the sendShopBalances for the user.
     */
    public function sendShopBalances()
    {
        return $this->hasMany(SendShopBalance::class);
    }

    /**
     * Get the parentSendShopBalances for the user.
     */
    public function parentSendShopBalances()
    {
        return $this->hasMany(SendShopBalance::class, 'parent_id');
    }

    
}
