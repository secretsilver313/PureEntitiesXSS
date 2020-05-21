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

namespace revivalpmmp\pureentities;

use pocketmine\block\BlockFactory;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\level\Location;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\tile\Tile;
use revivalpmmp\pureentities\block\MonsterSpawnerPEX;
use revivalpmmp\pureentities\data\Color;
use revivalpmmp\pureentities\entity\Bat;
use revivalpmmp\pureentities\entity\Blaze;
use revivalpmmp\pureentities\entity\CaveSpider;
use revivalpmmp\pureentities\entity\Chicken;
use revivalpmmp\pureentities\entity\Cod;
use revivalpmmp\pureentities\entity\Cow;
use revivalpmmp\pureentities\entity\CreaturePEX;
use revivalpmmp\pureentities\entity\Creeper;
use revivalpmmp\pureentities\entity\Dolphin;
use revivalpmmp\pureentities\entity\Donkey;
use revivalpmmp\pureentities\entity\ElderGuardian;
use revivalpmmp\pureentities\entity\Enderman;
use revivalpmmp\pureentities\entity\Endermite;
use revivalpmmp\pureentities\entity\Evoker;
use revivalpmmp\pureentities\entity\Ghast;
use revivalpmmp\pureentities\entity\Guardian;
use revivalpmmp\pureentities\entity\Horse;
use revivalpmmp\pureentities\entity\Husk;
use revivalpmmp\pureentities\entity\IronGolem;
use revivalpmmp\pureentities\entity\Llama;
use revivalpmmp\pureentities\entity\MagmaCube;
use revivalpmmp\pureentities\entity\Mooshroom;
use revivalpmmp\pureentities\entity\Mule;
use revivalpmmp\pureentities\entity\Ocelot;
use revivalpmmp\pureentities\entity\Parrot;
use revivalpmmp\pureentities\entity\Pig;
use revivalpmmp\pureentities\entity\PolarBear;
use revivalpmmp\pureentities\entity\projectile\LargeFireball;
use revivalpmmp\pureentities\entity\projectile\SmallFireball;
use revivalpmmp\pureentities\entity\Pufferfish;
use revivalpmmp\pureentities\entity\Rabbit;
use revivalpmmp\pureentities\entity\Salmon;
use revivalpmmp\pureentities\entity\Sheep;
use revivalpmmp\pureentities\entity\Shulker;
use revivalpmmp\pureentities\entity\Silverfish;
use revivalpmmp\pureentities\entity\Skeleton;
use revivalpmmp\pureentities\entity\SkeletonHorse;
use revivalpmmp\pureentities\entity\Slime;
use revivalpmmp\pureentities\entity\SnowGolem;
use revivalpmmp\pureentities\entity\Spider;
use revivalpmmp\pureentities\entity\Squid;
use revivalpmmp\pureentities\entity\Stray;
use revivalpmmp\pureentities\entity\Tropicalfish;
use revivalpmmp\pureentities\entity\Vex;
use revivalpmmp\pureentities\entity\Villager;
use revivalpmmp\pureentities\entity\Vindicator;
use revivalpmmp\pureentities\entity\Witch;
use revivalpmmp\pureentities\entity\WitherSkeleton;
use revivalpmmp\pureentities\entity\Wolf;
use revivalpmmp\pureentities\entity\Zombie;
use revivalpmmp\pureentities\entity\ZombiePigman;
use revivalpmmp\pureentities\entity\ZombieVillager;
use revivalpmmp\pureentities\event\CreatureSpawnEvent;
use revivalpmmp\pureentities\event\EventListener;
use revivalpmmp\pureentities\features\IntfCanBreed;
use revivalpmmp\pureentities\features\IntfTameable;
use revivalpmmp\pureentities\task\AutoSpawnTask;
use revivalpmmp\pureentities\task\EndermanLookingTask;
use revivalpmmp\pureentities\task\InteractionTask;
use revivalpmmp\pureentities\tile\MobSpawner;
use revivalpmmp\pureentities\utils\MobEquipper;

class PureEntities extends PluginBase implements CommandExecutor{

	/** @var  PureEntities $instance */
	private static $instance;

	/** @var string $loglevel */
	private static $loglevel;
	/** @var PEXCustomLogger $logger */
	private static $logger;

