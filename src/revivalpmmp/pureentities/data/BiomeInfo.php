<?php
declare(strict_types=1);

/**
 * PureEntitiesX: Mob AI Plugin for PMMP
 * Copyright (C) 2018 RevivalPMMP
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
use pocketmine\level\biome\Biome;

class BiomeInfo{

	const ALLOWED_ENTITIES_BY_BIOME = [
		16 => [],                            // Beaches
		Biome::BIRCH_FOREST => [],
		28 => [],                            // Birch Forest Hills
		26 => [],                            // Cold Beach
		24 => [EntityIds::ELDER_GUARDIAN, EntityIds::GUARDIAN, EntityIds::SQUID],                            // Deep Ocean
		Biome::DESERT => [EntityIds::HUSK, EntityIds::RABBIT],
		17 => [EntityIds::HUSK, EntityIds::RABBIT],                            // Desert Hills
		34 => [],                            // Extreme Hills with Trees or Extreme Hills +
		Biome::FOREST => [EntityIds::WOLF],
		18 => [EntityIds::WOLF],                            // Forest Hills
		10 => [],                            // Frozen Ocean
		11 => [],                            // Frozen River
		Biome::HELL => [EntityIds::BLAZE, EntityIds::GHAST, EntityIds::MAGMA_CUBE, EntityIds::SKELETON, EntityIds::WITHER_SKELETON, EntityIds::ZOMBIE_PIGMAN],
		Biome::ICE_PLAINS => [EntityIds::RABBIT, EntityIds::POLAR_BEAR],            // Ice Flats
		13 => [EntityIds::RABBIT, EntityIds::POLAR_BEAR],                            // Ice Mountains
		21 => [EntityIds::OCELOT, EntityIds::PARROT],                            // Jungle
		23 => [EntityIds::OCELOT, EntityIds::PARROT],                            // Jungle Edge
		22 => [EntityIds::OCELOT, EntityIds::PARROT],                            // Jungle Hills
		37 => [],                            // Mesa
		38 => [],                            // Mesa Rock or Mesa Plateau F
		39 => [],                            // Mesa Clear Rock or Mesa Plateau
		Biome::MOUNTAINS => [EntityIds::LLAMA],            // Extreme Hills
		14 => [EntityIds::MOOSHROOM],                            // Mushroom Island
		15 => [EntityIds::MOOSHROOM],                            // Mushroom Island Shore
		Biome::OCEAN => [EntityIds::COD, EntityIds::DOLPHIN, EntityIds::PUFFERFISH, EntityIds::SALMON, EntityIds::SQUID, EntityIds::TROPICAL_FISH],
		Biome::PLAINS => [EntityIds::CHICKEN, EntityIds::COW, EntityIds::PIG, EntityIds::RABBIT, EntityIds::SHEEP],
		32 => [],                            // Redwood Taiga or Mega Taiga
		33 => [],                            // Redwood Taiga Hills or Mega Taiga Hills
		Biome::RIVER => [],
		29 => [],                            // Roofed Forest
		35 => [],                            // Savanna
		36 => [],                            // Savanna Rock or Savanna Plateau
		9 => [],                            // Sky or The End
		Biome::SMALL_MOUNTAINS => [EntityIds::COW, EntityIds::PIG, EntityIds::SHEEP, EntityIds::WOLF],        // Smaller Extreme Hills or Extreme Hills Edge
		25 => [],                            // Stone Beach
		Biome::SWAMP => [EntityIds::SLIME],
		Biome::TAIGA => [EntityIds::RABBIT, EntityIds::WOLF],
		30 => [],                            // Taiga Cold
		31 => [],                            // Taiga Cold Hills
		19 => [],                            // Taiga Hills
	];

	const OVERWORLD_BIOME_EXEMPT = [
		EntityIds::CREEPER,
		EntityIds::SKELETON,
		EntityIds::SPIDER,
		EntityIds::ZOMBIE
	];
}