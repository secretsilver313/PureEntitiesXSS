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


use pocketmine\entity\Creature;
use pocketmine\level\Level;
use pocketmine\nbt\tag\CompoundTag;
use revivalpmmp\pureentities\data\Data;
use revivalpmmp\pureentities\PureEntities;

abstract class CreaturePEX extends Creature{

	protected $xpDropAmount = 0;

	public function __construct(Level $level, CompoundTag $nbt){
		if(!isset(Data::HEIGHTS[static::NETWORK_ID])){
			PureEntities::getInstance()->getLogger()->debug("Missing height data for " . static::class);
		}else{
			$this->height = Data::HEIGHTS[static::NETWORK_ID];
		}

		if(!isset(Data::WIDTHS[static::NETWORK_ID])){
			PureEntities::getInstance()->getLogger()->debug("Missing width data for " . static::class);
		}else{
			$this->width = Data::WIDTHS[static::NETWORK_ID];
		}
		parent::__construct($level, $nbt);
	}

	protected function initEntity() : void{
		parent::initEntity();
		$this->loadFromNBT($this->namedtag);
	}

	public function loadFromNBT(CompoundTag $nbt) : void{
	}

	public function saveNBT() : void{
		parent::saveNBT();
		if(function_exists("loadAgeNBT")){
			$this->loadAgeNBT();
		}
	}

	public function updateXpDropAmount() : void{
		$this->xpDropAmount = mt_rand(1,3);
	}

	public function getXpDropAmount() : int{
		$this->updateXpDropAmount();
		return $this->getXpDropAmount();
	}

}