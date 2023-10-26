<?php

namespace App\Models\Services;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Services\KeyWebsiteRestriction
 *
 * @property int $id
 * @property int $key_id
 * @property string $website
 * @property string|null $redirect_link
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Services\Key|null $key
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction query()
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction whereKeyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction whereKeyKey($key)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction whereKeyName($name)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction whereLikeKey($key)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction whereLikeKeyName($name)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction whereLikeRedirectLink($website)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction whereLikeWebsite($website)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction whereRedirectLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction withoutTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction whereWebsiteID($website_id)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction isKeyOwnerEmailVerified()
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction isKeyOwnerStateActive()
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction whereInKeyOwnerEmails($emails)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction whereInKeyOwnerIDs($user_ids)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction whereKeyOwner($user)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction whereKeyOwnerEmail($email)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction whereKeyOwnerID($user_id)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction whereKeyOwnerName($user_name)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction whereKeyOwnerStateID($state_id)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyWebsiteRestriction whereNotKeyOwnerID($user_id)
 * @mixin \Eloquent
 */
class KeyWebsiteRestriction extends Model
{
    protected $table = 'key_website_restrictions';

    protected $fillable = ['key_id', 'website', 'redirect_link'];

    use HasFactory;
    use SoftDeletes;

    public function scopeSearch($query, $search)
    {
        return $query->when($search != false, function ($query) use ($search) {
            $query->whereLikeWebsite($search)->whereLikeRedirectLink($search);
        });
    }

    public function scopeWhereLikeWebsite($query, $website)
    {
        return $query->when($website != false, function ($query) use ($website) {
            $query->whereLike(['website'], $website);
        });
    }

    public function scopeWhereWebsite($query, $website)
    {
        return $query->when($website != false, function ($query) use ($website) {
            $query->where('website', $website);
        });
    }

    public function scopeWhereWebsiteID($query, $website_id)
    {
        return $query->when($website_id != false, function ($query) use ($website_id) {
            $query->where('id', $website_id);
        });
    }
    
    public function scopeWhereRedirectLink($query, $redirect_link)
    {
        return $query->when($redirect_link != false, function ($query) use ($redirect_link) {
            $query->where('redirect_link', $redirect_link);
        });
    }

    public function scopeWhereLikeRedirectLink($query, $website)
    {
        return $query->when($website != false, function ($query) use ($website) {
            $query->whereLike(['redirect_link'], $website);
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
