<?php

namespace Drupal\d8_routing_demo\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;

/**
 * 
 */
class WeatherConfigForm extends ConfigFormBase {
    public function getFormId() {
        return 'd8_routing_demo_weather_config_form';
    }
    protected function getEditableConfigNames() {
        return [
          'd8_routing_demo.weather',
          'asdfasdfasdf',
          'asdfasfdasdf'
        ];
      }
    public function buildForm(array $form, FormStateInterface $form_state) {
        $form ['app_id'] = [
            '#type' => 'textfield',
            '#title' => t('Enter AppID'),
            '#size' => 60,
            '#maxlength' => 128,
            '#required' => TRUE,
            '#default_value' => $this->config('d8_routing_demo.weather')->get('app_id')
        ];
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => t('Submit')
        ];
        return $form;
    }
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $this->config('d8_routing_demo.weather')->set('app_id', $form_state->getValue('app_id'))->save();
        parent::submitForm($form, $form_state);
    }
}