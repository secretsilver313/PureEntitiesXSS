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
use pocketmine\level\sound\PopSound;
use revivalpmmp\pureentities\traits\component\Ageable;
use revivalpmmp\pureentities\traits\component\Breedable;
use revivalpmmp\pureentities\traits\intf\IntfAgeable;
use revivalpmmp\pureentities\traits\intf\IntfBreedable;

class Chicken extends AnimalPEX implements IntfAgeable, IntfBreedable {
	use Ageable, Breedable;

	const NETWORK_ID = self::CHICKEN;

	// egg laying specific configuration (an egg is laid by a chicken each 6000-120000 ticks)
	const DROP_EGG_DELAY_MIN = 6000;
	const DROP_EGG_DELAY_MAX = 12000;
	private $dropEggTimer = 0;
	private $dropEggTime = 0;

	public function initEntity() : void{
		parent::initEntity();
		$this->eyeHeight = 0.6;
		$this->gravity = 0.08;

		$this->feedableItems = array(
			Item::WHEAT_SEEDS,
			Item::PUMPKIN_SEEDS,
			Item::MELON_SEEDS,
			Item::BEETROOT_SEEDS);
	}

	public function getName() : string{
		return "Chicken";
	}


	public function getDrops() : array{
		$drops = [];
		// only adult chickens drop something ...
		if($this->breedableClass !== null && !$this->breedableClass->isBaby()){
			$drops[] = Item::get(Item::FEATHER, 0, mt_rand(0, 2));
			if($this->isOnFire()){
				$drops[] = Item::get(Item::COOKED_CHICKEN, 0, 1);
			}else{
				$drops[] = Item::get(Item::RAW_CHICKEN, 0, 1);
			}
		}
		return $drops;
	}

	public function getMaxHealth() : int{
		return 4;
	}


	// ----- functionality to lay an eg ... -------------
	public function entityBaseTick(int $tickDiff = 1) : bool{
		if($this->dropEggTime === 0){
			$this->dropEggTime = mt_rand(self::DROP_EGG_DELAY_MIN, self::DROP_EGG_DELAY_MAX);
		}

		if($this->dropEggTimer >= $this->dropEggTime){ // drop an egg!
			$this->layEgg();
		}else{
			$this->dropEggTimer += $tickDiff;
		}

		parent::entityBaseTick($tickDiff);
		return true;
	}

	private function layEgg(){
		$item = Item::get(Item::EGG, 0, 1);
		$this->getLevel()->dropItem($this, $item);
		$this->getLevel()->addSound(new PopSound($this), $this->getViewers());

		$this->dropEggTimer = 0;
		$this->dropEggTime = 0;
	}

	public function updateXpDropAmount() : void{
		parent::updateXpDropAmount();
		if($this->breedableClass->isBaby()){
			$this->xpDropAmount = 0;
		}
	}


}
