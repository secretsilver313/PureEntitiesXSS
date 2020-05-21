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

class Salmon extends WaterAnimalPEX{
	const NETWORK_ID = Data::NETWORK_IDS["salmon"];

	public function initEntity() : void{
		parent::initEntity();
	}

	public function getName() : string{
		return "Salmon";
	}

	public function getMaxHealth() : int{
		return 3;
	}

	public function getDrops() : array{
		$drops = [];
		$drops[] = ItemFactory::get(Item::RAW_SALMON);
		if(mt_rand(1,4) === 1){
			$drops[] = ItemFactory::get(Item::BONE, 0, mt_rand(1,2)); //TODO: Vary based on size.
		}
		return $drops;
	}
}
