<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Services\Key;
/**
 * App\Models\UserKey
 *
 * @property int $id
 * @property int|null $key_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Key|null $key
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey isEmailVerified()
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey isKeyStateActive()
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey isStateActive()
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey whereEmail($email)
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey whereInEmails($emails)
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey whereInKeyIDs($key_ids)
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey whereInUserIDs($user_ids)
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey whereKey($key)
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey whereKeyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey whereKeyName($key_name)
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey whereKeyStateID($state_id)
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey whereLikeKeyName($key_name)
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey whereNotKeyID($key_id)
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey whereNotUserID($user_id)
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey whereStateID($state_id)
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey whereKeyOwner($user)
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey whereKeyOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey whereKeyOwnerName($user_name)
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey withoutTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey isKeyOwnerEmailVerified()
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey isKeyOwnerStateActive()
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey whereInKeyOwnerEmails($emails)
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey whereInKeyOwnerIDs($user_ids)
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey whereNotKeyOwnerID($user_id)
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey whereKeyOwnerEmail($email)
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey whereKeyOwnerID($user_id)
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey whereKeyOwnerStateID($state_id)
 * @method static \Illuminate\Database\Eloquent\Builder|UserKey whereUserId($value)
 * @mixin \Eloquent
 */
class UserKey extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'user_keys';

    protected $fillable = ['key_id', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
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

    public function scopeWhereInKeyOwnerIDs($query, $user_ids)
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

    public function key(): BelongsTo
    {
        return $this->belongsTo(Key::class, 'key_id');
    }

    public function scopeWhereKey($query, $key)
    {
        return $query->when($key != false, function ($query) use ($key) {
            $query->whereHas('key', function ($query) use ($key) {
                $query->where('keys.id', $key->id);
            });
        });
    }

    public function scopeWhereKeyID($query, $key_id)
    {
        return $query->when($key_id != false, function ($query) use ($key_id) {
            $query->whereHas('key', function ($query) use ($key_id) {
                $query->where('keys.id', $key_id);
            });
        });
    }

    public function scopeWhereNotKeyID($query, $key_id)
    {
        return $query->when($key_id != false, function ($query) use ($key_id) {
            $query->whereHas('keys', function ($query) use ($key_id) {
                $query->where('keys.id', '!=', $key_id);
            });
        });
    }

    public function scopeWhereInKeyIDs($query, $key_ids)
    {
        return $query->when($key_ids != false, function ($query) use ($key_ids) {
            $query->whereHas('key', function ($query) use ($key_ids) {
                $query->where('keys.id', $key_ids);
            });
        });
    }

    public function scopeWhereKeyName($query, $key_name)
    {
        return $query->when($key_name != false, function ($query) use ($key_name) {
            $query->whereHas('key', function ($query) use ($key_name) {
                $query->where('keys.name', $key_name);
            });
        });
    }

    public function scopeWhereLikeKeyName($query, $key_name)
    {
        return $query->when($key_name != false, function ($query) use ($key_name) {
            $query->whereHas('key', function ($query) use ($key_name) {
                $query->whereLike(['keys.name'], $key_name);
            });
        });
    }

    public function scopeIsKeyStateActive($query)
    {
        return $query->whereHas('key', function ($query) {
            $query->where('keys.state', '!=', 0);
        });
    }

    public function scopeWhereKeyStateID($query, $state_id)
    {
        return $query->when($state_id != false, function ($query) use ($state_id) {
            $query->whereHas('keys', function ($query) use ($state_id) {
                $query->where('keys.state', $state_id);
            });
        });
    }
}
