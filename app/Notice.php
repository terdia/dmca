<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model {

    /**
     * Fillable fields for a new notice
     *
     * @var array
     */
    protected $fillable =
        ['provider_id', 'infringing_title',
            'infringing_link', 'original_link',
            'original_description', 'template',
            'content_removed'
        ];

    /**
     * Open a new notice
     *
     * @param array $attributes
     * @return static
     */
	public static function open(array $attributes){
        return new static($attributes);
    }

    /**
     * Set the email template for the notice
     * @param $template
     * @return mixed
     */
    public function useTemplate($template){
        $this->template = $template;

        return $this;
    }

}
