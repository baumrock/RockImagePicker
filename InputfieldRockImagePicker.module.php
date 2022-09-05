<?php namespace ProcessWire;
/**
 * @author Bernhard Baumrock, 06.07.2022
 * @license Licensed under MIT
 * @link https://www.baumrock.com
 */
class InputfieldRockImagePicker extends InputfieldText {

  const defaultheight = 50;

  public static function getModuleInfo() {
    return [
      'title' => 'RockImagePicker Inputfield',
      'version' => '0.0.1',
      'summary' => 'Inputfield for picking image from other pages',
      'icon' => 'link',
      'requires' => [
        'FieldtypeRockImagePicker',
      ],
      'installs' => [],
    ];
  }

  /**
  * Render the Inputfield
  * @return string
  */
  public function ___render() {
    $field = $this->hasField;
    $sourcepage = $this->wire->pages->get($field->sourcepage);
    $sourcefield = $field->sourcefield;

    $f = new InputfieldSelect();
    $f->id = $this->id;
    $f->name = $this->name;
    $f->value = $this->value;

    // get images
    $images = $sourcepage->getUnformatted($sourcefield);
    foreach($images as $img) {
      $f->addOption($img->basename, $img->basename, [
        'data-img-src' => $img->url,
      ]);
    }

    $height = $field->thumbheight ?: self::defaultheight;

    return "<style>
        #wrap_{$f->id} .thumbnail img { height: {$height}px; }
        #wrap_{$f->id} .thumbnail { margin: 5px; }
        #wrap_{$f->id} .thumbnails li { margin: 0; }
        #wrap_{$f->id} .thumbnail.selected {
          background: white;
          outline: 5px solid #afafaf;
        }
      </style>"
      .$f->render()
      ."<p class=notes>Manage items <a href={$sourcepage->editUrl}&field=$sourcefield target=_blank>here</a></p>"
      ."<script>$('#{$f->id}').imagepicker();</script>";
  }

	public function renderReady(Inputfield $parent = null, $renderValueMode = false) {
    $url = $this->wire->config->urls($this);
    $this->wire->config->scripts->add($url."image-picker/image-picker.min.js");
    $this->wire->config->styles->add($url."image-picker/image-picker.css");
    parent::renderReady($parent, $renderValueMode);
  }

}
