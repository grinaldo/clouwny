<?php
namespace App\Model\Translation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class LangModel extends Model
{
    public $timestamps = false;

    protected $foreignKey = 'model_id';

    protected static $unguarded = true;

    public function scopeLang($query, $lang)
    {
        return $query->whereLang($lang);
    }

    public function setForeignKey($key)
    {
        $this->foreignKey = $key;
    }

    protected function setKeysForSaveQuery(Builder $query)
    {
        $query->where('lang', '=', $this->getOriginal('lang'));
        $query->where($this->foreignKey, '=', $this->getOriginal($this->foreignKey));
        return $query;
    }
}
