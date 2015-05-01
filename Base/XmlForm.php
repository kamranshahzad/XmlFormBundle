<?php

namespace Kamran\XmlFormBundle\Base;


class XmlForm
{
    const FORM_FILE_POSTFIX = '_xmlform';

    public function __construct(XmlFormParser $parser){}

    public function getForm($formid){
        return 'abc';
    }



}