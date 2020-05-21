<?php

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

use pocketmine\entity\Creature;
use pocketmine\item\Item;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Player;
use revivalpmmp\pureentities\components\BreedingComponent;
use revivalpmmp\pureentities\data\Data;
use revivalpmmp\pureentities\data\NBTConst;
use revivalpmmp\pureentities\features\IntfCanBreed;
use revivalpmmp\pureentities\features\IntfCanInteract;
use revivalpmmp\pureentities\features\IntfCanPanic;
use revivalpmmp\pureentities\features\IntfTameable;
use revivalpmmp\pureentities\PluginConfiguration;
use revivalpmmp\pureentities\PureEntities;
use revivalpmmp\pureentities\traits\Breedable;
use revivalpmmp\pureentities\traits\CanPanic;
use revivalpmmp\pureentities\traits\Feedable;
use revivalpmmp\pureentities\traits\Tameable;


// TODO: Add 'Begging Mode' for untamed ocelots.
// TODO: Fix tamed ocelot response to Owner in combat (should avoid fights).
// TODO: Add trigger to tame() so that a failure to tame will trigger breeding mode.


class Ocelot extends AnimalPEX implements IntfTameable, IntfCanBreed, IntfCanPanic{
	use Breedable, CanPanic, Feedable, Tameable;
	const NETWORK_ID = Data::NETWORK_IDS["ocelot"];

	private $comfortObjects = array(
		Item::BED,
		Item::LIT_FURNACE,
		Item::BURNING_FURNACE,
		Item::CHEST
	);

	/**
	 * Teleport distance - when does a tamed wolf start to teleport to it's owner?
	 *
	 * @var int
	 */
	private $teleportDistance = 12;

	/**
	 * Tamed cats will explore around the player unless commanded to sit. This describes the
	 * max distance to the player.
	 *
	 * @var int
	 */
	private $followDistance = 10;

	private $catType = 0; // 0 = Wild Ocelot, 1 = Tuxedo, 2 = Tabby, 3 = Siamese

	public function getBeggingSpeed() : float{
		return 0.8;
	}

	public function initEntity() : void{
		parent::initEntity();

		$this->breedableClass = new BreedingComponent($this);

		$this->tameFoods = array(
			Item::RAW_FISH,
			Item::RAW_SALMON
		);

		$this->feedableItems = array(
			Item::RAW_FISH,
			Item::RAW_SALMON
		);

		if($this->isTamed()){
			$this->mapOwner();
			if($this->owner === null){
				PureEntities::logOutput("Ocelot($this): is tamed but player not online. Cannot set tamed owner. Will be set when player logs in ..", PureEntities::NORM);
			}
		}

		$this->breedableClass->init();

		$this->teleportDistance = PluginConfiguration::getInstance()->getTamedTeleportBlocks();
		$this->followDistance = PluginConfiguration::getInstance()->getTamedPlayerMaxDistance();
	}

	/**
	 * Returns an array of items that tamed cats are attracted too.
	 *
	 * @return array
	 */
	public function getComfortObjects(){
		return $this->comfortObjects;
	}


	public function getName() : string{
		return "Ocelot";
	}


	public function loadFromNBT(CompoundTag $nbt) : void{
		parent::loadFromNBT($nbt);
		if($this->namedtag->hasTag(NBTConst::NBT_KEY_CATTYPE)){
			$catType = $this->namedtag->getByte(NBTConst::NBT_KEY_CATTYPE, 0, true);
			$this->setCatType($catType);
		}
	}

	public function saveNBT() : void{
		if(PluginConfiguration::getInstance()->getEnableNBT()){
			parent::saveNBT();
			$this->namedtag->setByte(NBTConst::NBT_KEY_CATTYPE, $this->catType, true); // sets ocelot skin
			$this->breedableClass->saveNBT();
		}
	}

	public function getDrops() : array{
		return [];
	}

	public function getMaxHealth() : int{
		return 10;
	}

	private function onTameSuccess(Player $player){
		$this->setCatType(mt_rand(1, 3)); // Randomly chooses a tamed skin
	}

	private function onTameFail(Player $player){
		$this->getBreedingComponent()->feed($player);
	}

	/**
	 * Sets the skin type of the ocelot.
	 * 0 = Wild Ocelot, 1 = Tuxedo, 2 = Tabby, 3 = Siamese
	 *
	 * @param int $type
	 */
	public function setCatType(int $type = 0){
		$this->catType = $type;
		$this->getDataPropertyManager()->setPropertyValue(self::DATA_VARIANT, self::DATA_TYPE_INT, $type);
	}

	/**
	 * Returns which skin is set in catType
	 * 0 = Wild Ocelot, 1 = Tuxedo, 2 = Tabby, 3 = Siamese
	 *
	 * @return int
	 */
	public function getCatType() : int{
		return $this->catType;
	}

	public function updateXpDropAmount() : void{
		parent::updateXpDropAmount();
		if($this->breedableClass->isBaby()){
			$this->xpDropAmount = 0;
		}
	}

}
