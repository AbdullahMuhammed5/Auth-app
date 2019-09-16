<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webpatser\Countries\Countries;

class CountriesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        // Empty the countries table
        DB::table(\Config::get('countries.table_name'))->delete();

        //Get all of the countries
        $countries = (new Countries())->getList();
        foreach ($countries as $countryId => $country){
            DB::table(\Config::get('countries.table_name'))->insert(array(
                'id' => $countryId,
                'capital' => ((isset($country['capital'])) ? $country['capital'] : null),
                'full_name' => ((isset($country['full_name'])) ? $country['full_name'] : null),
                'name' => $country['name'],
            ));
        }
    }
}
