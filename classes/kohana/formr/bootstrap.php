<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Kohana_Formr_Bootstrap class.
 *
 * @extends Kohana_Formr
 */
class Kohana_Formr_Bootstrap extends Kohana_Formr
{
	/**
	 * open function.
	 *
	 * @access protected
	 * @static
	 * @param string $path (default: '')
	 * @param array $array (default: array())
	 * @return void
	 */
	protected static function open($path = '', array $array = array())
	{
		$defaults = array('class' => 'well form-horizontal', 'method' => false);

		$options = array_merge($defaults, $array);

		$output = Form::open(null, array('enctype' => $options['enctype'], 'method' => ($options['method'] ? $options['method'] : 'post'), 'class' => $options['class']));
		$output .= '<fieldset>';
		$output .= '<legend>'.$options['legend'].'</legend>';

		return $output;
	}

	/**
	 * close function.
	 *
	 * @access protected
	 * @static
	 * @return void
	 */
	protected static function close()
	{
		$output = '</fieldset>';
		$output .= '</form>';

		return $output;
	}

	/**
	 * actions function.
	 *
	 * @access protected
	 * @static
	 * @return void
	 */
	protected static function actions()
	{
		$output = '<div class="form-actions">';
		$output .= self::submit();
		$output .= self::reset();
		$output .= '</div>';

		return $output;
	}

	/**
	 * hidden function.
	 *
	 * @access protected
	 * @static
	 * @param mixed $column
	 * @return void
	 */
	protected static function hidden($column)
	{
		$output = Form::hidden($column['column_name'],(self::$_object->{$column['column_name']} ? self::$_object->{$column['column_name']} : (isset($column['default']) ? $column['default'] : '')));

		return $output;
	}

	/**
	 * number function.
	 *
	 * @access protected
	 * @static
	 * @param mixed $column
	 * @return void
	 * @todo add attributes merge
	 */
	protected static function number($column)
	{
		$disabled = in_array($column['column_name'], self::$_options['disabled']) ? array('disabled' => true) : array();

		$output = '<div class="control-group'.(isset(self::$_options['errors'][$column['column_name']]) ? ' error': '').'">';
		$output .= self::label($column);
		$output .= '<div class="controls">';

		$output .= Form::input($column['column_name'],(self::$_object->{$column['column_name']} ? self::$_object->{$column['column_name']} : (isset($column['default']) ? $column['default'] : '')),
			Arr::merge(array(
				'type' => 'number',
				'min' => (isset($column['min']) ? $column['min'] : 0),
				'max' => (isset($column['max']) ? $column['max'] : 99999999999999),
				'step' => '0.01',
				'class' => 'number '.self::$_options['classes'][$column['column_name']],
			), $disabled));

		$output .= (isset(self::$_options['help'][$column['column_name']]) or isset(self::$_options['errors'][$column['column_name']])) ? '<p class="help-block">'.(isset(self::$_options['errors'][$column['column_name']]) ? self::$_options['errors'][$column['column_name']]: self::$_options['help'][$column['column_name']]).'</p>' : '';

		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}
	
