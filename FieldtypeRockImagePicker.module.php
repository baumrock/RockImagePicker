<?php namespace ProcessWire;
/**
 * @author Bernhard Baumrock, 06.07.2022
 * @license Licensed under MIT
 * @link https://www.baumrock.com
 */
class FieldtypeRockImagePicker extends FieldtypeText {

  public static function getModuleInfo() {
    return [
      'title' => 'RockImagePicker',
      'version' => '0.0.1',
      'summary' => 'Fieldtype to select an image from another page',
      'icon' => 'link',
      'requires' => [],
      'installs' => [
        'InputfieldRockImagePicker',
      ],
    ];
  }

  public function init() {
    parent::init();
  }

  /** FIELDTYPE METHODS */

    /**
     * Return the fields required to configure an instance of FieldtypeText
     *
     * @param Field $field
     * @return InputfieldWrapper
     *
     */
    public function ___getConfigInputfields(Field $field) {
      $inputfields = parent::___getConfigInputfields($field);

      $inputfields->add([
        'type' => 'integer',
        'name' => 'sourcepage',
        'label' => 'Source Page',
        'icon' => 'sitemap',

        'derefAsPage' => FieldtypePage::derefAsPageOrFalse,
        'inputfield' => 'InputfieldPageListSelect',
        'findPagesSelector' => 'id>0',
        'labelFieldName' => 'title',
        'value' => $field->get('sourcepage'),
      ]);

      $inputfields->add([
        'type' => 'text',
        'name' => 'sourcefield',
        'label' => 'Source Field',
        'value' => $field->get('sourcefield'),
      ]);

      $inputfields->add([
        'type' => 'integer',
        'name' => 'thumbheight',
        'label' => 'Thumbnail Height',
        'value' => $field->get('thumbheight'),
        'notes' => 'Default is '.InputfieldRockImagePicker::defaultheight,
      ]);

      return $inputfields;
    }

    /**
     * Return the associated Inputfield
     *
     * @param Page $page
     * @param Field $field
     * @return Inputfield
     *
     */
    public function getInputfield(Page $page, Field $field) {
      return $this->wire->modules->get('InputfieldRockImagePicker');
    }

    /**
    * Sanitize value for storage
    *
    * @param Page $page
    * @param Field $field
    * @param string $value
    * @return string
    */
    public function sanitizeValue(Page $page, Field $field, $value) {
      return $value;
    }

  /** HELPER METHODS */

}
