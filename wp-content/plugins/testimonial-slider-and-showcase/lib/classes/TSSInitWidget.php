<?php

if(!class_exists('TSSInitWidget')):

	/**
	*
	*/
	class TSSInitWidget
	{

		function __construct()
		{
			add_action( 'widgets_init', array($this, 'initWidget'));
		}


		function initWidget(){
			TSSPro()->loadWidget( TSSPro()->widgetsPath );
		}
	}


endif;
