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
      'replace_missing_images.settings',
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

    $form['enabled'] = [
      '#title' => $this->t('Enabled'),
      '#type' => 'checkbox',
      '#default_value' => $config->get('enabled'),
    ];

    $form['replace_all'] = [
      '#title' => $this->t('Replace all images'),
      '#description' => $this->t('Replace all images, not just the missing ones.'),
      '#type' => 'checkbox',
      '#default_value' => $config->get('replace_all'),
      '#states' => [
        'visible' => [
          ':input[name="enabled"]' => ['checked' => TRUE],
        ],
      ],
    ];

    $form['predefined_placeholder_service'] = [
      '#title' => $this->t('Predefined placeholder service'),
      '#type' => 'select',
      '#options' => $this->getDefaultPlaceholderLinks(),
      '#default_value' => $config->get('predefined_placeholder_service'),
      '#states' => [
        'visible' => [
          ':input[name="enabled"]' => ['checked' => TRUE],
        ],
        'disabled' => [
          ':input[name="use_custom_placeholder_service"]' => ['checked' => TRUE],
        ],
      ],
      '#description' => $this->t('Use a predefined placeholder service.'),
    ];

    $form['default_placeholder_image_width'] = [
      '#title' => $this->t('Placeholder image width'),
      '#type' => 'number',
      '#default_value' => $config->get('default_placeholder_image_width'),
      '#description' => $this->t('The placeholder image width to use.'),
      '#states' => [
        'visible' => [
          ':input[name="enabled"]' => ['checked' => TRUE],
        ],
      ],
    ];

    $form['default_placeholder_image_height'] = [
      '#title' => $this->t('Placeholder image height'),
      '#type' => 'number',
      '#default_value' => $config->get('default_placeholder_image_height'),
      '#description' => $this->t('The placeholder image height to use.'),
      '#states' => [
        'visible' => [
          ':input[name="enabled"]' => ['checked' => TRUE],
        ],
      ],
    ];

    $form['use_custom_placeholder_service'] = [
      '#title' => $this->t('Use custom placeholder'),
      '#type' => 'checkbox',
      '#default_value' => $config->get('use_custom_placeholder_service'),
      '#states' => [
        'visible' => [
          ':input[name="enabled"]' => ['checked' => TRUE],
        ],
      ],
    ];

    $form['custom_placeholder_service'] = [
      '#title' => $this->t('Custom placeholder service'),
      '#description' => $this->t('Placeholders [width] and [height] can be used. For example: %url.', ['%url' => 'https://placekitten.com/[width]/[height]']),
      '#type' => 'url',
      '#default_value' => $config->get('custom_placeholder_service'),
      '#states' => [
        'visible' => [
          ':input[name="enabled"]' => ['checked' => TRUE],
          ':input[name="use_custom_placeholder_service"]' => ['checked' => TRUE],
        ],
      ],
    ];

    $form['unique'] = [
      '#title' => $this->t('Unique image'),
      '#description' => $this->t('Add a hash to the image url to (try and) make sure you get a fresh image each page load.'),
      '#type' => 'checkbox',
      '#default_value' => $config->get('unique'),
      '#states' => [
        'visible' => [
          ':input[name="enabled"]' => ['checked' => TRUE],
        ],
      ],
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

    // Get the submitted values.
    $values = $form_state->getValues();

    // Set the predefined placeholder service to none if using a custom one.
    if (!empty($values['use_custom_placeholder_service'])) {
      $form_state->setValue('predefined_placeholder_service', '_none');
    }

    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    // Get the submitted values.
    $values = $form_state->getValues();

    // Save the configuration.
    $this->config('replace_missing_images.settings')
      ->set('enabled', $values['enabled'])
      ->set('predefined_placeholder_service', $values['predefined_placeholder_service'])
      ->set('replace_all', $values['replace_all'])
      ->set('use_custom_placeholder_service', $values['use_custom_placeholder_service'])
      ->set('custom_placeholder_service', $values['custom_placeholder_service'])
      ->set('default_placeholder_image_width', $values['default_placeholder_image_width'])
      ->set('default_placeholder_image_height', $values['default_placeholder_image_height'])
      ->set('unique', $values['unique'])
      ->save();

    parent::submitForm($form, $form_state);
  }

  /**
   * Get the default placeholder links to use.
   */
  private function getDefaultPlaceholderLinks() {
    return [
      '_none' => $this->t('- None -'),
      'https://baconmockup.com/[width]/[height]' => 'Baconmockup',
      'https://dummyimage.com/[width]x[height]' => 'Dummy image',
      'https://fakeimg.pl/[width]/[height]' => 'Fake images please?',
      'https://www.fillmurray.com/[width]/[height]' => 'Fill murray',
      'https://imgplaceholder.com/[width]/[height]' => 'Imgplaceholder',
      'https://ipsumimage.appspot.com/[width]x[height]' => 'Ipsum image',
      'https://picsum.photos/[width]/[height]' => 'Lorem picsum',
      'https://loremflickr.com/[width]/[height]' => 'Loremflickr',
      'http://lorempixel.com/[width]/[height]' => 'Lorempixel',
      'https://placebear.com/[width]/[height]' => 'Placebear',
      'https://placebeard.it/[width]x[height]' => 'Placebeard.it',
      'https://www.placecage.com/[width]/[height]' => 'Placecage',
      'http://via.placeholder.com/[width]x[height]' => 'Placeholder',
      'http://placeimg.com/[width]/[height]/any' => 'Placeimg',
      'https://placekitten.com/g/[width]/[height]' => 'Placekitten',
      'https://placezombie.com/[width]x[height]' => 'Placezombie',
      'https://www.stevensegallery.com/[width]/[height]' => 'Steven Segallery',
    ];
  }

}
