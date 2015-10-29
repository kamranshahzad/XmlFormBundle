# XmlFormBundle
Build symfony2 forms quickly using this bundle

## Description:

This bundle provides the facility to create symfony2 forms using XML files. 
You can define all forms related schema inside XML file. This bundle translates XML schema into symfony2 forms.

This bundle was originally developed for a wrapper bundle between two components. 
First component is an Interactive Form Builder(Drag & Drop) which is developed in JavaScript. 
It will be soon available on codecanyon as a development tool(I am working on it). 
User will create his forms using Form Builder tool and export that forms as XML files. 
Second components are MVC frameworks like symfony, Laravel etc. 

Alternatively this bundle can be used for building small forms directly in symfony2. 
This bundle is used by a SettingsBundle for building settings forms.
[SettingsBundle](https://github.com/kamranshahzad/SettingBundle).



## Installation.

Using composer

``` bash
$ composer require kamran/xml-form-bundle dev-master
```
Add the KamranXmlFormBundle to your AppKernel.php file:

```
new Kamran\XmlFormBundle\KamranXmlFormBundle();
```

## How to use?

```xml
<xmlforms>
    <links>
        <link key="user_settings" order="1" attach-form="userSettingsForm" >User Settings</link>
    </links>
    <forms>
        <form id="userSettingsForm" name="tagtype_form" method="POST">
            <fields>
                <grid-size type="text" required="false" label="Grid Paging Size" ></grid-size>
                <default-role type="text" required="false" label="Default Role for Registration" ></default-role>
                <type type="choice" required="false" label="Select Tag Type" >
                    <choices>
                        <item key="1">10</item>
                        <item key="2">20</item>
                        <item key="3">25</item>
                        <item key="7">40</item>
                    </choices>
                </type>
            </fields>
        </form>
    </forms>
</xmlforms>
```

## Todo list:

* Custom DataTransformers
* Forms Validations
* Forms Submission messages
* Multi-Step forms
* Parent/Child Forms
* Popup Forms
* Forms tooltips(descriptions)
* Useful commands support

## Reporting an issue or feature request.

Issues and feature requests are tracked in the 
[Github issue tracker](https://github.com/kamranshahzad/XmlFormBundle/issues).


How to contribute?
------------------------------------
The contribution for this bundle for public is open, anybody could help me to participate 
bugs, documentation and code.



## License.
This software is licensed under the MIT license. See the complete license file in the bundle:
```
Resources/meta/LICENSE
```
[Read the License](https://github.com/kamranshahzad/XmlFormBundle/blob/master/Resources/meta/LICENSE)