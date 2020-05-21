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

namespace revivalpmmp\pureentities\entity;

use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\Item;
use pocketmine\level\Level;
use revivalpmmp\pureentities\data\Data;
use revivalpmmp\pureentities\PureEntities;
use revivalpmmp\pureentities\utils\MobDamageCalculator;

//use pocketmine\event\Timings;

class Witch extends MonsterPEX{

	const NETWORK_ID = self::WITCH;

	public function getName() : string{
		return "Witch";
	}

	public function getDrops() : array{
		$drops = [];
		// 2.5 percent chance of dropping one of these items.
		if(mt_rand(1, 1000) % 25 == 0){
			switch(mt_rand(1, 3)){
				case 1:
					$drops[] = Item::get(Item::GLASS_BOTTLE, 0, 1);
					break;
				case 2:
					$drops[] = Item::get(Item::GLOWSTONE_DUST, 0, 1);
					break;
				case 3:
					$drops[] = Item::get(Item::GUNPOWDER, 0, 1);
					break;
				case 4:
					$drops[] = Item::get(Item::REDSTONE, 0, 1);
					break;
				case 5:
					$drops[] = Item::get(Item::SPIDER_EYE, 0, 1);
					break;
				case 6:
					$drops[] = Item::get(Item::SUGAR, 0, 1);
					break;
				case 7:
					$drops[] = Item::get(Item::STICK, 0, 1);
					break;
			}
		}
		return $drops;
	}

	public function getMaxHealth() : int{
		return 20;
	}

}
