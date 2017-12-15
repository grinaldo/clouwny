<?php
namespace App\Model\Translation;

use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Model\BaseModel;

abstract class TranslateModel extends BaseModel
{
    protected $translateRelation = [];

    protected $translateField = [];

    protected $translateAttributes = [];

    public function langs()
    {
        $foreignKey = $this->getTranslateForeignKey();
        $localKey = $this->getKeyName();

        $instance = new LangModel;
        $instance->setTable($this->getTranslateTable());

        return new HasMany($instance->newQuery(), $this, $instance->getTable().'.'.$foreignKey, $localKey);
    }

    public function setAttribute($key, $value)
    {
        if (isAcceptLang($key) && is_array($value)) {
            $this->addTranslateAttribute($key, $value);
            return;
        }

        if (in_array($key, $this->translateField)) {
            $lang = \App::getLocale();

            $this->addTranslateAttribute($lang, [$key => $value]);
            return;
        }

        return parent::setAttribute($key, $value);
    }

    public function addTranslateAttribute($lang, $value)
    {
        if (isset($this->translateAttributes[$lang])) {
            $value = array_merge($this->translateAttributes[$lang], $value);
        }
        $this->translateAttributes[$lang] = array_only($value, $this->translateField);
    }

    public function getAttribute($key)
    {
        if (in_array($key, $this->translateField)) {
            return $this->getTranslateAttribute($key);
        }

        if (isAcceptLang($key)) {
            return $this->getTranslateLangAttribute($key);
        }

        return parent::getAttribute($key);
    }

    public function getTranslateAttribute($key, $lang = null)
    {
        if (is_null($lang)) {
            $lang = app()->getLocale();
        }

        if (isset($this->translateAttributes[$lang])) {
            if (isset($this->translateAttributes[$lang][$key])) {
                return $this->translateAttributes[$lang][$key];
            }
        }
        $langModels = $this->langs->where('lang', $lang);
        if ($langModels->count() === 0) {
            $localValue = $this->getAttributeFromArray($key);
            if (empty($localValue)) {
                return null;
            }
            return $localValue;
        }
        return $langModels->first()->$key;
    }

    public function getTranslateLangAttribute($lang)
    {
        $langs = $this->langs->where('lang', $lang);
        if ($langs->count() === 0) {
            return null;
        }
        return $langs->first();
    }

    public function getTranslateField()
    {
        return $this->translateField;
    }

    public function getQualifiedTranslateFields()
    {
        return array_map(function ($string) {
            return "{$this->getTranslateTable()}.$string as translate_$string";
        }, $this->getTranslateField());
    }

    public function isFillable($key)
    {
        return isAcceptLang($key) || parent::isFillable($key);
    }

    protected function fillableFromArray(array $attributes)
    {
        if (count($this->fillable) > 0 && !static::$unguarded) {
            $fillable = array_merge($this->fillable, array_keys(suitLangs()));
            return array_intersect_key($attributes, array_flip($fillable));
        }

        return $attributes;
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new TranslateScope);
        static::saved(function ($model) {
            $model->saveTranslate();
        });
    }

    public function saveTranslate()
    {
        foreach ($this->translateAttributes as $lang => $attributes) {
            $data = $this->langs()->lang($lang)->first();
            if (is_null($data)) {
                $data = $this->langs()->getRelated();
            }
            $this->adjustLangModel($data);
            $data->setTable($this->getTranslateTable());
            $data->lang = $lang;
            $data->{$this->getTranslateForeignKey()} = $this->getKey();
            $data->fill($attributes);

            if ($data->isDirty()) {
                $this->updateTimestamps();
            }

            $data->save();
        }
    }

    protected function adjustLangModel($model)
    {
        $model->setForeignKey($this->getTranslateForeignKey());
        return $model;
    }

    public function getTranslateTable()
    {
        if (!isset($this->translateRelation[0])) {
            return $this->getTable().'_translate';
        }
        return $this->translateRelation[0];
    }

    public function getTranslateForeignKey()
    {
        if (!isset($this->translateRelation[1])) {
            return $this->getForeignKey();
        }
        return $this->translateRelation[1];
    }

    public function attributesToArray()
    {
        $translateAttributes = [];

        foreach ($this->translateField as $field) {
            $translateAttributes[$field] = $this->getAttribute($field);
        }

        $translateAttributes = $this->getArrayableItems($translateAttributes);

        return array_merge(parent::attributesToArray(), $translateAttributes);
    }

    public function relationsToArray()
    {
        $attributes = parent::relationsToArray();

        unset($attributes['langs']);
        return $attributes;
    }

    public function __isset($key)
    {

        return $this->langs->where('lang', $key)->count() || parent::__isset($key);
    }
}
