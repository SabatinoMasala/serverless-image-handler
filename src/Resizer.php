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
        if (empty(config('serverless-image-handler.base_url'))) {
            throw new \Exception('serverless-image-handler.base_url not set, set the CLOUDFRONT_URL environment variable');
        }
        if (empty(config('serverless-image-handler.bucket'))) {
            throw new \Exception('serverless-image-handler.bucket not set, set the AWS_BUCKET environment variable');
        }
        $body = [
            'bucket' => config('serverless-image-handler.bucket'),
            'key' => $this->key,
            'edits' => $this->edits,
        ];
        $base = config('serverless-image-handler.base_url');
        if (substr($base, -1) !== '/') {
            $base .= '/';
        }
        return $base . base64_encode(json_encode($body));
    }

    /**
     * @param $key
     * @return Resizer
     */
    static function make($key): Resizer {
        return new Resizer($key);
    }
}
