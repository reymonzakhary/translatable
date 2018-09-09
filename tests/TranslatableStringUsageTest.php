<?php

use Upon\Translatable\Models\Translation;

class TranslatableStringUsageTest extends TestCase
{

    protected $product;

    public function setUp()
    {
        parent::setUp();

        $this->product = \ProductStub::create([
            'title' => 'a product is added'
        ]);

    }

    /** @test */
    public function can_we_translate_product()
    {
        $this->assertCount(1,  Translation::get());
    }

    /** @test */
    public function can_we_update_translated_product()
    {
        $this->assertCount(1,  Translation::get());
    }

}
