<?php

namespace Core\Mail\Entity\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The hidden attributes
     *
     * @var array
     */
    protected $hidden = ['id', 'created_at', 'updated_at'];

    /**
     * The date attributes
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * Get ID
     *
     * @return int
     */
    public function getID() {
        return $this->id;
    }

    /**
     * Get created at
     *
     * @return string
     */
    public function getCreatedAt() {
        return $this->created_at;
    }

    /**
     * Get updated at
     *
     * @return string
     */
    public function getUpdatedAt() {
        return $this->updated_at;
    }

    /**
     * Parse field into format date
     *
     * @param string $field
     * @param string $format
     * @return string|null
     */
    public function formatDateTime($field, $format = null)
    {

        if ($date = $this->{$field}) {
            $format = $format ?: 'd/m/Y H:i:s';

            if ($date instanceof Carbon) {
                return $date->format($format);
            }

            return Carbon::parse(strtotime($date))->format($format);
        }

        return null;
    }

    /**
     * Return formatted date
     *
     * @param string $field
     * @param string $format
     * @return string|null
     */
    public function formatDate($field, $format = null)
    {
        return $this->formatDateTime($field, $format ?: 'd/m/Y');
    }
}
