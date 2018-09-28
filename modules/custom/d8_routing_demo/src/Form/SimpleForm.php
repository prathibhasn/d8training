<?php

namespace Drupal\d8_routing_demo\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * 
 */
class SimpleForm extends FormBase {
    public function getFormId() {
        return 'd8_routing_demo_simple_form';
    }
    public function buildForm(array $form, FormStateInterface $form_state) {
        $form ['demo_textfield'] = [
            '#type' => 'textfield',
            '#title' => t('Enter some text'),
            '#size' => 60,
            '#maxlength' => 128,
            '#required' => TRUE,
        ];
        $form['qualification'] = [
            '#type' => 'select',
            '#title' => t('Qualification'),
            '#options' => array(
                'ug' => t('UG'),
                'pg' => t('PG'),
                'other' => t('Other')
            )
        ];
        $form['other'] = [
            '#type' => 'textfield',
            '#title' => t('If other, specify'),
            '#size' => 40,
            '#maxlength' => 40,
            '#states' => array(
                'visible' => array(
                    ':input[name="qualification"]' => array('value' => 'other'),
                ),
            ),
        ];
        $form['country'] = [
            '#type' => 'select',
            '#title' => t('Country'),
            '#options' => array(
                'in' => t('India'),
                'uk' => t('UK'),
            )
        ];
        $form['india-states'] = [
            '#type' => 'select',
            '#title' => t('State'),
            '#options' => array(
                'jk' => t('J&K'),
                'hp' => t('Himachal'),
            ),
            '#states' => array(
                'visible' => array(
                    ':input[name="country"]' => array('value' => 'in'),
                ),
            ),
        ];
        $form['uk-states'] = [
            '#type' => 'select',
            '#title' => t('State'),
            '#options' => array(
                'sussex' => t('Sussex'),
                'manchester' => t('Manchester'),
            ),
            '#states' => array(
                'visible' => array(
                    ':input[name="country"]' => array('value' => 'uk'),
                ),
            ),
        ];
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => t('Submit')
        ];

        return $form;
    }
    public function validateForm(array &$form, FormStateInterface $form_state) {
        if (strlen($form_state->getValue('demo_textfield')) < 5) {
            $form_state->setErrorByName('demo_textfield', 'Error in number of characters');
        }
    }
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $this->messenger()->addMessage(
            $this->t('Form submitted successfully.')
        );
    }
}