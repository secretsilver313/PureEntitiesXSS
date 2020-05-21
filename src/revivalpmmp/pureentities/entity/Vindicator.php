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
use revivalpmmp\pureentities\components\MobEquipment;

class Vindicator extends MonsterPEX{

	const NETWORK_ID = self::VINDICATOR;

	/**
	 * @var MobEquipment
	 */
	private $mobEquipment;

	public function initEntity() : void{
		parent::initEntity();

		$this->mobEquipment = new MobEquipment($this);
		$this->mobEquipment->init();
		if($this->mobEquipment->getMainHand() === null){
			$this->mobEquipment->setMainHand(ItemFactory::get(Item::IRON_AXE));
		}
	}

	public function getName() : string{
		return "Vindicator";
	}

	public function getDrops() : array{
		$drops = [ItemFactory::get(Item::EMERALD, 0, mt_rand(0,1))];
		if(mt_rand(1,1000) < 86){
			$drops[] = $this->mobEquipment->getMainHand();
		}
		return $drops;
	}

	public function getMaxHealth() : int{
		return 20;
	}

}
