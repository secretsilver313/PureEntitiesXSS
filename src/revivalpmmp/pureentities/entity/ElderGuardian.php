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


use pocketmine\item\Item;
use pocketmine\item\ItemFactory;

class ElderGuardian extends MonsterPEX{

	const NETWORK_ID = self::ELDER_GUARDIAN;

	public function getName() : string{
		return "ElderGuardian";
	}

	public function updateXpDropAmount() : void{
		$this->xpDropAmount = 10;
	}

	public function getDrops() : array{
		$drops = [ItemFactory::get(Item::PRISMARINE_SHARD, 0, (mt_rand(0,2)))];
		$drops[] = ItemFactory::get(Item::SPONGE, 1);
		$chance = mt_rand(1,6);
		if($chance < 4){
			$drops[] = ItemFactory::get(Item::RAW_FISH);
		}
		if($chance > 3 && $chance < 6){
			$drops[] = ItemFactory::get(Item::PRISMARINE_CRYSTALS);
		}
		//TODO: Implement chance for other fish drops.
		return $drops;
	}
}
