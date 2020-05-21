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
use pocketmine\nbt\tag\CompoundTag;
use revivalpmmp\pureentities\components\BreedingComponent;
use revivalpmmp\pureentities\features\IntfCanBreed;
use revivalpmmp\pureentities\features\IntfCanPanic;
use revivalpmmp\pureentities\PluginConfiguration;
use revivalpmmp\pureentities\traits\Breedable;
use revivalpmmp\pureentities\traits\CanPanic;
use revivalpmmp\pureentities\traits\Feedable;

class Cow extends AnimalPEX implements IntfCanBreed, IntfCanPanic{

	use Breedable, CanPanic, Feedable;
	const NETWORK_ID = self::COW;

	public function initEntity() : void{
		parent::initEntity();
		$this->eyeHeight = 1;

		$this->feedableItems = array(Item::WHEAT);

		$this->breedableClass = new BreedingComponent($this);
		$this->breedableClass->init();

	}

	public function loadFromNBT(CompoundTag $nbt) : void{
		$this->breedableClass->loadFromNBT();
	}

	public function saveNBT() : void{
		$this->breedableClass->saveNBT();
	}

	public function getName() : string{
		return "Cow";
	}

	public function getDrops() : array{
		$drops = [];
		$drops[] = Item::get(Item::LEATHER, 0, mt_rand(0, 2));
		if($this->isOnFire()){
			$drops[] = Item::get(Item::COOKED_BEEF, 0, mt_rand(1, 3));
		}else{
			$drops[] = Item::get(Item::RAW_BEEF, 0, mt_rand(1, 3));
		}
		return $drops;
	}

	public function getMaxHealth() : int{
		return 10;
	}

	public function updateXpDropAmount() : void{
		parent::updateXpDropAmount();
		if($this->breedableClass->isBaby()){
			$this->xpDropAmount = 0;
		}
	}
}


