<?php

namespace App\Models\Services;

use App\Models\User\User;
use App\Models\User\UserKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Services\Key
 *
 * @property int $id
 * @property string $name
 * @property string $key
 * @property int $state
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Services\KeyIpAddressRestriction> $ip_addresses
 * @property-read int|null $ip_addresses_count
 * @property-read User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Services\KeyWebsiteRestriction> $websites
 * @property-read int|null $websites_count
 * @method static \Illuminate\Database\Eloquent\Builder|Key isEmailVerified()
 * @method static \Illuminate\Database\Eloquent\Builder|Key isStateActive()
 * @method static \Illuminate\Database\Eloquent\Builder|Key newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Key newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Key onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Key query()
 * @method static \Illuminate\Database\Eloquent\Builder|Key search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereEmail($email)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereInEmails($emails)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereInUserIDs($user_ids)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereIpAddress($ip_address)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereKeyID($key_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereKeyKey($key)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereKeyName($name)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereLikeKey($key)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereLikeKeyName($name)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereNotKeyID($key_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereNotUserID($user_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereRedirectLink($redirect_link)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereStateID($state_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereKeyOwner($user)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereKeyOwnerID($user_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereKeyOwnerName($user_name)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereWebsite($website)
 * @method static \Illuminate\Database\Eloquent\Builder|Key withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Key withoutTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereIpAddressID($ip_address_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereWebsiteID($website_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Key isKeyOwnerEmailVerified()
 * @method static \Illuminate\Database\Eloquent\Builder|Key isKeyOwnerStateActive()
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereInKeyOwnerDs($user_ids)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereInKeyOwnerEmails($emails)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereKeyOwnerEmail($email)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereKeyOwnerStateID($state_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Key whereNotKeyOwnerID($user_id)
 * @mixin \Eloquent
 */
class Key extends Model
{
    protected $table = 'keys';

    protected $fillable = ['name', 'key', 'state'];

    use HasFactory;
    use SoftDeletes;

    public function scopeSearch($query, $search)
    {
        return $query->when($search != false, function ($query) use ($search) {
            $query->whereLikeKeyName($search)->whereLikeKey($search);
        });
    }

    public function scopeWhereKey($query, $key)
    {
        return $query->when($key != false, function ($query) use ($key) {
            $query->where('id', $key->id);
        });
    }

    public function scopeWhereKeyID($query, $key_id)
    {
        return $query->when($key_id != false, function ($query) use ($key_id) {
            $query->where('id', $key_id);
        });
    }

    public function scopeWhereNotKeyID($query, $key_id)
    {
        return $query->when($key_id != false, function ($query) use ($key_id) {
            $query->where('id', '!=', $key_id);
        });
    }

    public function scopeWhereLikeKeyName($query, $name)
    {
        return $query->when($name != false, function ($query) use ($name) {
            $query->whereLike(['name'], $name);
        });
    }

    public function scopeWhereKeyName($query, $name)
    {
        return $query->when($name != false, function ($query) use ($name) {
            $query->where('name', $name);
        });
    }

    public function scopeWhereLikeKey($query, $key)
    {
        return $query->when($key != false, function ($query) use ($key) {
            $query->whereLike(['key'], $key);
        });
    }

    public function scopeWhereKeyKey($query, $key)
    {
        return $query->when($key != false, function ($query) use ($key) {
            $query->where('key', $key);
        });
    }

    public function websites(): HasMany
    {
        return $this->hasMany(KeyWebsiteRestriction::class, 'key_id');
    }

    public function scopeWhereWebsite($query, $website)
    {
        return $query->when($website != false, function ($query) use ($website) {
            $query->whereHas('websites', function ($query) use ($website) {
                $query->where('key_website_restrictions.website', $website);
            });
        });
    }

    public function scopeWhereWebsiteID($query, $website_id)
    {
        return $query->when($website_id != false, function ($query) use ($website_id) {
            $query->whereHas('websites', function ($query) use ($website_id) {
                $query->where('key_website_restrictions.id', $website_id);
            });
        });
    }

    public function scopeWhereRedirectLink($query, $redirect_link)
    {
        return $query->when($redirect_link != false, function ($query) use ($redirect_link) {
            $query->whereHas('websites', function ($query) use ($redirect_link) {
                $query->where('key_website_restrictions.redirect_link', $redirect_link);
            });
        });
    }

    public function ip_addresses(): HasMany
    {
        return $this->hasMany(KeyIpAddressRestriction::class, 'key_id');
    }

    public function scopeWhereIpAddress($query, $ip_address)
    {
        return $query->when($ip_address != false, function ($query) use ($ip_address) {
            $query->whereHas('ip_addresses', function ($query) use ($ip_address) {
                $query->where('key_ip_address_restrictions.ip_address', $ip_address);
            });
        });
    }
    
    public function scopeWhereIpAddressID($query, $ip_address_id)
    {
        return $query->when($ip_address_id != false, function ($query) use ($ip_address_id) {
            $query->whereHas('ip_addresses', function ($query) use ($ip_address_id) {
                $query->where('key_ip_address_restrictions.id', $ip_address_id);
            });
        });
    }

    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, UserKey::class, 'key_id', 'id', 'id', 'user_id');
    }

    public function scopeWhereKeyOwner($query, $user)
    {
        return $query->when($user != false, function ($query) use ($user) {
            $query->whereHas('user', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            });
        });
    }

    public function scopeWhereNotKeyOwnerID($query, $user_id)
    {
        return $query->when($user_id != false, function ($query) use ($user_id) {
            $query->whereHas('user', function ($query) use ($user_id) {
                $query->where('users.id', '!=', $user_id);
            });
        });
    }

    public function scopeWhereKeyOwnerID($query, $user_id)
    {
        return $query->when($user_id != false, function ($query) use ($user_id) {
            $query->whereHas('user', function ($query) use ($user_id) {
                $query->where('users.id', $user_id);
            });
        });
    }

    public function scopeWhereInKeyOwnerDs($query, $user_ids)
    {
        return $query->when($user_ids != false, function ($query) use ($user_ids) {
            $query->whereHas('user', function ($query) use ($user_ids) {
                $query->whereIn('users.id', $user_ids);
            });
        });
    }

    public function scopeWhereKeyOwnerName($query, $user_name)
    {
        return $query->when($user_name != false, function ($query) use ($user_name) {
            $query->whereHas('user', function ($query) use ($user_name) {
                $query->whereLike(['users.given_name', 'users.middle_name', 'users.family_name'], $user_name);
            });
        });
    }

    public function scopeWhereKeyOwnerEmail($query, $email)
    {
        return $query->when($email != false, function ($query) use ($email) {
            $query->whereHas('user', function ($query) use ($email) {
                $query->where('users.email', $email);
            });
        });
    }

    public function scopeWhereInKeyOwnerEmails($query, $emails)
    {
        return $query->when($emails != false, function ($query) use ($emails) {
            $query->whereHas('user', function ($query) use ($emails) {
                $query->whereIn('users.email', $emails);
            });
        });
    }

    public function scopeIsKeyOwnerStateActive($query)
    {
        return $query->whereHas('user', function ($query) {
            $query->where('users.state', '!=', 0);
        });
    }

    public function scopeWhereKeyOwnerStateID($query, $state_id)
    {
        return $query->when($state_id != false, function ($query) use ($state_id) {
            $query->whereHas('user', function ($query) use ($state_id) {
                $query->where('users.state', $state_id);
            });
        });
    }

    public function scopeIsKeyOwnerEmailVerified($query)
    {
        return $query->whereHas('user', function ($query) {
            $query->where('users.email_verified', '!=', 0);
        });
    }
}
