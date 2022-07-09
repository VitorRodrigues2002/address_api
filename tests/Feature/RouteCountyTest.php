<?php

use App\Models\County;

class RouteCountyTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRouteCounty()
    {
        $county = County::factory()->create();

        $results = $this->call('GET', 'api/county/' . $county->id);

        $this->assertResponseOk();
        $this->assertTrue($results['data']['id']            == $county->id);
        $this->assertTrue($results['data']['code_district'] == $county->code_district);
        $this->assertTrue($results['data']['code']          == $county->code);
        $this->assertTrue($results['data']['name']          == $county->name);
    }
}
