<?php
/**
 * @class FLMapModule
 */
class TPzoomModule extends FLBuilderModule {

	/**
	 * @property $data
	 */
	public $data = null;

	/**
	 * @method __construct
	 */
	public function __construct()
	{
		parent::__construct(array(
			'name'          => __('Zoom on photo', 'bbzoom'),
			'description'   => __('Add Zoom effect on picture.', 'bbzoom'),
			'category'      => __('Advanced Modules', 'bbzoom'),
            'dir'           => TP_BB_ZOOM_DIR .'tpbbzoom/',
            'url'           => TP_BB_ZOOM_URL .'tpbbzoom/',
		));

		$this->add_js( 'bb-zoom',         $this->url .'assets/js/jquery.zoom.min.js', array('jquery'), null, null );
		$this->add_css( 'bb-zoom',         $this->url .'assets/css/style.css' );
		//$this->add_js( 'bb-zoom-script',  $this->url .'assets/js/script.js', array('bb-zoom'), null, null );
	}

    /**
     * @method update
     * @param $settings {object}
     */
    public function update($settings)
    {
        // Make sure we have a photo_src property.
        if(!isset($settings->photo_src)) {
            $settings->photo_src = '';
        }

        if( empty($settings->magnify) ) {
            $settings->magnify = '1.5';
        }

        // Cache the attachment data.
        $data = FLBuilderPhoto::get_attachment_data($settings->photo);

        if($data) {
            $settings->data = $data;
        }

        return $settings;
    }

    /**
     * @method get_data
     */
    public function get_data()
    {
        if(!$this->data)
        {
            if(is_object($this->settings->photo)) {
                $this->data = $this->settings->photo;
            }
            else {
                $this->data = FLBuilderPhoto::get_attachment_data($this->settings->photo);
            }

            // Data object is empty, use the settings cache.
            if(!$this->data && isset($this->settings->data)) {
                $this->data = $this->settings->data;
            }
        }

        return $this->data;
    }

    /**
     * @method get_src
     */
    public function get_src()
    {
        return $this->settings->photo_src;
    }

    /**
     * @method get_alt
     */
    public function get_alt()
    {
        $photo = $this->get_data();

        if(!empty($photo->alt)) {
            return htmlspecialchars($photo->alt);
        }
        else if(!empty($photo->description)) {
            return htmlspecialchars($photo->description);
        }
        else if(!empty($photo->caption)) {
            return htmlspecialchars($photo->caption);
        }
        else if(!empty($photo->title)) {
            return htmlspecialchars($photo->title);
        }
    }

    /**
     * @method get_attributes
     */
    public function get_attributes()
    {
        $attrs = '';

        if ( isset( $this->settings->attributes ) ) {
            foreach ( $this->settings->attributes as $key => $val ) {
                $attrs .= $key . '="' . $val . '" ';
            }
        }

        return $attrs;
    }
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('TPzoomModule', array(
	'general'       => array(
		'title'         => __('General', 'bbzoom'),
		'sections'      => array(
			'general'       => array(
				'title'         => '',
				'fields'        => array(
					'photo'       => array(
						'type'          => 'photo',
						'label'         => __('Photo', 'bbzoom'),
						'show_remove'   => false
					),
                    'touch' => array(
                        'type'          => 'select',
                        'label'         => __( 'Touch', 'bbzoom' ),
                        'description'   => __( 'Enables interaction via touch events.', 'bbzoom' ),
                        'default'       => '1',
                        'options'       => array(
                            '1'      => __( 'Yes', 'bbzoom' ),
                            '0'      => __( 'No', 'bbzoom' )
                        )
                    ),
                    'magnify'       => array(
                        'type'          => 'text',
                        'label'         => __('Magnify', 'bbzoom'),
                        'description'   => __('This value is multiplied against the full size of the zoomed image. The default value is 1, meaning the zoomed image should be at 100% of it\'s natural width and height.', 'bbzoom'),
                        'default'       => '1.5',
                        'placeholder'   => '1.5'
                    ),
                )
			)
		)
	)
));