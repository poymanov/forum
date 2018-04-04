<?php
/**
 * Created by PhpStorm.
 * User: poymanov
 * Date: 15.02.18
 * Time: 22:32.
 */

namespace App;

trait Favoritable
{
    protected static function bootFavoritable()
    {
        static::deleted(function ($model) {
            $model->favorites->each->delete();
        });
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];

        if (! $this->favorites()->where($attributes)->exists()) {
            Reputation::award($this->owner, Reputation::REPLY_WAS_FAVORITED);

            return $this->favorites()->create($attributes);
        }
    }

    public function unfavorite()
    {
        $attributes = ['user_id' => auth()->id()];

        $this->favorites()->where($attributes)->get()->each->delete();

        Reputation::reduce($this->owner, Reputation::REPLY_WAS_FAVORITED);
    }

    public function isFavorited()
    {
        return (bool) $this->favorites->where('user_id', auth()->id())->count();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }
}
