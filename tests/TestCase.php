<?php

use Upon\Translatable\Providers\TranslatableServiceProvider;


abstract class TestCase extends Orchestra\Testbench\TestCase
{

    protected function getPackageProviders($app)
    {
        return [
            TranslatableServiceProvider::class
        ];
    }

    public function setUp()
    {
        parent::setUp();

        Eloquent::unguard();

        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--path' => realpath(__DIR__.'/../../migrations'),
        ]);
    }

    public function tearDown()
    {
        \Schema::drop('products');
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');

        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => ''
        ]);

        \Schema::create('products', function($table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });
    }


}
