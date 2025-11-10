<?php

declare(strict_types=1);

namespace Drupal\relationship\Entity;

use Drupal\Core\Entity\Attribute\ContentEntityType;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\ContentEntityDeleteForm;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\Form\DeleteMultipleForm;
use Drupal\Core\Entity\Routing\AdminHtmlRouteProvider;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\relationship\Form\RelationshipForm;
use Drupal\relationship\RelationshipInterface;
use Drupal\relationship\RelationshipListBuilder;
use Drupal\views\EntityViewsData;

/**
 * Defines the relationship entity class.
 */
#[ContentEntityType(
  id: 'relationship',
  label: new TranslatableMarkup('Relationship'),
  label_collection: new TranslatableMarkup('Relationships'),
  label_singular: new TranslatableMarkup('relationship'),
  label_plural: new TranslatableMarkup('relationships'),
  entity_keys: [
    'id' => 'id',
    'bundle' => 'bundle',
    'label' => 'id',
    'published' => 'status',
    'uuid' => 'uuid',
  ],
  handlers: [
    'list_builder' => RelationshipListBuilder::class,
    'views_data' => EntityViewsData::class,
    'form' => [
      'add' => RelationshipForm::class,
      'edit' => RelationshipForm::class,
      'delete' => ContentEntityDeleteForm::class,
      'delete-multiple-confirm' => DeleteMultipleForm::class,
    ],
    'route_provider' => [
      'html' => AdminHtmlRouteProvider::class,
    ],
  ],
  links: [
    'collection' => '/admin/content/relationship',
    'add-form' => '/relationship/add/{relationship_type}',
    'add-page' => '/relationship/add',
    'canonical' => '/relationship/{relationship}',
    'edit-form' => '/relationship/{relationship}/edit',
    'delete-form' => '/relationship/{relationship}/delete',
    'delete-multiple-form' => '/admin/content/relationship/delete-multiple',
  ],
  admin_permission: 'administer relationship types',
  bundle_entity_type: 'relationship_type',
  bundle_label: new TranslatableMarkup('Relationship type'),
  base_table: 'relationship',
  label_count: [
    'singular' => '@count relationships',
    'plural' => '@count relationships',
  ],
  field_ui_base_route: 'entity.relationship_type.edit_form',
)]
class Relationship extends ContentEntityBase implements RelationshipInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type): array {

    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Status'))
      ->setDefaultValue(TRUE)
      ->setSetting('on_label', 'Enabled')
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'settings' => [
          'display_label' => FALSE,
        ],
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'boolean',
        'label' => 'above',
        'weight' => 0,
        'settings' => [
          'format' => 'enabled-disabled',
        ],
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['description'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Description'))
      ->setDisplayOptions('form', [
        'type' => 'text_textarea',
        'weight' => 10,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'text_default',
        'label' => 'above',
        'weight' => 10,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Authored on'))
      ->setDescription(t('The time that the relationship was created.'))
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('form', [
        'type' => 'datetime_timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the relationship was last edited.'));

    return $fields;
  }

}
