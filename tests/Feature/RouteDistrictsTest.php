<?php

use App\Models\District;

class RouteDistrictsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRouteDistricts()
    {
        $district = District::factory()->create();

        $results = $this->call('GET', 'api/district/' . $district->id);

        $this->assertResponseOk();
        $this->assertTrue($results['data']['id']   == $district->id);
        $this->assertTrue($results['data']['code'] == $district->code);
        $this->assertTrue($results['data']['name'] == $district->name);
    }
}
