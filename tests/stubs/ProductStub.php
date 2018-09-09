<?php


use Illuminate\Database\Eloquent\Model;
use Upon\Translatable\Traits\TranslatableTrait;

class ProductStub extends Model
{
    use TranslatableTrait;

    protected $translatable = ['title'];

    protected $connection = 'testbench';

    public $table = 'products';
}
