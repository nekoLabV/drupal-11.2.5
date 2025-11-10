<?php

declare(strict_types=1);

namespace Drupal\relationship\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;
use Drupal\Core\Entity\Attribute\ConfigEntityType;
use Drupal\Core\Entity\EntityDeleteForm;
use Drupal\Core\Entity\Routing\AdminHtmlRouteProvider;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\relationship\Form\RelationshipTypeForm;
use Drupal\relationship\RelationshipTypeListBuilder;

/**
 * Defines the Relationship type configuration entity.
 */
#[ConfigEntityType(
  id: 'relationship_type',
  label: new TranslatableMarkup('Relationship type'),
  label_collection: new TranslatableMarkup('Relationship types'),
  label_singular: new TranslatableMarkup('relationship type'),
  label_plural: new TranslatableMarkup('relationships types'),
  config_prefix: 'relationship_type',
  entity_keys: [
    'id' => 'id',
    'label' => 'label',
    'uuid' => 'uuid',
  ],
  handlers: [
    'list_builder' => RelationshipTypeListBuilder::class,
    'route_provider' => [
      'html' => AdminHtmlRouteProvider::class,
    ],
    'form' => [
      'add' => RelationshipTypeForm::class,
      'edit' => RelationshipTypeForm::class,
      'delete' => EntityDeleteForm::class,
    ],
  ],
  links: [
    'add-form' => '/admin/structure/relationship_types/add',
    'edit-form' => '/admin/structure/relationship_types/manage/{relationship_type}',
    'delete-form' => '/admin/structure/relationship_types/manage/{relationship_type}/delete',
    'collection' => '/admin/structure/relationship_types',
  ],
  admin_permission: 'administer relationship types',
  bundle_of: 'relationship',
  label_count: [
    'singular' => '@count relationship type',
    'plural' => '@count relationships types',
  ],
  config_export: [
    'id',
    'label',
    'uuid',
  ],
)]
final class RelationshipType extends ConfigEntityBundleBase {

  /**
   * The machine name of this relationship type.
   */
  protected string $id;

  /**
   * The human-readable name of the relationship type.
   */
  protected string $label;

}
