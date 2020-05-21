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
use pocketmine\item\ItemIds;
use pocketmine\Player;
use revivalpmmp\pureentities\components\BreedingComponent;
use revivalpmmp\pureentities\components\MobEquipment;
use revivalpmmp\pureentities\features\IntfCanBreed;
use revivalpmmp\pureentities\features\IntfCanEquip;
use revivalpmmp\pureentities\traits\Breedable;
use revivalpmmp\pureentities\traits\Feedable;

//use pocketmine\event\Timings;

class Zombie extends MonsterPEX implements IntfCanEquip, IntfCanBreed{


	use Breedable, Feedable;
	const NETWORK_ID = self::ZOMBIE;

	/**
	 * @var MobEquipment
	 */
	protected $mobEquipment;

	/**
	 * Not a complete list yet ...
	 *
	 * @var array
	 */
	private $pickUpLoot = [ItemIds::IRON_SWORD, ItemIds::IRON_SHOVEL];

	public function initEntity() : void{
		parent::initEntity();

		$this->mobEquipment = new MobEquipment($this);
		$this->mobEquipment->init();

		$this->feedableItems = [];

		$this->breedableClass = new BreedingComponent($this);
		$this->breedableClass->init();
	}

	/**
	 * Returns the appropriate NetworkID associated with this entity
	 * @return int
	 */
	public function getNetworkId(){
		return self::NETWORK_ID;
	}

	public function getName() : string{
		return "Zombie";
	}

	public function getDrops() : array{
		$drops = [];
		$drops[] = Item::get(Item::ROTTEN_FLESH, 0, mt_rand(0, 2));
		// 2.5 percent chance of dropping one of these items.
		if(mt_rand(1, 1000) % 25 == 0){
			switch(mt_rand(1, 3)){
				case 1:
					$drops[] = Item::get(Item::CARROT, 0, 1);
					break;
				case 2:
					$drops[] = Item::get(Item::POTATO, 0, 1);
					break;
				case 3:
					$drops[] = Item::get(Item::IRON_INGOT, 0, 1);
					break;
			}
		}
		return $drops;
	}

	public function getMaxHealth() : int{
		return 20;
	}

	public function updateXpDropAmount() : void{
		parent::updateXpDropAmount();
		if($this->breedableClass->isBaby()){
			$this->xpDropAmount = 12;
		}
	}

	protected function sendSpawnPacket(Player $player) : void {
		parent::sendSpawnPacket($player);
		$this->mobEquipment->sendEquipmentUpdate($player);
	}


	// -------------------- equipment methods --------------------

	/**
	 * @return MobEquipment
	 */
	public function getMobEquipment() : MobEquipment{
		return $this->mobEquipment;
	}

	/**
	 * @return array
	 */
	public function getPickupLoot() : array{
		return $this->pickUpLoot;
	}

}
