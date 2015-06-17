<?php

/**
 * @file
 * Contains \Drupal\commerce_product\ProductTypeInterface.
 */

namespace Drupal\commerce_product;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Defines the interface for product types.
 */
interface ProductVariationTypeInterface extends ConfigEntityInterface {

  /**
   * Gets the product type description.
   *
   * @return string
   *   The product type description.
   */
  public function getDescription();

  /**
   * Sets the description of the product type.
   *
   * @param string $description
   *   The new description.
   *
   * @return $this
   */
  public function setDescription($description);
}
