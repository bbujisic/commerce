<?php

/**
 * @file
 * Contains \Drupal\commerce_product\Entity\ProductVariationType.
 */

namespace Drupal\commerce_product\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\commerce_product\ProductVariationTypeInterface;

/**
 * Defines the Commerce Product Variation Type entity type.
 *
 * @ConfigEntityType(
 *   id = "commerce_product_variation_type",
 *   label = @Translation("Product variation type"),
 *   handlers = {
 *     "list_builder" = "Drupal\commerce_product\ProductVariationTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\commerce_product\Form\ProductVariationTypeForm",
 *       "edit" = "Drupal\commerce_product\Form\ProductVariationTypeForm",
 *       "delete" = "Drupal\commerce_product\Form\ProductVariationTypeDeleteForm"
 *     }
 *   },
 *   config_prefix = "commerce_product_variation_type",
 *   admin_permission = "administer product types",
 *   bundle_of = "commerce_product",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "description",
 *   },
 *   links = {
 *     "edit-form" =   "/admin/commerce/config/product-variation-types/{commerce_product_variation_type}/edit",
 *     "delete-form" = "/admin/commerce/config/product-variation-types/{commerce_product_variation_type}/delete",
 *     "collection" =  "/admin/commerce/config/product-variation-types"
 *   }
 * )
 */
class ProductVariationType extends ConfigEntityBundleBase implements ProductVariationTypeInterface {

  /**
   * The product variation type machine name and primary ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The product variation type UUID.
   *
   * @var string
   */
  protected $uuid;

  /**
   * The product variation type label.
   *
   * @var string
   */
  protected $label;

  /**
   * The product variation type description.
   *
   * @var string
   */
  protected $description;

  /**
   * Indicates whether a body field should be created for this product variation type.
   *
   * This property affects entity creation only. It allows default configuration
   * of modules and installation profiles to specify whether a Body field should
   * be created for this bundle.
   *
   * @var bool
   */
  protected $createBody = TRUE;

  /**
   * The label to use for the body field upon entity creation.
   *
   * @var string
   */
  protected $createBodyLabel = 'Body';

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * {@inheritdoc}
   */
  public function setDescription($description) {
    $this->description = $description;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function postSave(EntityStorageInterface $storage, $update = TRUE) {
    parent::postSave($storage, $update);

    // Create a body if the create_body property is true and we're not in
    // the syncing process.
    if ($this->get('create_body') && !$this->isSyncing()) {
      $label = $this->get('create_body_label');
      commerce_product_add_body_field($this->id, $label);
    }
   }

}
