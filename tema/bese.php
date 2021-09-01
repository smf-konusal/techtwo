<?php

namespace HUU;

class Bese {
	public function yukle()
	{
		global $settings;
		
		Tema::yukle();

		if(!empty($settings['bese_allow_color_select']) != 0){
			add_integration_function('integrate_load_theme', self::class.'::addCustomColorVars', false);
		}
	}

	public function addCustomColorVars()
	{
		global $settings;

		$color_key = 'bese_color_';
		$colors = array();

		foreach ($settings as $key => $setting)
		{
			if (substr($key, 0, strlen($color_key)) !== $color_key || empty($setting))
				continue;

			$color_name = str_replace(
				array('bese_', '_'),
				array('', '-'),
				$key
			);

			$hsl = huu_hex_to_hsl($setting);
			$colors["--$color_name-h"] = $hsl[0] . 'deg';
			$colors["--$color_name-s"] = $hsl[1] * 100 . '%';
			$colors["--$color_name-l"] = $hsl[2] * 100 . '%';
			$colors["--$color_name"] = "hsl(var(--$color_name-h), var(--$color_name-s), var(--$color_name-l))";
		}

		$css = '';

		foreach ($colors as $color => $value)
			$css .= "$color: $value;\n";


		addInlineCss(":root {{$css}}");
	}
}