<?php

namespace App\Models\Services;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Services\KeyIpAddressRestriction
 *
 * @property int $id
 * @property int $key_id
 * @property string $ip_address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Services\Key|null $key
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction query()
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction whereKeyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction whereKeyKey($key)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction whereKeyName($name)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction whereLikeIpAddress($ip_address)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction whereLikeKey($key)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction whereLikeKeyName($name)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction withoutTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction whereIpAddressID($ip_address_id)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction isKeyOwnerEmailVerified()
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction isKeyOwnerStateActive()
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction whereInKeyOwnerEmails($emails)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction whereInKeyOwnerIDs($user_ids)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction whereKeyOwner($user)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction whereKeyOwnerEmail($email)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction whereKeyOwnerID($user_id)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction whereKeyOwnerName($user_name)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction whereKeyOwnerStateID($state_id)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyIpAddressRestriction whereNotKeyOwnerID($user_id)
 * @mixin \Eloquent
 */
class KeyIpAddressRestriction extends Model
{
    protected $table = 'key_ip_address_restrictions';

    protected $fillable = ['key_id', 'ip_address'];

    use HasFactory;
    use SoftDeletes;

    public function scopeSearch($query, $search)
    {
        return $query->when($search != false, function ($query) use ($search) {
            $query->whereLikeIpAddress($search);
        });
    }

    public function scopeWhereLikeIpAddress($query, $ip_address)
    {
        return $query->when($ip_address != false, function ($query) use ($ip_address) {
            $query->whereLike(['ip_address'], $ip_address);
        });
    }

    public function scopeWhereIpAddress($query, $ip_address)
    {
        return $query->when($ip_address != false, function ($query) use ($ip_address) {
            $query->where('key_ip_address_restrictions.ip_address', $ip_address);
        });
    }

    public function scopeWhereIpAddressID($query, $ip_address_id)
    {
        return $query->when($ip_address_id != false, function ($query) use ($ip_address_id) {
            $query->where('key_ip_address_restrictions.id', $ip_address_id);
        });
    }

    public function key(): BelongsTo
    {
        return $this->belongsTo(Key::class);
    }

    public function scopeWhereLikeKeyName($query, $name)
    {
        return $query->when($name != false, function ($query) use ($name) {
            $query->whereHas('key', function ($query) use ($name) {
                $query->whereLike(['keys.name'], $name);
            });
        });
    }

    public function scopeWhereKeyName($query, $name)
    {
        return $query->when($name != false, function ($query) use ($name) {
            $query->whereHas('key', function ($query) use ($name) {
                $query->where('keys.name', $name);
            });
        });
    }

    public function scopeWhereLikeKey($query, $key)
    {
        return $query->when($key != false, function ($query) use ($key) {
            $query->whereHas('key', function ($query) use ($key) {
                $query->whereLike(['keys.key'], $key);
            });
        });
    }

    public function scopeWhereKeyKey($query, $key)
    {
        return $query->when($key != false, function ($query) use ($key) {
            $query->whereHas('key', function ($query) use ($key) {
                $query->where('keys.key', $key);
            });
        });
    }

    /** Key owner */
    public function scopeWhereKeyOwner($query, $user)
    {
        return $query->when($user != false, function ($query) use ($user) {
            $query->whereHas('key.user', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            });
        });
    }

    public function scopeWhereNotKeyOwnerID($query, $user_id)
    {
        return $query->when($user_id != false, function ($query) use ($user_id) {
            $query->whereHas('key.user', function ($query) use ($user_id) {
                $query->where('users.id', '!=', $user_id);
            });
        });
    }

    public function scopeWhereKeyOwnerID($query, $user_id)
    {
        return $query->when($user_id != false, function ($query) use ($user_id) {
            $query->whereHas('key.user', function ($query) use ($user_id) {
                $query->where('users.id', $user_id);
            });
        });
    }

    public function scopeWhereInKeyOwnerIDs($query, $user_ids)
    {
        return $query->when($user_ids != false, function ($query) use ($user_ids) {
            $query->whereHas('key.user', function ($query) use ($user_ids) {
                $query->whereIn('users.id', $user_ids);
            });
        });
    }

    public function scopeWhereKeyOwnerName($query, $user_name)
    {
        return $query->when($user_name != false, function ($query) use ($user_name) {
            $query->whereHas('key.user', function ($query) use ($user_name) {
                $query->whereLike(['users.given_name', 'users.middle_name', 'users.family_name'], $user_name);
            });
        });
    }

    public function scopeWhereKeyOwnerEmail($query, $email)
    {
        return $query->when($email != false, function ($query) use ($email) {
            $query->whereHas('key.user', function ($query) use ($email) {
                $query->where('users.email', $email);
            });
        });
    }

    public function scopeWhereInKeyOwnerEmails($query, $emails)
    {
        return $query->when($emails != false, function ($query) use ($emails) {
            $query->whereHas('key.user', function ($query) use ($emails) {
                $query->whereIn('users.email', $emails);
            });
        });
    }

    public function scopeIsKeyOwnerStateActive($query)
    {
        return $query->whereHas('key.user', function ($query) {
            $query->where('users.state', '!=', 0);
        });
    }

    public function scopeWhereKeyOwnerStateID($query, $state_id)
    {
        return $query->when($state_id != false, function ($query) use ($state_id) {
            $query->whereHas('key.user', function ($query) use ($state_id) {
                $query->where('users.state', $state_id);
            });
        });
    }

    public function scopeIsKeyOwnerEmailVerified($query)
    {
        return $query->whereHas('key.user', function ($query) {
            $query->where('users.email_verified', '!=', 0);
        });
    }
}
