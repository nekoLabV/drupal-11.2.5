<?php

declare(strict_types=1);

namespace Drupal\relationship;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of relationship type entities.
 *
 * @see \Drupal\relationship\Entity\RelationshipType
 */
final class RelationshipTypeListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    $header['label'] = $this->t('Label');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array {
    $row['label'] = $entity->label();
    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function render(): array {
    $build = parent::render();

    $build['table']['#empty'] = $this->t(
      'No relationship types available. <a href=":link">Add relationship type</a>.',
      [':link' => Url::fromRoute('entity.relationship_type.add_form')->toString()],
    );

    return $build;
  }

}
