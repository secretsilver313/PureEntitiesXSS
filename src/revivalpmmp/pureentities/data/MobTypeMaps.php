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

class MobTypeMaps{
	const PASSIVE_DRY_MOBS = [
		EntityIds::BAT,
		EntityIds::CHICKEN,
		EntityIds::COW,
		EntityIds::DONKEY,
		EntityIds::HORSE,
		EntityIds::LLAMA,
		EntityIds::MOOSHROOM,
		EntityIds::MULE,
		EntityIds::OCELOT,
		EntityIds::PARROT,
		EntityIds::PIG,
		EntityIds::RABBIT,
		EntityIds::SHEEP
	];

	const PASSIVE_WET_MOBS = [
		EntityIds::COD,
		EntityIds::DOLPHIN,
		EntityIds::PUFFERFISH,
		EntityIds::SALMON,
		EntityIds::SQUID,
		EntityIds::TROPICAL_FISH
	];

	const OVERWORLD_HOSTILE_MOBS = [
		EntityIds::CAVE_SPIDER,
		EntityIds::CREEPER,
		EntityIds::ENDERMAN,
		EntityIds::GUARDIAN,
		EntityIds::HUSK,
		EntityIds::POLAR_BEAR,
		EntityIds::SKELETON,
		EntityIds::SLIME,
		EntityIds::SPIDER,
		EntityIds::STRAY,
		EntityIds::WITCH,
		EntityIds::WOLF,
		EntityIds::ZOMBIE
	];

	const NETHER_HOSTILE_MOBS = [
		EntityIds::BLAZE,
		EntityIds::ENDERMAN,
		EntityIds::GHAST,
		EntityIds::MAGMA_CUBE,
		EntityIds::SKELETON,
		EntityIds::WITHER_SKELETON,
		EntityIds::ZOMBIE_PIGMAN
	];
}