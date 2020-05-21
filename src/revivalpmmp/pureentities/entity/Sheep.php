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
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\CompoundTag;
use revivalpmmp\pureentities\components\BreedingComponent;
use revivalpmmp\pureentities\data\Color;
use revivalpmmp\pureentities\data\NBTConst;
use revivalpmmp\pureentities\features\IntfCanBreed;
use revivalpmmp\pureentities\features\IntfCanPanic;
use revivalpmmp\pureentities\features\IntfShearable;
use revivalpmmp\pureentities\PluginConfiguration;
use revivalpmmp\pureentities\traits\Breedable;
use revivalpmmp\pureentities\traits\CanPanic;
use revivalpmmp\pureentities\traits\Feedable;
use revivalpmmp\pureentities\traits\Shearable;

class Sheep extends AnimalPEX implements IntfCanBreed, IntfShearable, IntfCanPanic{
	use Breedable, CanPanic, Feedable, Shearable;
	const NETWORK_ID = self::SHEEP;

	const DATA_COLOR_INFO = 16;


	/**
	 * @var int
	 */
	private $color = Color::WHITE; // default: white

	public function getName() : string{
		return "Sheep";
	}

	public static function getRandomColor() : int{
		$rand = "";
		$rand .= str_repeat(Color::WHITE . " ", 818);
		$rand .= str_repeat(Color::GRAY . " ", 50);
		$rand .= str_repeat(Color::LIGHT_GRAY . " ", 50);
		$rand .= str_repeat(Color::BROWN . " ", 30);
		$rand .= str_repeat(Color::BLACK . " ", 50);
		$rand .= str_repeat(Color::PINK . " ", 2);
		$arr = explode(" ", $rand);
		return (int) $arr[mt_rand(0, count($arr) - 1)];
	}

	public function initEntity() : void{
		parent::initEntity();
		$this->breedableClass = new BreedingComponent($this);
		$this->breedableClass->init();
		$this->feedableItems = array(Item::WHEAT);
		$this->maxShearDrops = 3;
		$this->shearItems = Item::WOOL;
		$this->setColor($this->getColor());
		$this->setSheared($this->isSheared());
	}

	public function getDrops() : array{
		$drops = [];
		if(!$this->isSheared() && !$this->breedableClass->isBaby()){
			// http://minecraft.gamepedia.com/Sheep - drop 1 wool when not a baby and died
			$drops[] = Item::get(Item::WOOL, $this->getColor(), 1);
			if($this->isOnFire()){
				$drops[] = Item::get(Item::MUTTON_COOKED, 0, mt_rand(1, 2));
			}else{
				$drops[] = Item::get(Item::MUTTON_RAW, 0, mt_rand(1, 2));
			}
		}
		return $drops;
	}

	/**
	 * The initEntity method of parent uses this function to get the max health and set in NBT
	 *
	 * @return int
	 */
	public function getMaxHealth() : int{
		return 8;
	}

	/**
	 * loads data from nbt and fills internal variables
	 */
	public function loadFromNBT(CompoundTag $nbt) : void{
		if(PluginConfiguration::getInstance()->getEnableNBT()){
			if($this->namedtag->hasTag(NBTConst::NBT_KEY_SHEARED)){
				$sheared = $this->namedtag->getByte(NBTConst::NBT_KEY_SHEARED, false, true);
				$this->sheared = (bool) $sheared;
			}

			if($this->namedtag->hasTag(NBTConst::NBT_KEY_COLOR)){
				$color = $this->namedtag->getByte(NBTConst::NBT_KEY_COLOR, self::getRandomColor());
				$this->color = (int) $color;
			} else {
				$this->color = self::getRandomColor();
			}
		}
	}

	/**
	 * Stores internal variables to NBT
	 */
	public function saveNBT() : void{
		if(PluginConfiguration::getInstance()->getEnableNBT()){
			parent::saveNBT();
			$this->namedtag->setTag(new ByteTag(NBTConst::NBT_KEY_SHEARED, (int) $this->sheared));
			$this->namedtag->setTag(new ByteTag(NBTConst::NBT_KEY_COLOR, $this->color));
		}
		$this->breedableClass->saveNBT();
	}

	// ------------------------------------------------------------
	// very sheep specific functions
	// ------------------------------------------------------------


	/**
	 * Gets the color of the sheep
	 *
	 * @return int
	 */
	public function getColor() : int{
		return $this->color;
	}

	/**
	 * Set the color of the sheep
	 *
	 * @param int $color
	 */
	public function setColor(int $color){
		$this->color = $color;
		$this->getDataPropertyManager()->setPropertyValue(self::DATA_COLOUR, self::DATA_TYPE_BYTE, $color);
	}

	public function updateXpDropAmount() : void{
		parent::updateXpDropAmount();
		if($this->breedableClass->checkInLove()){
			$this->xpDropAmount = mt_rand(1, 7);
		}
		if($this->breedableClass->isBaby()){
			$this->xpDropAmount = 0;
		}
	}


}
