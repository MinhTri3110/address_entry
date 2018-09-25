<?php
namespace Drupal\address_entry\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\BundleEntityFormBase;

/**
 * Form controller for the address entry entity edit forms.
 *
 * @ingroup address_entry
 */

class AddressEntryForm extends BundleEntityFormBase {
  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);
    $entity_type = $this->entity;
    $content_entity_id = $entity_type->getEntityType()->getBundleOf();

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#maxlength' => 255,
      '#default_value' => '',
      '#description' => $this->t("Name for the %content_entity_id entity type (bundle).", ['%content_entity_id' => $content_entity_id]),
      '#required' => TRUE,
    ];
    
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#default_value' => '',
      '#description' => $this->t("Email for the %content_entity_id entity type (bundle).", ['%content_entity_id' => $content_entity_id]),
      '#required' => TRUE,
    ];
    
    $form['phone'] = [
      '#type' => 'tel',
      '#title' => $this->t('Phone'),
      '#default_value' => '',
      '#description' => $this->t("Phone for the %content_entity_id entity type (bundle).", ['%content_entity_id' => $content_entity_id]),
      '#required' => TRUE,
    ];
    
    $form['date_of_birth'] = [
      '#type' => 'date',
      '#title' => $this->t('Date of birth'),
      '#default_value' => '',
      '#description' => $this->t("Date of birth for the %content_entity_id entity type (bundle).", ['%content_entity_id' => $content_entity_id]),
      '#required' => TRUE,
    ];

    return $form;
  }
  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity_type = $this->entity;
    $status = $entity_type->save();
    $form_state->setRedirectUrl($entity_type->toUrl('collection'));
  }
}


?>