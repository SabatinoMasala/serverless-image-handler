<?php

namespace Sabatino\ServerlessImageHandler;

class Resizer {

    const FIT_CONTAIN = 'contain';
    const FIT_COVER = 'cover';
    const FIT_FILL = 'fill';
    const FIT_INSIDE = 'inside';
    const FIT_OUTSIDE = 'outside';

    protected $edits;

    public function __construct(
        public $key
    ) {
    }

    /**
     * @param $width
     * @return $this
     */
    public function setWidth($width): Resizer {
        $this->edits['resize']['width'] = $width;
        return $this;
    }

    /**
     * @param $height
     * @return $this
     */
    public function setHeight($height): Resizer {
        $this->edits['resize']['height'] = $height;
        return $this;
    }

    /**
     * @param $fit
     * @return $this
     */
    public function setFit($fit): Resizer {
        $this->edits['resize']['fit'] = $fit;
        return $this;
    }

    /**
     * @param $hex
     * @return $this
     */
    public function setFillColorHex($hex): Resizer {
        $this->edits['resize']['background'] = $hex;
        return $this;
    }

    /**
     * @param $edits
     * @return $this
     */
    public function setEdits($edits): Resizer {
        $this->edits = $edits;
        return $this;
    }

    /**
     * @param $r
     * @param $g
     * @param $b
     * @param $a
     * @return $this
     */
    public function setFillColorRgba($r, $g, $b, $a = 1): Resizer {
        $this->edits['resize']['background'] = [
            'r' => $r,
            'g' => $g,
            'b' => $b,
            'alpha' => $a,
        ];
        return $this;
    }

    /**
     * @param $hex
     * @return $this
     */
    public function setBackgroundColorHex($hex): Resizer {
        $this->edits['flatten']['background'] = $hex;
        return $this;
    }

    /**
     * @param $r
     * @param $g
     * @param $b
     * @param $a
     * @return $this
     */
    public function setBackgroundColorRgba($r, $g, $b, $a = 1): Resizer {
        $this->edits['flatten']['background'] = [
            'r' => $r,
            'g' => $g,
            'b' => $b,
            'alpha' => $a,
        ];
        return $this;
    }

    /**
     * @param $enabled
     * @return $this
     */
    public function flatten($enabled = true): Resizer {
        $this->edits['flatten'] = $enabled;
        return $this;
    }

    /**
     * @param $enabled
     * @return $this
     */
    public function grayscale($enabled = true): Resizer {
        $this->edits['grayscale'] = $enabled;
        return $this;
    }

    /**
     * @param $enabled
     * @return $this
     */
    public function flip($enabled = true): Resizer {
        $this->edits['flip'] = $enabled;
        return $this;
    }

    /**
     * @param $enabled
     * @return $this
     */
    public function flop($enabled = true): Resizer {
        $this->edits['flop'] = $enabled;
        return $this;
    }

    /**
     * @param $enabled
     * @return $this
     */
    public function negate($enabled = true): Resizer {
        $this->edits['negate'] = $enabled;
        return $this;
    }

    /**
     * @param $enabled
     * @return $this
     */
    public function normalise($enabled = true): Resizer {
        $this->edits['normalise'] = $enabled;
        return $this;
    }

    /**
     * @return string
     */
    public function url(): string
    {
        $base = 'https://d13y40po3lsi1b.cloudfront.net/';
        $body = [
            'bucket' => 'youtube-serverless-image-handler',
            'key' => $this->key,
            'edits' => $this->edits,
        ];
        return $base . base64_encode(json_encode($body));
    }

    static function make($key) {
        return new Resizer($key);
    }
}
