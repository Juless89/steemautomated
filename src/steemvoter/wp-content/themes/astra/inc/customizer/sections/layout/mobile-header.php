<?php
/**
 * General Options for Astra Theme Mobile Header.
 *
 * @package     Astra
 * @author      Astra
 * @copyright   Copyright (c) 2018, Astra
 * @link        http://wpastra.com/
 * @since       Astra 1.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Learn More link if Astra Pro is not activated.
if ( ! defined( 'ASTRA_EXT_VER' ) ) {

	/**
	 * Option: Divider
	 */
	$wp_customize->add_control(
		new Astra_Control_Divider(
			$wp_customize, ASTRA_THEME_SETTINGS . '[mobile-header-more-feature-divider]', array(
				'type'     => 'ast-divider',
				'section'  => 'section-mobile-header',
				'priority' => 999,
				'settings' => array(),
			)
		)
	);
	/**
	 * Option: Learn More about Mobile Header
	 */
	$wp_customize->add_control(
		new Astra_Control_Description(
			$wp_customize, ASTRA_THEME_SETTINGS . '[mobile-header-more-feature-description]', array(
				'type'     => 'ast-description',
				'section'  => 'section-mobile-header',
				'priority' => 999,
				'label'    => '',
				'help'     => '<p>' . __( 'More Options Available for Mobile Header in Astra Pro!', 'astra' ) . '</p><a href="' . astra_get_pro_url( 'https://wpastra.com/docs/mobile-header-with-astra/', 'customizer', 'learn-more', 'upgrade-to-pro' ) . '" class="button button-primary"  target="_blank" rel="noopener">' . __( 'Learn More', 'astra' ) . '</a>',
				'settings' => array(),
			)
		)
	);
}

