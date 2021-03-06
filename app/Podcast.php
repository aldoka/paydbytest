<?php

namespace App;

use App\Scopes\PodcastScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Podcast
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string $name
 * @property string $description
 * @property string|null $marketing_url
 * @property string $feed_url
 * @property string|null $image
 * @property int $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[] $comments
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Podcast whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Podcast whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Podcast whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Podcast whereFeedUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Podcast whereMarketingUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Podcast whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Podcast whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Podcast whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Podcast whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Podcast whereUpdatedAt($value)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Podcast onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Podcast withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Podcast withoutTrashed()
 * @mixin \Eloquent
 */
class Podcast extends Model
{

    use SoftDeletes;

    /** @var bool  */
    public $timestamps = true;

    /** @var array */
    protected $fillable = ['name', 'description', 'marketing_url', 'feed_url', 'image', 'status', 'created_at', 'updated_at', 'deleted_at'];
    /** @var array  */
    protected $hidden = ['deleted_at'];

    /** @var int  */
    const STATUS_REVIEW = 0;
    /** @var int  */
    const STATUS_PUBLISHED = 1;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Comment');
    }


    /**
     * @return array
     */
    public static function getAllStatuses() : array
    {
        return [
            self::STATUS_REVIEW,
            self::STATUS_PUBLISHED,
        ];
    }


    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        $publishedScope = new PodcastScope;
        static::addGlobalScope($publishedScope);
    }


}