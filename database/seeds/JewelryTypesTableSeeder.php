<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use OOD\JewelryType;

class JewelryTypesTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('jewelry_types')->delete();

		JewelryType::create(['description' => 'Bracelet']);
		JewelryType::create(['description' => 'Brooch']);
		JewelryType::create(['description' => 'Charms']);
		JewelryType::create(['description' => 'Earrings']);
		JewelryType::create(['description' => 'Necklace & Pendants']);
		JewelryType::create(['description' => 'Rings']);
		JewelryType::create(['description' => 'Wedding Bands']);
	}

}
