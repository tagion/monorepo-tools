<?php

namespace SS6\ShopBundle\Component\Domain\Multidomain;

use Doctrine\ORM\EntityManager;
use SS6\ShopBundle\Component\Domain\Multidomain\MultidomainEntityClassFinder;
use SS6\ShopBundle\Component\Entity\EntityNotNullableColumnsFinder;
use SS6\ShopBundle\Component\Setting\SettingValue;

class MultidomainEntityClassFinderFacade {

	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $em;

	/**
	 * @var \SS6\ShopBundle\Component\Domain\Multidomain\MultidomainEntityClassFinder
	 */
	private $multidomainEntityClassFinder;

	/**
	 * @var \SS6\ShopBundle\Component\Entity\EntityNotNullableColumnsFinder
	 */
	private $entityNotNullableColumnsFinder;

	public function __construct(
		EntityManager $em,
		MultidomainEntityClassFinder $multidomainEntityClassFinder,
		EntityNotNullableColumnsFinder $entityNotNullableColumnsFinder
	) {
		$this->em = $em;
		$this->multidomainEntityClassFinder = $multidomainEntityClassFinder;
		$this->entityNotNullableColumnsFinder = $entityNotNullableColumnsFinder;
	}

	/**
	 * @return string[]
	 */
	public function getMultidomainEntitiesNames() {
		return $this->multidomainEntityClassFinder->getMultidomainEntitiesNames(
			$this->em->getMetadataFactory()->getAllMetadata(),
			$this->getIgnoredEntitiesNames()
		);
	}

	/**
	 * @return string[tableName][]
	 */
	public function getAllNotNullableColumnNamesIndexedByTableName() {
		$multidomainClassesMetadata = [];
		foreach ($this->getMultidomainEntitiesNames() as $multidomainEntityName) {
			$multidomainClassesMetadata[] = $this->em->getMetadataFactory()->getMetadataFor($multidomainEntityName);
		}

		return $this->entityNotNullableColumnsFinder->getAllNotNullableColumnNamesIndexedByTableName($multidomainClassesMetadata);
	}

	/**
	 * @return string[]
	 */
	private function getIgnoredEntitiesNames() {
		return [SettingValue::class];
	}
}