<?php

class ExampleTest extends FeatureTestCase
{
    function test_basic_example()
    {
        $user = factory(\App\User::class)->create([
          'name' => 'Bupo Juan',
          'email' => 'juanbupo@gmail.com'
        ]);

        $this->actingAs($user, 'api')
            ->visit('api/user')
            ->see('Bupo Juan')
            ->see('juanbupo@gmail.com');
    }
}
