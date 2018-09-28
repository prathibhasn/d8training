<?php

namespace Drupal\d8_routing_demo\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\d8_routing_demo\Controller\DataController;
/**
 * 
 */
class DIForm extends FormBase {
    protected $dc;
    public function __construct(DataController $dc) {
        $this->dc = $dc;
    }
    public function getFormId() {
        return 'd8_routing_demo_di_form';
    }
    public function buildForm(array $form, FormStateInterface $form_state) {
        $last_value = $this->dc->getLastEntry();
        $form['first_name'] = [
            '#type' => 'textfield',
            '#title' => t('Enter First name'),
            '#size' => 60,
            '#maxlength' => 128,
            '#required' => TRUE,
            '#default_value' => $last_value->first_name
        ];
        $form['last_name'] = [
            '#type' => 'textfield',
            '#title' => t('Enter Last name'),
            '#size' => 60,
            '#maxlength' => 128,
            '#required' => TRUE,
            '#default_value' => $last_value->last_name
        ];
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => t('Submit')
        ];
        return $form;
    }
    /**
     * 
     */
    public static function create(ContainerInterface $container) {
        return new static(
        $container->get('d8_routing_demo.data_controller')
        );
    }
    public function validateForm(array &$form, FormStateInterface $form_state) {
        /*if (strlen($form_state->getValue('demo_textfield')) < 5) {
            $form_state->setErrorByName('demo_textfield', 'Error in number of characters');
        }*/
    }
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $this->dc->insertToTable(
            $form_state->getValue('first_name'),
            $form_state->getValue('last_name')
        );
        $this->messenger()->addMessage(
            $this->t('Form submitted successfully.')
            );
    }
}