	// logging constants for method call 'logOutput'
	const NORM = \LogLevel::INFO;
	const WARN = \LogLevel::WARNING;
	const DEBUG = \LogLevel::DEBUG;

	private static $registeredClasses = [];

	/**
	 * @var bool
	 */
	private static $loggingEnabled = false;

	/**
	 * Returns the plugin instance to get access to config e.g.
	 * @return PureEntities the current instance of the plugin main class
	 */
	public static function getInstance() : PureEntities{
		return self::$instance;
	}


	public function onLoad(){
		self::$registeredClasses = [
			Bat::class,
			Blaze::class,
			CaveSpider::class,
			Chicken::class,
			Cod::class,
			Cow::class,
			Creeper::class,
			Dolphin::class,
			Donkey::class,
			ElderGuardian::class,
			//EnderCharge::class,
			//EnderDragon::class,
			Enderman::class,
			Endermite::class,
			Evoker::class,
			Ghast::class,
			Guardian::class,
			Horse::class,
			Husk::class,
			IronGolem::class,
			Llama::class,
			LargeFireball::class,
			MagmaCube::class,
			Mooshroom::class,
			Mule::class,
			Ocelot::class,
			Parrot::class,
			Pig::class,
			PolarBear::class,
			Pufferfish::class,
			Rabbit::class,
			Salmon::class,
			Sheep::class,
			Shulker::class,
			Silverfish::class,
			Skeleton::class,
			SkeletonHorse::class,
			Slime::class,
			SmallFireball::class,
			SnowGolem::class,
			Spider::class,
			Squid::class,
			Stray::class,
			Tropicalfish::class,
			Vex::class,
			Villager::class,
			Vindicator::class,
			Witch::class,
			//Wither::class
			WitherSkeleton::class,
			Wolf::class,
			Zombie::class,
			ZombiePigman::class,
			ZombieVillager::class
		];


		foreach(self::$registeredClasses as $name){
			Entity::registerEntity($name);
			if(
				$name === IronGolem::class
				|| $name === LargeFireball::class
				|| $name === SmallFireball::class
				|| $name === SnowGolem::class
				|| $name === ZombieVillager::class
			){
				continue;
			}
			$item = Item::get(Item::SPAWN_EGG, $name::NETWORK_ID);
			if(!Item::isCreativeItem($item)){
				Item::addCreativeItem($item);
			}
		}

		Tile::registerTile(MobSpawner::class);
		BlockFactory::registerBlock(new MonsterSpawnerPEX(), true);

		$this->saveDefaultConfig();

		Color::init();

		self::$instance = $this;

		$this->getServer()->getLogger()->info("[PureEntitiesX] Originally written by milk0417. Currently maintained by RevivalPMMP for PMMP 'REDACTED'.");
	}

	public function onEnable(){
		new PluginConfiguration($this); // create plugin configuration
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
		if(PluginConfiguration::getInstance()->getEnableSpawning()){
			$this->getScheduler()->scheduleRepeatingTask(new AutoSpawnTask($this), $this->getConfig()->getNested("spawn-task.trigger-ticks", 1000));
		}
		if(PluginConfiguration::getInstance()->getEnableLookingTasks()){
			$this->getScheduler()->scheduleRepeatingTask(new InteractionTask($this), $this->getConfig()->getNested("performance.check-interactive-ticks", 10));
			$this->getScheduler()->scheduleRepeatingTask(new EndermanLookingTask($this), $this->getConfig()->getNested("performance.check-enderman-looking", 10));
		}

		$enabled = self::$loggingEnabled = PluginConfiguration::getInstance()->getLogEnabled();
		if($enabled){
			$level = self::$loglevel = strtolower($this->getConfig()->getNested("logfile.loglevel", self::NORM));
			$this->getServer()->getLogger()->info(TextFormat::GOLD . "[PureEntitiesX] Setting loglevel of logfile to " . $level);

			$this->getServer()->getLogger()->notice("[PureEntitiesX] Enabled!");
			$this->getServer()->getLogger()->notice("[PureEntitiesX] You're Running " . $this->getDescription()->getFullName());
		}
	}

