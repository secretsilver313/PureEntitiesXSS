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
use pocketmine\nbt\tag\CompoundTag;
use revivalpmmp\pureentities\components\BreedingComponent;
use revivalpmmp\pureentities\data\Color;
use revivalpmmp\pureentities\data\NBTConst;
use revivalpmmp\pureentities\features\IntfCanBreed;
use revivalpmmp\pureentities\features\IntfTameable;
use revivalpmmp\pureentities\PluginConfiguration;
use revivalpmmp\pureentities\PureEntities;
use revivalpmmp\pureentities\traits\Breedable;
use revivalpmmp\pureentities\traits\Feedable;
use revivalpmmp\pureentities\traits\Tameable;

class Wolf extends MonsterPEX implements IntfTameable, IntfCanBreed{
	use Breedable, Feedable, Tameable;
	const NETWORK_ID = self::WOLF;

	/**
	 * Teleport distance - when does a tamed wolf start to teleport to it's owner?
	 *
	 * @var int
	 */
	private $teleportDistance = 12;

	/**
	 * Tamed wolves are walking aimlessly until they get too far away from the player. This describes the
	 * max distance to the player
	 *
	 * @var int
	 */
	private $followDistance = 10;

	private $angryValue = 0;

	private $collarColor = Color::RED;

	public function initEntity() : void{
		parent::initEntity();

		$this->breedableClass = new BreedingComponent($this);
		$this->breedableClass->init();

		$this->tameFoods = array(
			Item::BONE
		);
		$this->feedableItems = array(
			Item::RAW_BEEF,
			Item::RAW_CHICKEN,
			Item::RAW_MUTTON,
			Item::RAW_PORKCHOP,
			Item::RAW_RABBIT,
			Item::COOKED_BEEF,
			Item::COOKED_CHICKEN,
			Item::COOKED_MUTTON,
			Item::COOKED_PORKCHOP,
			Item::COOKED_RABBIT,
		);
		$this->setAngry($this->isAngry() ? $this->angryValue : 0, true);
		$this->setTamed($this->isTamed());
		if($this->isTamed()){
			$this->mapOwner();
			$this->setCollarColor($this->collarColor);
			if($this->owner === null){
				PureEntities::logOutput("Wolf($this): is tamed but player not online. Cannot set tamed owner. Will be set when player logs in ..", PureEntities::NORM);
			}
		}
		$this->breedableClass->init();

		$this->teleportDistance = PluginConfiguration::getInstance()->getTamedTeleportBlocks();
		$this->followDistance = PluginConfiguration::getInstance()->getTamedPlayerMaxDistance();
	}

	public function getName() : string{
		return "Wolf";
	}

	/**
	 * Loads data from NBT and stores to local variables
	 */
	public function loadFromNBT(CompoundTag $nbt) : void{
		if(PluginConfiguration::getInstance()->getEnableNBT()){
			parent::loadFromNBT($nbt);
			$this->loadTameNBT();
			if($this->namedtag->hasTag(NBTConst::NBT_KEY_ANGRY)){
				$angry = $this->namedtag->getInt(NBTConst::NBT_KEY_ANGRY, 0, true);
				$this->setAngry($angry);
			}
			if($this->namedtag->hasTag(NBTConst::NBT_KEY_COLLAR_COLOR)){
				$color = $this->namedtag->getByte(NBTConst::NBT_KEY_COLLAR_COLOR, Color::RED);
				$this->setCollarColor($color);
			}
		}
	}

	// TODO: Determine cause of collar color being improperly applied.

	/**
	 * Saves important variables to the NBT
	 */
	public function saveNBT() : void{
		if(PluginConfiguration::getInstance()->getEnableNBT()){
			parent::saveNBT();
			$this->saveTameNBT();
			$this->namedtag->setInt(NBTConst::NBT_KEY_ANGRY, $this->angryValue, true);
			$this->namedtag->setByte(NBTConst::NBT_KEY_COLLAR_COLOR, $this->collarColor, true); // set collar color
		}
		$this->breedableClass->saveNBT();
	}

	/**
	 * Returns true if the wolf is angry
	 *
	 * @return bool
	 */
	public function isAngry() : bool{
		return $this->angryValue > 0;
	}

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

	public function getDrops() : array{
		return [];
	}

	public function getMaxHealth() : int{
		return 8; // but only for wild ones, tamed ones: 20
	}

	private function onTameSuccess(){
		$this->setCollarColor(Color::RED);
	}

	/**
	 * We've to override this!
	 *
	 * @return bool
	 */
	public function isFriendly() : bool{
		return !$this->isAngry();
	}

	/**
	 * Sets the collar color when tamed
	 *
	 * @param $collarColor
	 */
	public function setCollarColor($collarColor){
		if($this->tamed){
			$this->collarColor = $collarColor;

			if(($color = $this->namedtag->getByte(NBTConst::NBT_KEY_COLLAR_COLOR, NBTConst::NBT_INVALID_BYTE)) !== NBTConst::NBT_INVALID_BYTE){
				$this->namedtag->setByte(NBTConst::NBT_KEY_COLLAR_COLOR, $collarColor); // set collar color
				$this->getDataPropertyManager()->setPropertyValue(self::DATA_COLOUR, self::DATA_TYPE_BYTE, $collarColor);

			}else{
				$this->namedtag->setByte(NBTConst::NBT_KEY_COLLAR_COLOR, $this->collarColor);
				$this->getDataPropertyManager()->setPropertyValue(self::DATA_COLOUR, self::DATA_TYPE_BYTE, $collarColor);
			}
		}
	}

	/**
	 * Returns the collar color of the wolf
	 *
	 * @return mixed
	 */
	public function getCollarColor(){
		return $this->collarColor;
	}

	/**
	 * This method has to be called as soon as an owner name is set. It searches online players for the owner name
	 * and then sets it as owner here
	 */
	public function mapOwner(){
		if($this->ownerName !== null){
			foreach($this->getLevel()->getPlayers() as $player){
				if(strcasecmp($this->ownerName, $player->getName()) == 0){
					$this->owner = $player;
					PureEntities::logOutput("$this: mapOwner to $player", PureEntities::NORM);
					break;
				}
			}
		}
	}

	public function updateXpDropAmount() : void{
		parent::updateXpDropAmount();
		if(!$this->breedableClass->isBaby()){
			$this->xpDropAmount = 0;
		}
	}


}
