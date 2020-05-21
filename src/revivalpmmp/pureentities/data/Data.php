<?php
declare(strict_types=1);

/**
 * PureEntitiesX: Mob AI Plugin for PMMP
 * Copyright (C)  2018 RevivalPMMP
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace revivalpmmp\pureentities\data;


use pocketmine\entity\EntityIds;

interface Data{

	// Entity Network IDs
	const NETWORK_IDS = array(
		"bat" => 19,
		"blaze" => 43,
		"cave_spider" => 40,
		"chicken" => 10,
		"cod" => 112,
		"cow" => 11,
		"creeper" => 33,
		"dolphin" => 31,
		"donkey" => 24,
		"elder_guardian" => 50,
		"ender_charge" => 79,
		"ender_dragon" => 53,
		"enderman" => 38,
		"endermite" => 55,
		"evoker" => 104,
		"ghast" => 41,
		"guardian" => 49,
		"horse" => 23,
		"husk" => 47,
		"iron_golem" => 20,
		"large_fireball" => 85,
		"llama" => 29,
		"magma_cube" => 42,
		"mooshroom" => 16,
		"mule" => 25,
		"ocelot" => 22,
		"parrot" => 30,
		"pig" => 12,
		"pig_zombie" => 36,
		"polar_bear" => 28,
		"pufferfish" => 108,
		"rabbit" => 18,
		"salmon" => 109,
		"sheep" => 13,
		"shulker" => 54,
		"silverfish" => 39,
		"skeleton" => 34,
		"skeleton_horse" => 26,
		"slime" => 37,
		"small_fireball" => 94,
		"snow_golem" => 21,
		"spider" => 35,
		"squid" => 17,
		"stray" => 46,
		"tropicalfish" => 111,
		"vex" => 105,
		"villager" => 15,
		"vindicator" => 57,
		"witch" => 45,
		"wither_skeleton" => 48,
		"wither" => 52,
		"wolf" => 14,
		"zombie" => 32,
		"zombie_pigman" => 36,
		"zombie_villager" => 44
	);


	// Entity Widths
	const WIDTHS = array(

		EntityIds::BAT => 0.484,
		EntityIds::BLAZE => 1.25,
		EntityIds::CAVE_SPIDER => 1.438,
		EntityIds::CHICKEN => 1,
		EntityIds::COD => 0.5,
		EntityIds::COW => 1.5,
		EntityIds::CREEPER => 0.7,
		EntityIds::DONKEY => 1.2,
		EntityIds::DOLPHIN => 1.2,
		EntityIds::DRAGON_FIREBALL => 1.0,
		EntityIds::ELDER_GUARDIAN => 1.9975,
		EntityIds::ENDER_DRAGON => 2.5,
		EntityIds::ENDERMAN => 1.094,
		EntityIds::ENDERMITE => 0.4,
		EntityIds::EVOCATION_ILLAGER => 1.031,
		EntityIds::GHAST => 4.5,
		EntityIds::GUARDIAN => 0,
		EntityIds::HORSE => 1.3,
		EntityIds::HUSK => 1.031,
		EntityIds::IRON_GOLEM => 2.688,
		EntityIds::LARGE_FIREBALL => 0.5,
		EntityIds::LLAMA => 0.9,
		EntityIds::MAGMA_CUBE => 1.2,
		EntityIds::MOOSHROOM => 1.781,
		EntityIds::MULE => 1.2,
		EntityIds::OCELOT => 0.8,
		EntityIds::PARROT => 0.5,
		EntityIds::PIG => 1.5,
		EntityIds::POLAR_BEAR => 1.3,
		EntityIds::PUFFERFISH => 0.35,
		EntityIds::RABBIT => 0.4,
		EntityIds::SHEEP => 0.9,
		EntityIds::SHULKER => 1.0,
		EntityIds::SILVERFISH => 1.094,
		EntityIds::SKELETON => 0.875,
		EntityIds::SKELETON_HORSE => 1.3,
		EntityIds::SLIME => 1.2,
		EntityIds::SMALL_FIREBALL => 0.25,
		EntityIds::SNOW_GOLEM => 1.281,
		EntityIds::STRAY => 0.875,
		EntityIds::SPIDER => 2.062,
		EntityIds::SQUID => 0,
		EntityIds::TROPICALFISH => 0.5,
		EntityIds::VEX => 0.4,
		EntityIds::VILLAGER => 0.938,
		EntityIds::VINDICATOR => 0.6,
		EntityIds::WITCH => 0.6,
		EntityIds::WITHER => 0.9,
		EntityIds::WITHER_SKELETON => 0.875,
		EntityIds::WOLF => 1.2,
		EntityIds::ZOMBIE => 1.031,
		EntityIds::ZOMBIE_PIGMAN => 1.95,
		EntityIds::ZOMBIE_VILLAGER => 1.031
	);

	// Entity Heights
	const HEIGHTS = array(
		EntityIds::BAT => 0.5,
		EntityIds::BLAZE => 1.5,
		EntityIds::CAVE_SPIDER => 0.547,
		EntityIds::CHICKEN => 0.8,
		EntityIds::COD => 0.3,
		EntityIds::COW => 1.2,
		EntityIds::CREEPER => 1.7,
		EntityIds::DONKEY => 1.562,
		EntityIds::DOLPHIN => 1.562,
		EntityIds::ELDER_GUARDIAN => 1.9975,
		EntityIds::DRAGON_FIREBALL => 1.0,
		EntityIds::ENDER_DRAGON => 1.0,
		EntityIds::ENDERMAN => 2.875,
		EntityIds::ENDERMITE => 0.3,
		EntityIds::EVOCATION_ILLAGER => 2.125,
		EntityIds::GHAST => 4.5,
		EntityIds::GUARDIAN => 0,
		EntityIds::HORSE => 1.5,
		EntityIds::HUSK => 2.0,
		EntityIds::IRON_GOLEM => 1.625,
		EntityIds::LARGE_FIREBALL => 0.5,
		EntityIds::LLAMA => 1.87,
		EntityIds::MAGMA_CUBE => 1.2,
		EntityIds::MOOSHROOM => 1.875,
		EntityIds::MULE => 1.562,
		EntityIds::OCELOT => 0.8,
		EntityIds::PARROT => 0.9,
		EntityIds::PIG => 1.0,
		EntityIds::POLAR_BEAR => 1.4,
		EntityIds::PUFFERFISH => 0.35,
		EntityIds::RABBIT => 0.5,
		EntityIds::SHEEP => 1.3,
		EntityIds::SHULKER => 1.0,
		EntityIds::SILVERFISH => 0.438,
		EntityIds::SKELETON => 2.0,
		EntityIds::SKELETON_HORSE => 1.5,
		EntityIds::SLIME => 1.2,
		EntityIds::SMALL_FIREBALL => 0.25,
		EntityIds::SNOW_GOLEM => 1.875,
		EntityIds::STRAY => 2.0,
		EntityIds::SPIDER => 0.781,
		EntityIds::SQUID => 0.0,
		EntityIds::TROPICALFISH => 0.5,
		EntityIds::VEX => 0.8,
		EntityIds::VILLAGER => 2.0,
		EntityIds::VINDICATOR => 1.95,
		EntityIds::WITCH => 1.95,
		EntityIds::WITHER => 3.5,
		EntityIds::WITHER_SKELETON => 2.0,
		EntityIds::WOLF => 0.969,
		EntityIds::ZOMBIE => 2.01,
		EntityIds::ZOMBIE_PIGMAN => 0.6,
		EntityIds::ZOMBIE_VILLAGER => 2.125
	);

	// Contains biomes that each entity is allowed to
	// spawn into automatically.
	const ALLOWED_BIOMES_BY_ENTITY_NAME = array(
		"bat" => array(),
		"blaze" => 43,
		"cave_spider" => 40,
		"chicken" => 10,
		"cod" => 17,
		"cow" => 11,
		"creeper" => 33,
		"donkey" => 24,
		"dolphin" => 17,
		"elder_guardian" => 50,
		"enderman" => 38,
		"fire_ball" => 85,
		"ghast" => 41,
		"guardian" => 49,
		"horse" => 23,
		"husk" => 47,
		"iron_golem" => 20,
		"magma_cube" => 42,
		"mooshroom" => 16,
		"mule" => 25,
		"ocelot" => 22,
		"parrot" => 30,
		"pig" => 12,
		"pig_zombie" => 36,
		"pufferfish" => 17,
		"rabbit" => 18,
		"sheep" => 13,
		"silverfish" => 39,
		"skeleton" => 34,
		"slime" => 37,
		"snow_golem" => 21,
		"stray" => 46,
		"spider" => 35,
		"squid" => 17,
		"tropicalfish" => 17, 
		"villager" => 15,
		"wither_skeleton" => 48,
		"wolf" => 14,
		"zombie" => 32,
		"zombie_pigman" => 36,
		"zombie_villager" => 44
	);

}