	protected static function int($column)
	{
		$disabled = in_array($column['column_name'], self::$_options['disabled']) ? array('disabled' => true) : array();

		$output = '<div class="control-group'.(isset(self::$_options['errors'][$column['column_name']]) ? ' error': '').'">';
		$output .= self::label($column);
		$output .= '<div class="controls">';

		$output .= Form::input($column['column_name'],(self::$_object->{$column['column_name']} ? self::$_object->{$column['column_name']} : (isset($column['default']) ? $column['default'] : '')),
			Arr::merge(array(
				'type' => 'number',
				'min' => (isset($column['min']) ? $column['min'] : 0),
				'max' => (isset($column['max']) ? $column['max'] : 99999999999999),
				'step' => '1',
				'class' => 'number '.self::$_options['classes'][$column['column_name']],
			), $disabled));

		$output .= (isset(self::$_options['help'][$column['column_name']]) or isset(self::$_options['errors'][$column['column_name']])) ? '<p class="help-block">'.(isset(self::$_options['errors'][$column['column_name']]) ? self::$_options['errors'][$column['column_name']]: self::$_options['help'][$column['column_name']]).'</p>' : '';

		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	/**
	 * date function.
	 *
	 * @access protected
	 * @static
	 * @param mixed $column
	 * @return void
	 */
	protected static function date($column)
	{
		$disabled = in_array($column['column_name'], self::$_options['disabled']) ? array('disabled' => true) : array();

		$value = (self::$_object->{$column['column_name']}
		? (is_numeric(self::$_object->{$column['column_name']}) ? date('m/d/Y',self::$_object->{$column['column_name']}) : self::$_object->{$column['column_name']})
		: (isset($column['default']) ? $column['default'] : ''));

		$output = '<div class="control-group'.(isset(self::$_options['errors'][$column['column_name']]) ? ' error': '').'">';
		$output .= self::label($column);
		$output .= '<div class="controls">';

		$output .= Form::input($column['column_name'], $value,
			Arr::merge(array(
				'type' => 'date',
				'class' => 'date '.self::$_options['classes'][$column['column_name']],
			), $disabled));

		$output .= (isset(self::$_options['help'][$column['column_name']]) or isset(self::$_options['errors'][$column['column_name']])) ? '<p class="help-block">'.(isset(self::$_options['errors'][$column['column_name']]) ? self::$_options['errors'][$column['column_name']]: self::$_options['help'][$column['column_name']]).'</p>' : '';

		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}
	
	
	protected static function datetime($column)
	{
		$disabled = in_array($column['column_name'], self::$_options['disabled']) ? array('disabled' => true) : array();

		$value = (self::$_object->{$column['column_name']}
		? (is_numeric(self::$_object->{$column['column_name']}) ? date('m/d/Y',self::$_object->{$column['column_name']}) : self::$_object->{$column['column_name']})
		: (isset($column['default']) ? $column['default'] : ''));

		$output = '<div class="control-group'.(isset(self::$_options['errors'][$column['column_name']]) ? ' error': '').'">';
		$output .= self::label($column);
		$output .= '<div class="controls">';

		$output .= Form::input($column['column_name'], $value,
			Arr::merge(array(
				'type' => 'datetime',
				'class' => 'datetime '.self::$_options['classes'][$column['column_name']],
			), $disabled));

		$output .= (isset(self::$_options['help'][$column['column_name']]) or isset(self::$_options['errors'][$column['column_name']])) ? '<p class="help-block">'.(isset(self::$_options['errors'][$column['column_name']]) ? self::$_options['errors'][$column['column_name']]: self::$_options['help'][$column['column_name']]).'</p>' : '';

		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	/**
	 * email function.
	 *
	 * @access protected
	 * @static
	 * @param mixed $column
	 * @return void
	 */
	protected static function email($column)
	{
		$disabled = in_array($column['column_name'], self::$_options['disabled']) ? array('disabled' => true) : array();

		$value = (self::$_object->{$column['column_name']}
		? self::$_object->{$column['column_name']}
		: (isset($column['default']) ? $column['default'] : ''));

		$output = '<div class="control-group'.(isset(self::$_options['errors'][$column['column_name']]) ? ' error': '').'">';
		$output .= self::label($column);
		$output .= '<div class="controls">';

		$output .= Form::input($column['column_name'], $value,
			Arr::merge(array(
				'type' => 'email',
				'class' => 'email '.self::$_options['classes'][$column['column_name']],
			), $disabled));

		$output .= (isset(self::$_options['help'][$column['column_name']]) or isset(self::$_options['errors'][$column['column_name']])) ? '<p class="help-block">'.(isset(self::$_options['errors'][$column['column_name']]) ? self::$_options['errors'][$column['column_name']]: self::$_options['help'][$column['column_name']]).'</p>' : '';

		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}
	
	protected static function color($column)
	{
		$disabled = in_array($column['column_name'], self::$_options['disabled']) ? array('disabled' => true) : array();

		$value = (self::$_object->{$column['column_name']}
		? self::$_object->{$column['column_name']}
		: (isset($column['default']) ? $column['default'] : ''));

		$output = '<div class="control-group'.(isset(self::$_options['errors'][$column['column_name']]) ? ' error': '').'">';
		$output .= self::label($column);
		$output .= '<div class="controls">';

		$output .= Form::input($column['column_name'], $value,
			Arr::merge(array(
				'type' => 'color',
				'class' => 'color '.self::$_options['classes'][$column['column_name']],
				'style' => 'height: 20px; width: 20px;'
			), $disabled));

		$output .= (isset(self::$_options['help'][$column['column_name']]) or isset(self::$_options['errors'][$column['column_name']])) ? '<p class="help-block">'.(isset(self::$_options['errors'][$column['column_name']]) ? self::$_options['errors'][$column['column_name']]: self::$_options['help'][$column['column_name']]).'</p>' : '';

		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	/**
	 * varchar function.
	 *
	 * @access protected
	 * @static
	 * @param mixed $column
	 * @return void
	 */
	protected static function varchar($column)
	{
		$disabled = in_array($column['column_name'], self::$_options['disabled']) ? array('disabled' => true) : array();

		$output = '<div class="control-group'.(isset(self::$_options['errors'][$column['column_name']]) ? ' error': '').'">';
		$output .= self::label($column);
		$output .= '<div class="controls">';

		$output .= Form::input($column['column_name'],(isset(self::$_object->{$column['column_name']}) ? self::$_object->{$column['column_name']} : (isset($column['default']) ? $column['default'] : '')),
			Arr::merge(array(
				'class' => self::$_options['classes'][$column['column_name']],
				'maxlength' => isset($column['character_maximum_length']) ? $column['character_maximum_length'] : '8000',
			), $disabled));

		$output .= (isset(self::$_options['help'][$column['column_name']]) or isset(self::$_options['errors'][$column['column_name']])) ? '<p class="help-block">'.(isset(self::$_options['errors'][$column['column_name']]) ? self::$_options['errors'][$column['column_name']]: self::$_options['help'][$column['column_name']]).'</p>' : '';
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	/**
	 * password function.
	 *
	 * @access protected
	 * @static
	 * @param mixed $column
	 * @return void
	 */
	protected static function password($column)
	{
		$disabled = in_array($column['column_name'], self::$_options['disabled']) ? array('disabled' => true) : array();

		$output = '<div class="control-group'.(isset(self::$_options['errors'][$column['column_name']]) ? ' error': '').'">';
		$output .= self::label($column);
		$output .= '<div class="controls">';

		$output .= Form::password($column['column_name'], null,
			Arr::merge(array(
				'class' => self::$_options['classes'][$column['column_name']],
				'maxlength' => $column['character_maximum_length'],
			), $disabled));

		$output .= (isset(self::$_options['help'][$column['column_name']]) or isset(self::$_options['errors'][$column['column_name']])) ? '<p class="help-block">'.(isset(self::$_options['errors'][$column['column_name']]) ? self::$_options['errors'][$column['column_name']]: self::$_options['help'][$column['column_name']]).'</p>' : '';
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	/**
	 * text function.
	 *
	 * @access protected
	 * @static
	 * @param mixed $column
	 * @return void
	 */
	protected static function text($column)
	{
		$disabled = in_array($column['column_name'], self::$_options['disabled']) ? array('disabled' => true) : array();

		$output = '<div class="control-group'.(isset(self::$_options['errors'][$column['column_name']]) ? ' error': '').'">';
		$output .= self::label($column);
		$output .= '<div class="controls">';

		$output .= Form::textarea($column['column_name'],(self::$_object->{$column['column_name']} ? self::$_object->{$column['column_name']} : (isset($column['default']) ? $column['default'] : '')),
			Arr::merge(array(
				'class' => self::$_options['classes'][$column['column_name']],
				'maxlength' => isset($column['character_maximum_length']) ? $column['character_maximum_length'] : 8000,
			), $disabled));

		$output .= (isset(self::$_options['help'][$column['column_name']]) or isset(self::$_options['errors'][$column['column_name']])) ? '<p class="help-block">'.(isset(self::$_options['errors'][$column['column_name']]) ? self::$_options['errors'][$column['column_name']]: self::$_options['help'][$column['column_name']]).'</p>' : '';
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	/**
	 * checkbox function.
	 *
	 * @access protected
	 * @static
	 * @param mixed $column
	 * @return void
	 */
	protected static function checkbox($column)
	{
		$disabled = in_array($column['column_name'], self::$_options['disabled']) ? array('disabled' => true) : array();

		$output  = '<div class="control-group">';
        $output .= '<label class="control-label" for="'.$column['column_name'].'">'.ucwords($column['column_name']).'</label>';
        $output .= '<div class="controls">';
		$output .= '<label class="checkbox">';

		$output .= '<input type="checkbox" name="'.$column['column_name'].'" id="'.$column['column_name'].'" value="1"'.( (boolean) self::$_object->{$column['column_name']} ? 'checked' : false).' class="'.self::$_options['classes'][$column['column_name']].(isset(self::$_options['disabled'][$column['column_name']]) ? ' disabled' : false).' "/>';

        $output .= (isset(self::$_options['help'][$column['column_name']]) or isset(self::$_options['errors'][$column['column_name']])) ? (isset(self::$_options['errors'][$column['column_name']]) ? self::$_options['errors'][$column['column_name']]: self::$_options['help'][$column['column_name']]) : '';
		$output .= '</label>';
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	/**
	 * file function.
	 *
	 * @access protected
	 * @static
	 * @param mixed $column
	 * @return void
	 */
	protected static function file($column)
	{
		$disabled = in_array($column['column_name'], self::$_options['disabled']) ? array('disabled' => true) : array();

		$output = '<div class="control-group'.(isset(self::$_options['errors'][$column['column_name']]) ? ' error': '').'">';
		$output .= self::label($column);
		$output .= '<div class="controls">';
		$output .= Form::file($column['column_name'],
			Arr::merge(array(
				'class' => 'input-file '.self::$_options['classes'][$column['column_name']],
			), $disabled));
		$output .= (isset(self::$_options['help'][$column['column_name']]) or isset(self::$_options['errors'][$column['column_name']])) ? '<p class="help-block">'.(isset(self::$_options['errors'][$column['column_name']]) ? self::$_options['errors'][$column['column_name']]: self::$_options['help'][$column['column_name']]).'</p>' : '';
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	/**
	 * enum function.
	 *
	 * @access protected
	 * @static
	 * @param mixed $column
	 * @return void
	 */
	protected static function enum($column)
	{
		$disabled = in_array($column['column_name'], self::$_options['disabled']) ? array('disabled' => true) : array();

		$output = '';

		$options = array();

		foreach($column['options'] as $option)
		{
			$options[$option] = $option;
		}
		unset($option);

		$attributes = $disabled;

		if (self::$_object->{$column['column_name']} === NULL)
		{
			$selected = $column['column_default'];
		}
		else
		{
			$selected = self::$_object->{$column['column_name']};
		}

		$output .= '<div class="control-group'.(isset(self::$_options['errors'][$column['column_name']]) ? ' error': '').'">';
		$output .= self::label(array('column_name' => $column['column_name']));
		$output .= '<div class="controls">';
		$output .= Form::select($column['column_name'], $options, $selected, $attributes);
		$output .= (isset(self::$_options['help'][$column['column_name']]) or isset(self::$_options['errors'][$column['column_name']]))
		? '<p class="help-block">'.(isset(self::$_options['errors'][$column['column_name']]) ? self::$_options['errors'][$column['column_name']]: self::$_options['help'][$column['column_name']]).'</p>'
		: '';
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	/**
	 * select function.
	 *
	 * @access protected
	 * @static
	 * @param mixed $relation
	 * @param bool $multi (default: false)
	 * @return void
	 * @todo add disabled
	 */
	protected static function select($relation, $multi = false)
	{
		$disabled = in_array($relation['model'], self::$_options['disabled']) ? array('disabled' => true) : array();

		$output = '';

		if( (bool) ORM::factory($relation['model'])->count_all())
		{
			if ($multi)
			{
				$options = array();
			}
			else
			{
				$options = array('0' => '-- '.$relation['model'].' --');
			}

			$model = ORM::factory($relation['model']);

			if (isset(self::$_options['group_by'][$relation['relation_name']]))
			{
				$group = preg_replace("/&#?[a-z0-9]{2,8};/i","",self::$_options['group_by'][$relation['relation_name']]);

				foreach(ORM::factory($relation['model'])->find_all() as $option)
				{
					$options[$option->{$group}->name][ (string) $option->{$model->primary_key()}] = preg_replace("/&#?[a-z0-9]{2,8};/i","",$option->name);
				}
				unset($option);
			}
			else
			{
				foreach(ORM::factory($relation['model'])->find_all() as $option)
				{
					$options[ (string) $option->{$model->primary_key()}] = $option->name;
				}
				unset($option);
			}

			$attributes = ($multi) ? array('multiple' => 'multiple') : array();

			$attributes['name'] = $name = ($multi) ? $model->object_plural().'[]' : $relation['foreign_key'];
			
			$attributes['class'] = isset(self::$_options['classes'][$relation['relation_name']]) ? self::$_options['classes'][$relation['relation_name']] : '';

			if ($_POST)
			{
				if ($multi)
				{
					$selected = isset($_POST[str_replace('[]','',$name)]) ? $_POST[str_replace('[]','',$name)] : array();
				}
				else
				{
					$selected = isset($_POST[$name]) ? $_POST[$name] : array();
				}
			}
			else
			{
				if ($multi)
				{
					$selected = array();

					foreach(self::$_object->{$relation['relation_name']}->find_all() as $related)
					{
						array_push($selected, $related->pk());
					}
					unset($related);
				}
				else
				{
					$selected = self::$_object->{$relation['relation_name']}->pk();
				}
			}

			$output .= '<div class="control-group'.(isset(self::$_options['errors'][$relation['model']]) ? ' error': '').'">';
			$output .= self::label(array('column_name' => $relation['relation_name']));
			$output .= '<div class="controls">';
			$output .= Form::select($name, $options, $selected, $attributes);
			$output .= (isset(self::$_options['help'][$relation['model']]) or isset(self::$_options['errors'][$relation['model']]))
			? '<p class="help-block">'.(isset(self::$_options['errors'][$relation['model']]) ? self::$_options['errors'][$relation['model']]: self::$_options['help'][$relation['model']]).'</p>'
			: '';
			$output .= '</div>';
			$output .= '</div>';

		}

		return $output;
	}

	/**
	 * radial_group function.
	 *
	 * @access protected
	 * @static
	 * @param mixed $relation
	 * @return void
	 * @todo add disabled
	 */
	protected static function radial_group($relation)
	{
		$output = '';

		if ( (bool) ORM::factory($relation['model'])->count_all())
		{
			$model = ORM::factory($relation['model']);

			$plural = $model->object_plural();

			$name = $relation['foreign_key'];

<<<<<<< HEAD
			$output .= '<div class="control-group">';
	        $output .= '<label class="control-label">'.ucwords($plural).'</label>';
	        $output .= '<div class="controls">';
=======
			$string .= '<div class="control-group">';
	        $string .= self::label(array('column_name' => $relation['relation_name']));
	        $string .= '<div class="controls">';
>>>>>>> bootstrap

	        foreach(ORM::factory($relation['model'])->find_all() as $option)
			{
		        $output .= '<label class="radio">';
		        $output .= '<input type="radio" name="'.$plural.'[]" id="'.$relation['model'].$option->pk().'" value="'.$option->pk().'" '.(self::$_object->has($plural, $option->pk()) ? 'checked' : false).'>';
				$output .= ucwords($option->name);
		        $output .= '</label>';
			}
	        $output .= '</div>';
	        $output .= '</div>';
		}

		return $output;
	}

	/**
	 * checkbox_group function.
	 *
	 * @access protected
	 * @static
	 * @param mixed $relation
	 * @return void
	 * @todo add disabled
	 */
	protected static function checkbox_group($relation)
	{
		$output = '';

		if ( (bool) ORM::factory($relation['model'])->count_all())
		{
			$model = ORM::factory($relation['model']);

			$plural = $model->object_plural();

			$name = (isset($relation['foreign_key'])) ? $plural.'[]' : $relation['foreign_key'];

<<<<<<< HEAD
			$output .= '<div class="control-group">';
			$output .= '<label class="control-label" for="'.$plural.'">'.ucwords($plural).'</label>';
			$output .= '<div class="controls">';
=======
			$string .= '<div class="control-group">';
			$string .= self::label(array('column_name' => $relation['relation_name']));
			$string .= '<div class="controls">';
>>>>>>> bootstrap

			foreach(ORM::factory($relation['model'])->find_all() as $option)
			{
				$output .= '<label class="checkbox inline">';
				$output .= '<input type="checkbox" name="'.$name.'" id="'.$relation['model'].$option->pk().'" value="'.$option->pk().'" '.(self::$_object->has($plural, $option->pk()) ? 'checked="checked"' : false).'> ';
				$output .= ucwords($option->name);
				$output .= '</label>';
			}

			$output .= '</div>';
			$output .= '</div>';
		}

		return $output;
	}
	
	/**
	 * autocomplete function.
	 * 
	 * @access protected
	 * @static
	 * @param mixed $column
	 * @return void
	 */
	protected static function autocomplete($column)
	{
		if (isset(self::$_options['sources'][$column['column_name']]))
		{
			if (Valid::url(self::$_options['sources'][$column['column_name']]))
			{
				$source = (string) file_get_contents(self::$_options['sources'][$column['column_name']]);
			}
			else //should be stringyfied json
			{
				$source = (string) self::$_options['sources'][$column['column_name']];
			}
		}
		
		$disabled = in_array($column['column_name'], self::$_options['disabled']) ? array('disabled' => true) : array();

		$output = '<div class="control-group'.(isset(self::$_options['errors'][$column['column_name']]) ? ' error': '').'">';
		$output .= self::label($column);
		$output .= '<div class="controls">';

		$output .= Form::input($column['column_name'],(isset(self::$_object->{$column['column_name']}) ? self::$_object->{$column['column_name']} : (isset($column['default']) ? $column['default'] : '')),
			Arr::merge(array(
				'data-provide' => 'typeahead',
				'class' => self::$_options['classes'][$column['column_name']],
				'maxlength' => isset($column['character_maximum_length']) ? $column['character_maximum_length'] : 8000,
				'data-source' => $source,
			), $disabled));

		$output .= (isset(self::$_options['help'][$column['column_name']]) or isset(self::$_options['errors'][$column['column_name']])) ? '<p class="help-block">'.(isset(self::$_options['errors'][$column['column_name']]) ? self::$_options['errors'][$column['column_name']]: self::$_options['help'][$column['column_name']]).'</p>' : '';
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	protected static function label($column)
	{
		$output = Form::label($column['column_name'], isset(self::$_options['labels'][$column['column_name']]) ? self::$_options['labels'][$column['column_name']] : ucwords($column['column_name']), array('class' => 'control-label'));

		return $output;
	}

	protected static function reset()
	{
		$output = Form::input('reset', 'Cancel', array('type' => 'reset', 'class' => 'btn')).' ';

		return $output;
	}

	protected static function submit()
	{
		$output = Form::submit('save','Save', array('class' => 'btn btn-primary')).' ';

		return $output;
	}
}