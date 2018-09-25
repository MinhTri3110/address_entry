<?php
namespace Drupal\address_entry\Entity\Controller;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Url;

/**
 * Provides a list controller for content_entity_manage_inventory entity.
 *
 * @ingroup manage_inventory
 */
class AddressEntryListBuilder extends EntityListBuilder {
  /**
   * {@inheritdoc}
   *
   * We override ::render() so that we can add our own content above the table.
   * parent::render() is where EntityListBuilder creates the table using our
   * buildHeader() and buildRow() implementations.
   */
  
  public function render() {
    $build['table'] = parent::render();
    return $build;
  }
  /**
   * {@inheritdoc}
   *
   * Building the header and content lines for the inventory list.
   *
   * Calling the parent::buildHeader() adds a column for the possible actions
   * and inserts the 'edit' and 'delete' links as defined for the entity type.
   */
  public function buildHeader() {
    $header['id'] = $this->t('ID');
    $header['name'] = $this->t('Name');
    $header['email'] = $this->t('Email');
    $header['phone'] = $this->t('Phone');
    $header['date_of_birth'] = $this->t('Date of birth');
    return $header + parent::buildHeader();
  }
  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\manage_inventory\Entity\Inventory */
    $row['id'] = $entity->id();
    $row['name'] = $entity->name->value;
    $row['email'] = $entity->email->value;
    $row['phone'] = $entity->phone->value;
    $row['date_of_birth'] = $entity->date_of_birth->value;
    return $row + parent::buildRow($entity);
  }
}

?>