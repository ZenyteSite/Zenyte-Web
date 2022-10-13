<?php

use App\Models\Category;
use App\Models\CreditPackage;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StoreSeeder extends Seeder
{

    private $faker = null;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = Faker::create();
        $categories = [
            'Weapons' => [
                'Abyssal Whip',
                'Saradomin Sword',
                'Zamorakian Spear',
                'Dark Bow',
                'Abyssal Dagger',
                'Abyssal Bludgeon',
                'Darklight',
                'Ancient Shard',
            ],
            'Armor' => [
                'Guthans Armour Set',
                'Veracs Armour Set',
                'Dharoks Armour Set',
                'Torags Armour Set',
                'Ahrims Armour Set',
                'Karils Armour Set',
                'Void Knight Equipment',
                'Elite Void Knight Equipment',
                'Dragon Defender',
                'Fighter Torso',
                'Fire Cape',
                'Seers Ring',
                'Archers Ring',
                'Warrior Ring',
                'Berserker Ring',
                'Tyrannical Ring',
                'Treasonous Ring',
                'Ring of the Gods',
                'Fighter Hat',
                'Ranger Hat',
                'Infinity Robe Set',
                'Tome of Fire',
                'Amulet of Fury',
                'Mages Book',
                'Runner Hat',
            ],
            'Supplies' => [
                'Saradomin Brew',
                'Super Restore',
                'Super Restore',
                'Cannonball',
                'Cannonball',
                'Super Combat Potion',
                'Super Combat Potion',
                'Cooked Karambwan',
                'Cooked Karambwan',
                'Anglerfish',
                'Anglerfish',
                'Anglerfish',
                'Stamina Potion',
                'Sea Turtle',
                'Sea Turtle',
                'Sea Turtle',
                'Sea Turtle',
            ],
            'Cosmetics' => [
                'Bunny Ears',
                'Santa Hat',
                'Black Santa Hat',
                'Inverted Santa Hat',
                'Partyhat Set',
                'Wise Old Mans Santa Hat',
                'Scythe',
                'Christmas Cracker',
                'Halloween Mask Set',
                'Black Halloween Mask',
                'Corrupted Armour Set',
                'Frozen Whip Mix',
                'Volcanic Whip Mix',
                'Blue dark bow paint',
                'Green dark bow paint',
                'Yellow dark bow paint',
                'White dark bow paint',
                'Granite clamp',
            ],
            'Pets' => [
                'Cute Creature',
                'Evil Creature',
                'Stray Dog',
                'Pet mystery box',
            ],
            'Misc' => [
                'Crystal Key',
                'Herb Sack',
                'Rune Pouch',
                'Gem Bag',
                'Imbued Heart',
                'Barrows teleport scroll',
                'Godwars teleport scroll',
                'Zulrah Teleport Scroll',
                'Kraken Teleport scroll',
                'Cerberus teleport scroll',
                'Burnt Page',
                'Ecumenical Key',
                'Mystery Box',
                'Dice bag',
                'Mithril Seeds',
                'Mithril Seeds',
                'Mithril Seeds',
                'Mithril Seeds',
                'Dagannoth Kings Teleport Scroll',
                'Dwarf Cannon Set',
                'Xerics Wisdom',
            ],
            'Bonds' => [
                '$10 Bond',
                '$50 Bond',
                '$100 Bond',
            ]
        ];
        foreach ($categories as $name => $products) {
            $categoryId = Category::create([
                'title' => $name
            ]);
            foreach ($products as $product) {
                $newProduct = new Product();
                $newProduct->item_name = $product;
                $newProduct->category_id = $categoryId->id;
                $newProduct->item_id = $this->faker->numberBetween(1, 20000);
                $newProduct->item_amount = $this->faker->numberBetween(1, 100);
                $newProduct->item_price = $this->faker->numberBetween(5, 300);
                $newProduct->item_discount = ($this->faker->boolean) ? $this->faker->numberBetween(5, 40) : 0;
                $newProduct->ironman = ($this->faker->boolean);
                $newProduct->description = $this->faker->paragraph;
                $newProduct->visible = 1;
                if ($name == 'Bonds') {
                    switch ($product) {
                        case "$10 Bond":
                            $newProduct->bond_amount = 10;
                            break;
                        case "$50 Bond":
                            $newProduct->bond_amount = 50;
                            break;
                        case "$100 Bond":
                            $newProduct->bond_amount = 100;
                            break;
                    }
                }
                $newProduct->save();
            }
        }

        $creditPackages = [
            50 => 5,
            100 => 10,
            250 => 25,
            500 => 50,
            1000 => 100,
            2500 => 250,
            5000 => 500,
            10000 => 1000,
        ];

        foreach($creditPackages as $amount => $price) {
            $newPackage = new CreditPackage();
            $newPackage->amount = $amount;
            $newPackage->bonus = ($this->faker->boolean) ? 0 : $this->faker->numberBetween(1, 100);
            $newPackage->holiday_bonus = ($this->faker->boolean) ? 0 : $this->faker->numberBetween(1, 100);
            $newPackage->discount = ($this->faker->boolean) ? 0 : $this->faker->numberBetween(10, 50);
            $newPackage->price = $price;
            $newPackage->image_url = 'store/credits/SJMMESi.png';
        }
    }
}
