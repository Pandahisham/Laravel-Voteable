<?php

namespace DraperStudio\Voteable\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Vote.
 */
class Vote extends Model
{
    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @return mixed
     */
    public function voteable()
    {
        return $this->morphTo();
    }

    /**
     * @param Model $voteable
     *
     * @return mixed
     */
    public static function sum(Model $voteable)
    {
        return $voteable->votes()
                        ->sum('value');
    }

    /**
     * @param Model $voteable
     *
     * @return mixed
     */
    public static function count(Model $voteable)
    {
        return $voteable->votes()
                        ->count();
    }

    /**
     * @param Model $voteable
     *
     * @return mixed
     */
    public static function countUps(Model $voteable)
    {
        return $voteable->votes()
                        ->where('value', 1)
                        ->count();
    }

    /**
     * @param Model $voteable
     *
     * @return mixed
     */
    public static function countDowns(Model $voteable)
    {
        return $voteable->votes()
                        ->where('value', -1)
                        ->count();
    }

    /**
     * @param Model $voteable
     * @param $from
     * @param null $to
     *
     * @return mixed
     */
    public static function countByDate(Model $voteable, $from, $to = null)
    {
        $query = $voteable->votes();

        if (!empty($to)) {
            $range = [new Carbon($from), new Carbon($to)];
        } else {
            $range = [
                (new Carbon($from))->startOfDay(),
                (new Carbon($to))->endOfDay(),
            ];
        }

        return $query->whereBetween('created_at', $range)
                     ->count();
    }

    /**
     * @param Model $voteable
     *
     * @return mixed
     */
    public static function up(Model $voteable)
    {
        return (new static())->cast($voteable, 1);
    }

    /**
     * @param Model $voteable
     *
     * @return mixed
     */
    public static function down(Model $voteable)
    {
        return (new static())->cast($voteable, -1);
    }

    /**
     * @param $value
     */
    public function setValueAttribute($value)
    {
        $this->attributes['value'] = ($value == -1) ? -1 : 1;
    }

    /**
     * @param Model $voteable
     * @param int   $value
     *
     * @return bool
     */
    protected function cast(Model $voteable, $value = 1)
    {
        if (!$voteable->exists) {
            return false;
        }

        $vote = new static();
        $vote->value = $value;

        return $vote->voteable()
                    ->associate($voteable)
                    ->save();
    }
}
