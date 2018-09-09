<?php

namespace Upon\Translatable\Traits;

use Upon\Translatable\Models\Translation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

use \App;


trait TranslatableTrait
{

    public static function bootTranslatableTrait()
    {
        static::saved(function($model)
        {
            foreach($model->translatable as $key) {
                if(isset($model->translatable) && array_key_exists($key, $model->attributes)) {
                    (new self)->setTranslation($key,$model->attributes[$key], $model->attributes['id']);
                }
            }
        });
    }

    public function translation()
    {
        return $this->hasMany(\Rey\Translatable\Models\Translation::class, 'model_id');
    }



    public function trans($key,$locale)
    {
        return $this->getTranslation($key,$locale);
    }


    public function getTranslation( $key, $locale = NULL )
    {
        if(!$locale)
        {
            $locale = App::getLocale();
        }
        //model class, model id, locale code
        $translation = Translation::where("model_class",get_class($this))
                                    ->where("model_id",$this->id)
                                    ->where("key",$key)
                                    ->where("locale",$locale)->first();
        if(!$translation)
        {
            return parent::__get($key);
            //return $this->name->name;
        }
        else
        {
            if($translation->value === "" || $translation->value === NULL) {
                return parent::__get($key);
            }
            return $translation->value;
        }
    }

    /**
     * updated
     */
    public function setTranslation($key,$value,$id, $locale = NULL)
    {
        if(!$locale)
        {
            $locale = App::getLocale();
        }
        $translation = Translation::where("model_class",get_class($this))
                                    ->where("model_id",$id)
                                    ->where("key",$key)
                                    ->where("locale",$locale)->first();
        if(!$translation)
        {

            $translation = new Translation;
            $translation->model_class = get_class($this);
            $translation->model_id = $id;
            $translation->key = $key;
            $translation->locale = $locale;
            $translation->value = $value;
        }
        else
        {
            $translation->value = $value;
        }

        return $translation->save();
    }

    public function toJson($locale = NULL)
    {
        if(!$locale)
        {
            $locale = App::getLocale();
        }
        $array = parent::toArray($this);
        if(isset($this->translatable))
        {
            foreach($this->translatable as $value)
            {
                $array[$value] = $this->getTranslation($value,$locale);
            }
        }
        return json_encode($array);
    }

    public function toArray($locale = NULL)
    {
        if(!$locale)
        {
            $locale = App::getLocale();
        }
        $array = parent::toArray($this);
        if(isset($this->translatable))
        {
            foreach($this->translatable as $value)
            {

                $array[$value] = $this->getTranslation($value,$locale);
            }
        }
        return $array;
    }

    // public function scopeGet(Builder $query)
    // {
    //     return $this;
    // }

    public function scopeGetAll()
    {
        return \DB::select($this->praparQuery());
    }

    public function praparQuery()
    {
        $model = str_replace('\\', '\\\\\\', get_class($this));
        $locale = App::getLocale();
        $table = $this->getTable();
        $c = '';
        $i = 1;

        foreach($this->translatable as $val) {
            $c .= "CASE WHEN(SELECT `value` FROM translations WHERE `value` IS NOT NULL AND `value` != '' AND `locale`='$locale' AND `key`='$val' AND `model_id` = tr.id AND  `model_class` = '$model') IS NULL THEN tr.{$val} ELSE (SELECT `value` FROM translations WHERE `value` IS NOT NULL AND `value` != '' AND `locale`='$locale' AND `key`='$val' AND `model_id` = tr.id AND  `model_class` = '$model' ) END AS $val";
            if($i < count($this->translatable )) {
                $c .= ",";
            }
            $i++;
        }
        $query = "SELECT tr.*, $c FROM $table tr";

        return $query;
    }
}
