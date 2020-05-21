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
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\nbt\tag\CompoundTag;
use revivalpmmp\pureentities\components\MobEquipment;
use revivalpmmp\pureentities\data\Data;
use revivalpmmp\pureentities\data\NBTConst;
use revivalpmmp\pureentities\PluginConfiguration;
use revivalpmmp\pureentities\traits\Breedable;
use revivalpmmp\pureentities\traits\Feedable;

//use pocketmine\event\Timings;

class ZombiePigman extends Zombie{

	// TODO Update Methods to be Zombie Pigman Specific

	use Breedable, Feedable;
	const NETWORK_ID = self::ZOMBIE_PIGMAN;

	/**
	 * @var int
	 */
	private $angryValue = 0;

	/**
	 * Not a complete list yet ...
	 *
	 * @var array
	 */
	private $pickUpLoot = [];

	public function initEntity() : void{
		parent::initEntity();

		if($this->mobEquipment->getMainHand() === null){
			$this->mobEquipment->setMainHand(ItemFactory::get(Item::GOLD_SWORD));
		}

		$this->feedableItems = [];
	}

	/**
	 * Loads data from NBT and stores to local variables
	 */
	public function loadFromNBT(CompoundTag $nbt) : void{
		if(PluginConfiguration::getInstance()->getEnableNBT()){
			parent::loadFromNBT();
			if($this->namedtag->hasTag(NBTConst::NBT_KEY_ANGRY)){
				$angry = $this->namedtag->getInt(NBTConst::NBT_KEY_ANGRY, 0, true);
				$this->setAngry($angry);
			}
		}
	}

	/**
	 * Saves important variables to the NBT
	 */
	public function saveNBT() : void{
		if(PluginConfiguration::getInstance()->getEnableNBT()){
			parent::saveNBT();
			$this->namedtag->setInt(NBTConst::NBT_KEY_ANGRY, $this->angryValue, true);
		}
		$this->breedableClass->saveNBT();
	}

	/**
	 * @return bool
	 */
	public function isAngry() : bool{
		return $this->angryValue > 0;
	}

	/**
	 * @param int  $val
	 * @param bool $init
	 */
	public function setAngry(int $val, bool $init = false){
		if($val < 0){
			$val = 0;
		}
		$valueBefore = $this->angryValue;
		$this->angryValue = $val;
		// only change the data property when aggression mode changes or in init phase
		if(($valueBefore > 0 and $val <= 0) or ($valueBefore <= 0 and $val > 0) or $init){
			$this->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_ANGRY, $val > 0);
		}
	}

	public function getName() : string{
		return "ZombiePigman";
	}

	public function getDrops() : array{
		$drops[] = Item::get(Item::ROTTEN_FLESH, 0, mt_rand(0, 2));
		// 2.5 percent chance of dropping one of these items.
		if(mt_rand(1, 1000) < 26){
			$drops[] = Item::get(Item::GOLD_INGOT, 0, 1);
		}

		return $drops;
	}

	public function getMaxHealth() : int{
		return 20;
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