	public function onDisable(){
		$this->getServer()->getLogger()->notice("[PureEntitiesX] Disabled!");
	}

	/**
	 * @param int|string $type
	 * @param Position   $source
	 * @param            $args
	 *
	 * @return Entity
	 */
	public static function create($type, Position $source, ...$args){

		$nbt = Entity::createBaseNBT($source->asVector3(), null, $source instanceof Location ? $source->yaw : 0, $source instanceof Location ? $source->pitch : 0);

		return Entity::createEntity($type, $source->getLevel(), $nbt, ...$args);
	}

	/**
	 * @param Position    $pos
	 * @param int         $entityid
	 * @param Level       $level
	 * @param string      $type
	 * @param bool        $baby
	 * @param Entity|null $parentEntity
	 * @param Player|null $owner
	 * @return null|Entity
	 */
	public function scheduleCreatureSpawn(Position $pos, int $entityid, Level $level, string $type, bool $baby = false, Entity $parentEntity = null, Player $owner = null){
		$this->getServer()->getPluginManager()->callEvent($event = new CreatureSpawnEvent($this, $pos, $entityid, $level, $type));

		if($event->isCancelled()){
			return null;
		}else{
			$entity = self::create($entityid, $pos);
			if($entity !== null){
				if($entity instanceof IntfCanBreed and $baby and $entity->getBreedingComponent() !== false){
					$entity->getBreedingComponent()->setAge(-6000); // in 5 minutes it will be a an adult (atm only sheep)
					if($parentEntity != null){
						$entity->getBreedingComponent()->setParent($parentEntity);
					}
				}
				// new: a baby's parent (like a wolf) may belong to a player - if so, the baby is also owned by the player!
				if($owner !== null && $entity instanceof IntfTameable){
					$entity->setTamed(true);
					$entity->setOwner($owner);
				}
				self::logOutput("PureEntities: scheduleCreatureSpawn [type:$entity] [baby:$baby]", self::DEBUG);
				$entity->spawnToAll();

				// additionally: mob equipment
				if($entity instanceof CreaturePEX){
					MobEquipper::equipMob($entity);
				}

				return $entity;
			}
			self::logOutput("Cannot create entity [entityId:$entityid]", self::WARN);
			return null;
		}
	}

	/**
	 * Logs an output to the plugin's logfile ...
	 * @param string $logline the output to be appended
	 * @param string $type the type of output to log
	 * @return bool returns false on failure
	 */
	public static function logOutput(string $logline, string $type = self::DEBUG){
		if(self::$loggingEnabled){
            switch($type){
                case self::DEBUG:
                    self::getInstance()->getLogger()->debug($logline);
                    break;
                case self::WARN:
                    self::getInstance()->getLogger()->warning($logline);
                    break;
                case self::NORM:
                default:
                    self::getInstance()->getLogger()->info($logline);
                    break;
            }
			return true;
		}
		return false;
	}

	/**
	 * Returns a suitable Y-position for spawning an entity, starting from the given coordinates.
	 *
	 * First, it's checked if the given position is AIR position. If so, we search down the y-coordinate
	 * to get a first non-air block. When a non-air block is found the position returned is the last found air
	 * position.
	 *
	 * When the given coordinates are NOT an AIR block coordinate we search upwards until the first air block is found
	 * which is then returned to the caller.
	 *
	 * @param       $x                int the x position to start search
	 * @param       $y                int the y position to start search
	 * @param       $z                int the z position to start searching
	 * @param Level $level Level the level object to search in
	 * @return null|Position    either NULL if no valid position was found or the final AIR spawn position
	 */
	public static function getSuitableHeightPosition($x, $y, $z, Level $level){
		$newPosition = null;
		$id = $level->getBlockIdAt($x, $y, $z);
		if($id == 0){ // we found an air block - we need to search down step by step to get the correct block which is not an "AIR" block
			$air = true;
			$y = $y - 1;
			while($air){
				$id = $level->getBlockIdAt($x, $y, $z);
				if($id != 0){ // this is an air block ...
					$newPosition = new Position($x, $y + 1, $z, $level);
					$air = false;
				}else{
					$y = $y - 1;
					if($y < -255){
						break;
					}
				}
			}
		}else{ // something else than AIR block. search upwards for a valid air block
			$air = false;
			while(!$air){
				$id = $level->getBlockIdAt($x, $y, $z);
				if($id == 0){ // this is an air block ...
					$newPosition = new Position($x, $y, $z, $level);
					$air = true;
				}else{
					$y = $y + 1;
					if($y > 255){
						break;
					}
				}
			}
		}

		return $newPosition;
	}

