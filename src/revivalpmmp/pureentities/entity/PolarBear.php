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

class PolarBear extends MonsterPEX{

	const NETWORK_ID = self::POLAR_BEAR;

	public function getName() : string{
		return "PolarBear";
	}

	public function getDrops() : array{
		$drops = [];
		if(mt_rand(0, 3) > 0){
			$drops[] = Item::get(Item::RAW_FISH, 0, mt_rand(0, 2));
		}else{
			$drops[] = Item::get(Item::RAW_SALMON, 0, mt_rand(0, 2));
		}
		return $drops;
	}

	public function getMaxHealth() : int{
		return 30;
	}


}
