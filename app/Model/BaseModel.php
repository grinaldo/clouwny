<?php

namespace App\Model;

use App\Model\Builder;
use App\Model\Extension\AttachableTrait;
use App\Model\Translation\TranslateModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Schema;

abstract class BaseModel extends Model
{
    /**
     * Key used for SEO in url. This attribute must be unique.
     * @var string
     */
    protected $urlKey = 'id';

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    // protected $dateFormat = Carbon::ISO8601;

    /**
     * Get value used for SEO in url
     * @return string
     */
    public function getUrlKey()
    {
        return $this->getAttribute($this->getUrlKeyName());
    }

    /**
     * {@inheritdoc}
     */
    public function getRouteKeyName()
    {
        return $this->getUrlKeyName();
    }


    /**
     * Get field name which is used in getUrlKey() to get the value
     * @return string
     */
    public function getUrlKeyName()
    {
        return $this->urlKey;
    }

    /**
     * Get field name used for SQL query. This method will add table name as the prefix.
     * @return string
     */
    public function getQualifiedUrlKeyName()
    {
        return sprintf("%s.%s", $this->getTable(), $this->getUrlKeyName());
    }

    /**
     * Scope to obtain random data from database.
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  integer $num  number of data
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRandom($query, $num = null)
    {
        $query = $query->orderBy(\DB::raw('RAND()'));
        if (!is_null($num)) {
            return $query->take($num);
        }
        return $query;
    }

    /**
     * Scope to sort data by its created_at field
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNewestCreated($query)
    {
        return $query->orderBy('created_at', 'DESC');
    }

    public function scopeMostUpdated($query)
    {
        return $query->orderBy('updated_at', 'DESC');
    }

    public function scopeFilter($query, $search, $orders, array $scopes = [])
    {
        $joins = [];
        $query->select(["{$this->getTable()}.*"]);
        foreach ($orders as $key => $order) {
            $splits = explode('.', $key);
            $qualifiedKey = $this->getQualifiedColumn($key);
            if (count($splits) >= 2) {
                $relation = $splits[0];
                $column = $splits[1];
                $related = $this->$relation()->getRelated();

                if (!in_array($column, $related->getColumnListing())) {
                    continue;
                }

                if (!isset($joins[$relation])) {
                    $query = $this->joinRelatedQuery($query, $relation);
                    $joins[$relation] = true;
                }

                $qualifiedKey = $this->getQualifiedRelationColumn($relation, $column);
            } else {
                if (!in_array($key, $this->getColumnListing())) {
                    continue;
                }
            }
            $query->orderBy($qualifiedKey, $order);
        }

        if (!empty($search)) {
            $fields = $this->getSearchField();
            $query->whereNested(function ($nestedQuery) use ($fields, $search, $query, $joins) {
                foreach ($fields as $field) {
                    $splits = explode('.', $field);
                    $field = $this->getQualifiedColumn($field);
                    if (count($splits) >= 2) {
                        $relation = $splits[0];
                        $column = $splits[1];
                        $related = $this->$relation()->getRelated();
                        if (!isset($joins[$relation])) {
                            $query = $this->joinRelatedQuery($query, $relation);
                            $joins[$relation] = true;
                        }
                        $field = $this->getQualifiedRelationColumn($relation, $column);
                    }
                    $nestedQuery->orWhere($field, 'LIKE', "%$search%");
                }
            });
        }

        $query = $this->filterWhereQuery($query, $scopes);
        return $query;
    }

    protected function joinRelatedQuery($query, $relation)
    {
        $related = $this->$relation()->getRelated();
        $foreignKey = $this->$relation()->getForeignKey();
        $query->join(
            "{$related->getTable()} as $relation",
            "{$this->getTable()}.{$foreignKey}",
            '=',
            "{$relation}.{$related->getKeyName()}",
            "left"
        );

        if ($related instanceof TranslateModel) {
            $translateTableAlias = "{$relation}_translate";
            $translateQualifiedForeign = "{$translateTableAlias}.{$related->getTranslateForeignKey()}";
            $query->join(
                "{$related->getTranslateTable()} as {$translateTableAlias}",
                "{$relation}.{$related->getKeyName()}",
                '=',
                $translateQualifiedForeign,
                'left'
            )->whereNested(function ($query) use ($related, $foreignKey, $translateTableAlias) {
                $query->where("{$translateTableAlias}.lang", \App::getLocale())
                      ->orWhereNull("{$this->getTable()}.{$foreignKey}");
            });
        }

        return $query;
    }

    protected function filterWhereQuery($query, array $scopes)
    {
        $columnNames = static::getColumnListing();
        foreach ($scopes as $field => $value) {
            if (method_exists($this, "scope$field")) {
                $query->$field($value);
            } else {
                if (!in_array($field, $columnNames)) {
                    continue;
                }
                if (empty($value)) {
                    $query->whereNested(function ($query) use ($field, $value) {
                        $query->where($field, $value)->orWhereNull($field);
                    });
                } else {
                    $validOperators = ['=', '<>', '>', '>=', '<=', 'LIKE%%', 'LIKE%', 'LIKE_%', '!NULL'];
                    $splitValues = explode('|', $value);
                    $operator = $splitValues[0];
                    if (count($splitValues) == 1 && !in_array($operator, $validOperators)) {
                        $query->where($field, $value);
                    } else {
                        unset($splitValues[0]);
                        $value = implode('|', $splitValues);
                        switch ($operator) {
                            case 'LIKE%%':
                                $query->where($field, 'LIKE', "%$value%");
                                break;
                            case 'LIKE%':
                                $query->where($field, 'LIKE', "%$value");
                                break;
                            case 'LIKE_%':
                                $query->where($field, 'LIKE', "$value%");
                                break;
                            case '!NULL':
                                $query->whereNotNull($field);
                                break;
                            default:
                                $query->where($field, $operator, $value);
                        }
                    }
                }
            }
        }
        return $query;
    }

    protected function getQualifiedColumn($column)
    {
        $table = $this->getTable();
        if ($this instanceof TranslateModel && in_array($column, $this->getTranslateField())) {
            $table = $this->getTranslateTable();
        }
        return "{$table}.{$column}";
    }

    protected function getQualifiedRelationColumn($relation, $column)
    {
        $related = $this->$relation()->getRelated();
        $relatedTable = $relation;
        if ($related instanceof TranslateModel && in_array($column, $related->getTranslateField())) {
            $relatedTable .= '_translate';
        }
        return "{$relatedTable}.{$column}";
    }

    protected function getSearchField($default = [])
    {
        if (isset($this->searchField)) {
            return $this->searchField;
        }
        return $default;
    }

    /**
     * @{inheritdoc}
     */
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    public function setVisibleForDetail()
    {
        $this->visible = null;
    }

    public static function getColumnListing()
    {
        $instance = new static;
        $table = $instance->getTable();
        $fields = Schema::getColumnListing($table);

        if ($instance instanceof TranslateModel) {
            $fields = array_merge($fields, $instance->getTranslateField());
        }
        return $fields;
    }

    public function asDateTime($value)
    {
        if (preg_match('/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/', $value)) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $value);
        }
        return parent::asDateTime($value);
    }

    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();

        if (method_exists($this, 'getAttachableFields')) {
            foreach ($this->getAttachableFields() as $field => $options) {
                if (!isset($attributes[$field])) {
                    continue;
                }
                $attributes[$field] = $this->getAttachment($field);
                if (is_string($attributes["{$field}_info"])) {
                    $attributes["{$field}_info"] = $this->fromJson($attributes["{$field}_info"]);
                }
                if (isset($options['thumb'])) {
                    foreach (array_keys($options['thumb']) as $key) {
                        $attributes["{$field}_{$key}"] = $this->getThumbnail($field, $key);
                    }
                }
            }
        }
        return $attributes;
    }
}
