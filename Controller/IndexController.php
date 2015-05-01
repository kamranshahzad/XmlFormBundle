<?php

namespace Kamran\XmlFormBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Yaml\Yaml;


use Kamran\TestBundle\Form\Type\BaseType;


/**
 * Test controller.
 *
 * @Route("/xmlform")
 */

class IndexController extends Controller
{

    /**
     * @Route("/", name="test_index")
     * @Template()
     */
    public function indexAction(Request $request){

        //$file = 'c:\xampp\htdocs\developer\src\Kamran\FormBundle\Resources\config\forms.yml';
        

        $entityClass = 'Kamran\TagsBundle\Entity\Tags';
        
        $form = $this->getForm( 'tagtype', $entityClass);


        return array(
            'form'   => $form->createView()
        );
        
        /*$doc = new \DOMDocument();
        $doc->validateOnParse = true;
        $doc->load($file);*/

        //echo 'abc'.$doc->getElementById('tagtype')->tagName;


        //$yaml = Yaml::parse(file_get_contents($file));



        /*$em = $this->getDoctrine();
        $entityClass = 'Kamran\TagsBundle\Entity\Tags';
        $entity = $em->getRepository('KamranTagsBundle:Tags')->find(33);

        $array = array('name','type');
        $vars = array('abc'=>'I am from controller now','yii'=>'i love you mani');

        $form = $this->createForm(new BaseType($array , $entityClass , $vars ) , $entity);

        return array(
            'form'   => $form->createView()
        );*/

        //$this->container->get('form.factory')->create($type, $data, $options);

    }



    /**
     * @Route("/add", name="test_add")
     * @Template()
     */
    public function addAction(Request $request){

        $entity = new CodeSnippet();
        $form = $this->createForm(new CodeSnippetType() ,$entity);

        if ($request->getMethod() === 'POST'){
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                echo "Data Saved";
            }
        }

        return array(
            'form'   => $form->createView()
        );
        
    }



    /*
        Helper functions
    */
    public function readFormConfig($formid){

        $file = 'c:\xampp\htdocs\developer\src\Kamran\TestBundle\Resources\config\app-forms.xml';

        if(!file_exists($file)){
            return;
        }

        $doc = simplexml_load_file($file);
        $childForms = array();
        
        foreach($doc->form as $b){
            $attr = $b->attributes();
            $formId = (string) $attr->id;
            if($formId !== ''){ 
                $childForms[$formId]['attr'] = $attr; 
                $childForms[$formId]['form'] = $b->children();
            }
        }

        return (array_key_exists($formid, $childForms)) ? $childForms[$formid] : null; 
    }    




    public function getForm($formid , $entity){

        // pre definds
        $validAttributes = array('type','label','required');

        //
        $formMeta = $this->readFormConfig($formid)['form']; 
        $formAttr = $this->readFormConfig($formid)['attr'];

        if($formMeta){

            $formFields = array();
            $configOptions = array();            

            //fetch form fields
            foreach($formMeta->fields->children() as $obj){
                
                $fieldId = $obj->getName();
                $fieldOptions = array();
                $attr = $obj->attributes();
                foreach($attr as $attrObj){
                    $attrName = $attrObj->getName();
                    $attrValue = (string) $attrObj;
                    if(in_array($attrName, $validAttributes)){
                        $fieldOptions[$attrName] = $attrValue;
                    }
                }

                //check field type
                if(array_key_exists('type', $fieldOptions) && $fieldOptions['type'] === 'choice'){
                    
                    if($obj->choices){
                        $choices = array();
                        foreach($obj->choices->children() as $item){
                            $itemValue = (string) $item;                            
                            $keyAttri = (string) $item->attributes()->key;
                            if($keyAttri){
                                $choices[$keyAttri] = $itemValue; 
                            }else{
                                $choices[] = $itemValue; 
                            }
                        }
                        $fieldOptions['choices'] = $choices;
                    }else{
                        // classes 
                        // query_builder
                    }

                }

                $formFields[$fieldId] = $fieldOptions;


                if($obj->count()){
                    //put deep logic here...
                }

            } //end of fields 


            //get form attributes
            $formAttriArray = array();
            foreach($formAttr as $attri){
                $formAttriArray[$attri->getName()] = (string)$attri;
            }
            
            $configOptions['form'] = $formAttriArray;

            
            //get form config's
            $defaults = array();
            $vars = array();
            foreach($formMeta->config->children() as $config){

                if('default' === $config->getName()){
                    
                    foreach($config->children() as $child){
                        $option = $child->getName();
                        $defaults[$option] = (string)$child;
                    }
                }

                if('vars' === $config->getName()){
                    
                    foreach($config->children() as $child){
                        $option = $child->getName();
                        $vars[$option] = (string)$child;
                    }
                }
                
            }
            $configOptions['default'] = $defaults;
            $configOptions['vars'] = $vars;  

            // get <all>
            foreach($formMeta->config->children() as $config){

            }                       


            /*echo '<pre>';
            print_r($configOptions);
            echo '</pre>';*/

            return $this->createForm(new BaseType($formFields , $configOptions , $entity  ) );
        }
        
        return null;
    }



}
