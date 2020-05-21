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
use revivalpmmp\pureentities\data\Data;

class Guardian extends MonsterPEX{

	// TODO: Implement Guardian Specific Methods

	const NETWORK_ID = Data::NETWORK_IDS["guardian"];

	public function getName() : string{
		return "Guardian";
	}

	public function getDrops() : array{
		$drops = [ItemFactory::get(Item::PRISMARINE_SHARD, 0, mt_rand(0,2))];
		$chance = mt_rand(1,10);
		if($chance < 5){
			$drops[] = ItemFactory::get(Item::FISH,0,mt_rand(0,1));
		}
		if($chance < 4 and $chance > 9){
			$drops[] = ItemFactory::get(Item::PRISMARINE_CRYSTALS,0,mt_rand(0,1));
		}
		return $drops;
	}

	public function updateXpDropAmount() : void{
		$this->xpDropAmount = 10;
	}
}
