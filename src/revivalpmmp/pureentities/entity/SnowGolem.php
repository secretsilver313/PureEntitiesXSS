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
use pocketmine\nbt\tag\CompoundTag;
use revivalpmmp\pureentities\data\NBTConst;
use revivalpmmp\pureentities\features\IntfShearable;
use revivalpmmp\pureentities\PluginConfiguration;
use revivalpmmp\pureentities\traits\Shearable;

class SnowGolem extends MonsterPEX implements ProjectileSource, IntfShearable{
	use Shearable;
	const NETWORK_ID = self::SNOW_GOLEM;

	public function initEntity() : void{
		parent::initEntity();

		$this->setSheared($this->isSheared()); // set data from NBT
		$this->maxShearDrops = 0;
	}

	public function getName() : string{
		return "SnowGolem";
	}

	public function getDrops() : array{
		return [Item::get(Item::SNOWBALL, 0, mt_rand(0, 15))];
	}

	public function getMaxHealth() : int{
		return 4;
	}

	/**
	 * loads data from nbt and fills internal variables
	 */
	public function loadFromNBT(CompoundTag $nbt) : void{
		if(PluginConfiguration::getInstance()->getEnableNBT()){
			if(($pumpkin = $this->namedtag->getByte(NBTConst::NBT_KEY_PUMPKIN, NBTConst::NBT_INVALID_BYTE)) !== NBTConst::NBT_INVALID_BYTE){
				$this->sheared = (bool) $pumpkin;
			}
		}
	}

	/**
	 * Stores internal variables to NBT
	 */
	public function saveNBT() : void{
		if(PluginConfiguration::getInstance()->getEnableNBT()){
			parent::saveNBT();
			$this->namedtag->setByte(NBTConst::NBT_KEY_PUMPKIN, $this->sheared ? 0 : 1); // default: has pumpkin on his head (1 - pumpkin on head, 0 - pumpkin off!)
		}
	}


	public function updateXpDropAmount() : void{
	}
}
