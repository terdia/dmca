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

    /**
     * A notice belongs to a recipient / provider
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipient(){
        return $this->belongsTo('App\Provider', 'provider_id');
    }

    /**
     * Get the email address of the recipient
     *
     * @return mixed
     */
    public function getRecipientEmail(){
        return $this->recipient->copyright_email;
    }

    /**
     * A notice is created by a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\User');
    }

    /**
     * Get the email address of the notice
     *
     * @return mixed
     */
    public function getOwnerEmail(){
        return $this->user->email;
    }

}
