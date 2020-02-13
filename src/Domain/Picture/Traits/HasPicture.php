<?php
namespace App;

trait HasPicture {
    public function picture() {

    }

    public function getThumbnailAttribute() {
        return $this->picture->thumbnail;
    }
}