	/**
	 * @param CommandSender $sender
	 * @param Command       $command
	 * @param string        $label
	 * @param array         $args
	 * @return bool
	 */
	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
		$commandSuccessful = false;

		switch($command->getName()){
			case "peremove":
				if(count($args) <= 1){
					$counterLivingEntities = 0;
					$counterOtherEntities = 0;
					foreach(Server::getInstance()->getLevels() as $level){
						foreach($level->getEntities() as $entity){
							if(count($args) === 0){
								if(!$entity instanceof Player and $entity->namedtag->hasTag("generatedByPEX")){
									$entity->close();
									if($entity instanceof CreaturePEX){
										$counterLivingEntities++;
									}else{
										$counterOtherEntities++;
									}
								}
							}elseif(strcmp(strtolower($args[0]), "all") == 0){
								if(!$entity instanceof Player){
									$entity->close();
									if($entity instanceof CreaturePEX){
										$counterLivingEntities++;
									}else{
										$counterOtherEntities++;
									}
								}
							}
						}
					}
					$sender->sendMessage("Removed entities. BaseEntities removed: $counterLivingEntities, other Entities: $counterOtherEntities");
					self::logOutput("PeRemove: Removed $counterLivingEntities living entities and $counterOtherEntities other entities: ", self::NORM);
					$commandSuccessful = true;
				}else{
					$sender->sendMessage("Usage: peremove <opt:all>");
					$commandSuccessful = true;
				}
				break;
			case "pesummon":
				if(($sender instanceof Player and count($args) >= 1 and count($args) <= 3) or (!$sender instanceof Player and count($args) > 1)){
					$playerName = count($args) == 1 ? $sender->getName() : $args[1];
					$isBaby = false;
					if(count($args) == 3){
						$isBaby = strcmp(strtolower($args[2]), "true") == 0;
					}
					foreach($this->getServer()->getOnlinePlayers() as $player){
						if(strcasecmp($player->getName(), $playerName) == 0){
							// find a mob with the name issued
							$mobName = strtolower($args[0]);
							foreach(self::$registeredClasses as $registeredClass){
								if(strcmp($mobName, strtolower($this->getShortClassName($registeredClass))) == 0){
									self::scheduleCreatureSpawn($player->getPosition(), $registeredClass::NETWORK_ID, $player->getLevel(), "Monster", $isBaby);
									$sender->sendMessage("Spawned $mobName");
									return true;
								}
							}
							$sender->sendMessage("Entity not found: $mobName");
							return true;
						}
					}
				}else{
					$sender->sendMessage("Usage: pesummon <mobname> <opt:player_name> <opt:baby>");
					$commandSuccessful = true;
				}
				break;
		}
		return $commandSuccessful;
	}

	/**
	 * Returns the "short" name of a class without namespace ...
	 *
	 * @param string $longClassName
	 * @return string
	 */
	private function getShortClassName(string $longClassName) : string{
		$short = "";
		$longClassName = strtok($longClassName, "\\");
		while($longClassName !== false){
			$short = $longClassName;
			$longClassName = strtok("\\");
		}
		return $short;
	}

	/**
	 * @return array
	 */
	public static function getRegisteredClasses() : array{
		return self::$registeredClasses;
	}

	public static function getPositionNearPlayer(Player $player, int $minimumDistanceToPlayer = 8, int $maximumDistanceToPlayer = 40) : Position{
		// Random method used to get 8 block difference from player to entity spawn)
		$x = $player->x + (random_int($minimumDistanceToPlayer, $maximumDistanceToPlayer) * (random_int(0, 1) === 0 ? 1 : -1));
		$z = $player->z + (random_int($minimumDistanceToPlayer, $maximumDistanceToPlayer) * (random_int(0, 1) === 0 ? 1 : -1));

		return new Position($x, $player->y, $z, $player->getLevel());
	}
}