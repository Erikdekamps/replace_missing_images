<?php

namespace Drupal\replace_missing_images\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class ReplaceMissingImagesSettingsForm extends ConfigFormBase {

  /**
   * Gets the configuration names that will be editable.
   *
   * @return array
   *   An array of configuration object names that are editable if called in
   *   conjunction with the trait's config() method.
   */
  protected function getEditableConfigNames() {
    return [
      'replace_missing_images.settings'
    ];
  }

  /**
   * Returns a unique string identifying the form.
   *
   * The returned ID should be a unique string that can be a valid PHP function
   * name, since it's used in hook implementation names such as
   * hook_form_FORM_ID_alter().
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'replace_missing_images_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('replace_missing_images.settings');

    $form['predefined_placeholder_service'] = [
      '#title' => $this->t('Predefined placeholder service'),
      '#type' => 'select',
      '#options' => $this->getDefaultPlaceholderLinks(),
      '#default_value' => $config->get('predefined_placeholder_service'),
      '#states' => [
        'disabled' => [
          ':input[name="use_custom_placeholder_service"]' => ['checked' => TRUE],
        ],
      ],
    ];

    $form['use_custom_placeholder_service'] = [
      '#title' => $this->t('Use custom placeholder'),
      '#type' => 'checkbox',
      '#default_value' => $config->get('use_custom_placeholder_service'),
    ];

    $form['custom_placeholder_service'] = [
      '#title' => $this->t('Custom placeholder service'),
      '#description' => $this->t('For example: %url', ['%url' => 'https://placekitten.com/408/287']),
      '#type' => 'url',
      '#default_value' => $config->get('custom_placeholder_service'),
      '#states' => [
        'visible' => [
          ':input[name="use_custom_placeholder_service"]' => ['checked' => TRUE],
        ],
      ],
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $values = $form_state->getValues();

    $this->config('replace_missing_images.settings')
      ->set('predefined_placeholder_service', $values['predefined_placeholder_service'])
      ->set('use_custom_placeholder_service', $values['use_custom_placeholder_service'])
      ->set('custom_placeholder_service', $values['custom_placeholder_service'])
      ->save();

    parent::submitForm($form, $form_state);
  }

  /**
   * Get the default placeholder links to use.
   */
  private function getDefaultPlaceholderLinks() {
    return [
      '_none' => $this->t('- None -'),
      'https://placekitten.com/g/600/400' => 'placekitten.com',
    ];
  }

}
