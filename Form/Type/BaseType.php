<?php

namespace Kamran\TestBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
//use Symfony\Component\Form\CallbackTransformer;

class BaseType extends AbstractType
{

    public $fields;
    public $class;
    public $workingEvents;
    public $formConfigOptions;

    public function __construct($fields, $configOptions = array() , $class){
        $this->fields = $fields;
        $this->class = $class;
        $this->workingEvents = array();
        $this->formConfigOptions = $configOptions;
    }

    public function buildForm(FormBuilderInterface $builder, array $options){
        
        foreach($this->fields as $id => $options){
            $type = null;
            if(array_key_exists('type', $options)){
                $type = $options['type'];
                unset($options['type']);
            }
            $builder->add($id, $type , $options);
        }

        if(array_key_exists('presetdata', $this->workingEvents)){
            /*$builder->addEventListener(Form::presetdata , function(FormEvents $event){
            });*/
        }

        // data transformer work here
        //$builder->addViewTransformer();
        //$builder->addModelTransformer();
        


    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        /*foreach($this->variables as $key=>$value){
            $view->vars[$key] = $value;
        }*/
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        //echo $this->class;
        $resolver->setDefaults(array(
            'data_class' => $this->class,
        ));
    }

    public function getName()
    {
        $formname = array_key_exists('name', $this->formConfigOptions['form']) ? $this->formConfigOptions['form']['name'] : 'form_name';    
        return $formname;
    }

}