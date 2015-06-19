<?php

/**
 * @file
 * Contains \Drupal\commerce_product\Form\ProductVariationForm.
 */

namespace Drupal\commerce_product\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the product edit form.
 */
class ProductVariationForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    /* @var \Drupal\commerce_product\Entity\ProductVariation $productVariation */
    $productVariation = $this->entity;
    $currentUser = $this->currentUser();

    $form['advanced'] = [
      '#type' => 'vertical_tabs',
      '#attributes' => ['class' => ['entity-meta']],
      '#weight' => 99,
    ];
    $form = parent::form($form, $form_state);

    // Product author information for administrators.
    $form['author'] = [
      '#type' => 'details',
      '#title' => t('Authoring information'),
      '#group' => 'advanced',
      '#attributes' => [
        'class' => ['product-form-author'],
      ],
      '#weight' => 90,
      '#optional' => TRUE,
    ];

    if (isset($form['uid'])) {
      $form['uid']['#group'] = 'author';
    }

    if (isset($form['created'])) {
      $form['created']['#group'] = 'author';
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    /** @var \Drupal\commerce_product\entity\ProductVariation $productVariation */
    $productVariation = $this->getEntity();
    try {
      $productVariation->save();
      drupal_set_message($this->t('The product variation %product_variation_label has been successfully saved.', ['%product_variation_label' => $productVariation->label()]));
      $form_state->setRedirect('entity.commerce_product_variation.canonical', ['commerce_product_variation' => $productVariation->id()]);
    } catch (\Exception $e) {
      drupal_set_message($this->t('The product variation %product_variation_label could not be saved.', ['%product_variation_label' => $productVariation->label()]), 'error');
      $this->logger('commerce_product')
        ->error($e);
      $form_state->setRebuild();
    }
  }

}
