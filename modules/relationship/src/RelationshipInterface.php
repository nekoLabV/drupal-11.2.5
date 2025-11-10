<?php

declare(strict_types=1);

namespace Drupal\relationship;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining a relationship entity type.
 */
interface RelationshipInterface extends ContentEntityInterface, EntityChangedInterface {

}
