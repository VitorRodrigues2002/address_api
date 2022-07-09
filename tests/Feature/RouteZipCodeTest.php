<?php

use App\Models\ZipCode;

class RouteZipCodeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRouteZipCode()
    {
        $zipcode = ZipCode::factory()->create();

        $results = $this->call('GET', 'api/zip-code/' . $zipcode->number . '-' . $zipcode->extension);

        $this->assertResponseOk();
        $this->assertTrue($results['data'][0]['id']            == $zipcode->id);
        $this->assertTrue($results['data'][0]['district_id']   == $zipcode->district_id);
        $this->assertTrue($results['data'][0]['county_id']     == $zipcode->county_id);
        $this->assertTrue($results['data'][0]['code_locality'] == $zipcode->code_locality);
        $this->assertTrue($results['data'][0]['name_locality'] == $zipcode->name_locality);
        $this->assertTrue($results['data'][0]['code_arteria']  == $zipcode->code_arteria);
        $this->assertTrue($results['data'][0]['type_arteria']  == $zipcode->type_arteria);
        $this->assertTrue($results['data'][0]['prep1']         == $zipcode->prep1);
        $this->assertTrue($results['data'][0]['title_arteria'] == $zipcode->title_arteria);
        $this->assertTrue($results['data'][0]['prep2']         == $zipcode->prep2);
        $this->assertTrue($results['data'][0]['name_arteria']  == $zipcode->name_arteria);
        $this->assertTrue($results['data'][0]['local_arteria'] == $zipcode->local_arteria);
        $this->assertTrue($results['data'][0]['change']        == $zipcode->change);
        $this->assertTrue($results['data'][0]['door']          == $zipcode->door);
        $this->assertTrue($results['data'][0]['client']        == $zipcode->client);
        $this->assertTrue($results['data'][0]['number']        == $zipcode->number);
        $this->assertTrue($results['data'][0]['extension']     == $zipcode->extension);
        $this->assertTrue($results['data'][0]['desig_postal']  == $zipcode->desig_postal);

        $this->assertTrue($results['data'][0]['county']['id']            == $zipcode->county->id);
        $this->assertTrue($results['data'][0]['county']['code_district'] == $zipcode->county->code_district);
        $this->assertTrue($results['data'][0]['county']['code']          == $zipcode->county->code);
        $this->assertTrue($results['data'][0]['county']['name']          == $zipcode->county->name);

        $this->assertTrue($results['data'][0]['district']['id']   == $zipcode->district->id);
        $this->assertTrue($results['data'][0]['district']['code'] == $zipcode->district->code);
        $this->assertTrue($results['data'][0]['district']['name'] == $zipcode->district->name);
    }
}
