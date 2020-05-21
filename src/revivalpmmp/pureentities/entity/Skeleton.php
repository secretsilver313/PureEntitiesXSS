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

use pocketmine\entity\projectile\ProjectileSource;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\Player;
use revivalpmmp\pureentities\components\MobEquipment;
use revivalpmmp\pureentities\features\IntfCanEquip;

// use pocketmine\event\Timings;

class Skeleton extends MonsterPEX implements IntfCanEquip, ProjectileSource{
	const NETWORK_ID = self::SKELETON;

	/**
	 * @var MobEquipment
	 */
	protected $mobEquipment;

	protected $pickUpLoot = [];

	public function initEntity() : void{
		$this->mobEquipment = new MobEquipment($this);
		$this->mobEquipment->init();
		if($this->mobEquipment->getMainHand() === null){
			$this->equipDefaultMainHand();
		}
	}

	protected function sendSpawnPacket(Player $player) : void {
		parent::sendSpawnPacket($player);
		$this->mobEquipment->sendEquipmentUpdate($player);
	}

	public function getName() : string{
		return "Skeleton";
	}

	public function getDrops() : array{
		$drops = [];
		$drops[] = Item::get(Item::ARROW, 0, mt_rand(0, 2));
		$drops[] = Item::get(Item::BONE, 0, mt_rand(0, 2));
		return $drops;
	}

	public function getMaxHealth() : int{
		return 20;
	}

	public function getMobEquipment() : MobEquipment{
		return $this->mobEquipment;
	}

	public function getPickupLoot() : array{
		return $this->pickUpLoot;
	}

	protected function equipDefaultMainHand() : void{
		$this->mobEquipment->setMainHand(ItemFactory::get(Item::BOW));
	}
}
