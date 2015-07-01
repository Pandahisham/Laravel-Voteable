<?php

namespace DraperStudio\Voteable\Traits;

use DraperStudio\Voteable\Models\Vote;

/**
 * Class Voteable.
 */
trait Voteable
{
    /**
     * @return mixed
     */
    public function votes()
    {
        return $this->morphMany(Vote::class, 'voteable');
    }
}
