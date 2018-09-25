<?php
/**
 * @file
 * Contains \Drupal\address_entry\Entity\AddressEntry.
 */

namespace Drupal\address_entry\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\address_entry\AddressEntryInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Address Entry entity.
 *
 * @ingroup address_entry
 *
 * @ContentEntityType(
 *   id = "address_entry",
 *   label = @Translation("Address Entry entity"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\address_entry\Entity\Controller\AddressEntryListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\address_entry\Form\AddressEntryForm",
 *       "edit" = "Drupal\address_entry\Form\AddressEntryForm",
 *       "delete" = "Drupal\address_entry\Form\AddressEntryDeleteForm",
 *     },
 *     "access" = "Drupal\address_entry\AddressEntryAccessControlHandler",
 *   },
 *   base_table = "address_entry",
 *   admin_permission = "administer address entry entity",
 *   fieldable = TRUE,
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *     "name" = "name",
 *     "email" = "email",
 *     "phone" = "phone",
 *     "date_of_birth" = "date_of_birth",
 *   },
 *   links = {
 *     "canonical" = "/addressbook/{address_entry}",
 *     "edit-form" = "/addressbook/{address_entry}/edit",
 *     "delete-form" = "/addressbook/{address_entry}/delete",
 *     "collection" = "/addressbook/list"
 *   },
 * )
 *
 */

class AddressEntry extends ContentEntityBase implements AddressEntryInterface {
  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += array(
      'user_id' => \Drupal::currentUser()->id(),
    );
  }
  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }
  /**
   * {@inheritdoc}
   */
  public function getChangedTime() {
    return $this->get('changed')->value;
  }
  /**
   * {@inheritdoc}
   */
  public function setChangedTime($timestamp) {
    $this->set('changed', $timestamp);
    return $this;
  }
  /**
   * {@inheritdoc}
   */
  public function getChangedTimeAcrossTranslations() {
    $changed = $this->getUntranslated()->getChangedTime();
    foreach ($this->getTranslationLanguages(FALSE) as $language) {
      $translation_changed = $this->getTranslation($language->getId())
        ->getChangedTime();
      $changed = max($translation_changed, $changed);
    }
    return $changed;
  }
  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }
  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }
  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }
  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }
  /**
   * {@inheritdoc}
   *
   * Define the field properties here.
   *
   * Field name, type and size determine the table structure.
   *
   * In addition, we can define how the field and its content can be manipulated
   * in the GUI. The behaviour of the widgets used can be determined here.
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the inventory entity.'))
      ->setReadOnly(TRUE);

    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the inventory entity.'))
      ->setReadOnly(TRUE);
    
    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Address Entry entity.'));
      
    $fields['email'] = BaseFieldDefinition::create('email')
      ->setLabel(t('Email'))
      ->setDescription(t('The email of the Address Entry entity.'));
      
    $fields['phone'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Phone'))
      ->setDescription(t('The phone of the Address Entry entity.'));
      
    $fields['date_of_birth'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Date of birth'))
      ->setDescription(t('The date of birth of the Address Entry entity.'));

    return $fields;
  }
}

?>