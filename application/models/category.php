<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model for Categories of reported Incidents
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */

class Category_Model extends ORM_Tree {	
	/**
	 * One-to-many relationship definition
	 * @var array
	 */
	protected $has_many = array('incident' => 'incident_category', 'category_lang');
	
	/**
	 * Database table name
	 * @var string
	 */
	protected $table_name = 'category';
	
	/**
	 * Name of the child table for this model - recursive
	 * @var string
	 */ 
	protected $children = "category";
	
	/**
	 * Default sort order
	 * @var array
	 */
	protected $sorting = array("category_position" => "asc");
	
	protected static $categories;
	
	/**
	 * Validates and optionally saves a category record from an array
	 *
	 * @param array $array Values to check
	 * @param bool $save Saves the record when validation succeeds
	 * @return bool
	 */
	public function validate(array & $array, $save = FALSE)
	{
		// Set up validation
		$array = Validation::factory($array)
					->pre_filter('trim', TRUE)
					->add_rules('parent_id','required', 'numeric')
					->add_rules('category_title','required', 'length[3,80]')
					->add_rules('category_description','required')
					->add_rules('category_color','required', 'length[6,6]');
		
		
		// When creating a new category
		if ( empty($this->id) )
		{
			// Set locale to current language
			$this->locale = Kohana::config('locale.language.0');
		}
		
		// Validation checks where parent_id > 0
		if ($array->parent_id > 0)
		{
			$this_parent = self::factory('category')->find($array->parent_id);
			
			// If parent category is trusted/special
			if ($this_parent->category_trusted == 1)
			{
				Kohana::log('error', 'The parent id is a trusted category!');
				$array->add_error('parent_id', 'parent_trusted');
			}
			
			// When editing a category	
			if ( ! empty($this->id))
			{
				$this_cat = self::factory('category')->find($this->id);
				
				// If this category is trusted/special, don't subcategorize
				if ($this_cat->category_trusted)
				{
					Kohana::log('error', 'This is a special category');
					$array->add_error('parent_id', 'special');
				}
				
				// If parent category is trusted/special
				if ($this_parent->category_trusted == 1)
				{
					Kohana::log('error', 'The parent id is a trusted category!');
					$array->add_error('parent_id', 'parent_trusted');
				}
				
				// If subcategories exist
				$children = self::factory('category')->where('parent_id',$this->id)->count_all();
				if ($children > 0 )
				{
					Kohana::log('error', 'This category has subcategories');
					$array->add_error('parent_id', 'already_parent');
				}
				
				// If parent and category id are the same
				if ($this->id == $array->parent_id)
				{
					// Error
					Kohana::log('error', 'The parent id and category id are the same!');
					$array->add_error('parent_id', 'same');
				}	
			}
			else
			{
				// Ensure parent_id exists in the DB
				$array->add_callbacks('parent_id', 'Category_Model::is_valid_category');
			}
		}
		
		// Pass on validation to parent and return
		return parent::validate($array, $save);
	}
	
	/**
	 * Gets the list of categories from the database as an array
	 *
	 * @param int $category_id Database id of the category
	 * @param string $local Localization to use
	 * @return array
	 */
	public static function categories($category_id = NULL)
	{
		if (! isset(self::$categories))
		{
			$categories = ORM::factory('category')->find_all();
			
			self::$categories = array();
			foreach($categories as $category)
			{
				self::$categories[$category->id]['category_id'] = $category->id;
				self::$categories[$category->id]['category_title'] = $category->category_title;
				self::$categories[$category->id]['category_description'] = $category->category_description;
				self::$categories[$category->id]['category_color'] = $category->category_color;
				self::$categories[$category->id]['category_image'] = $category->category_image;
				self::$categories[$category->id]['category_image_thumb'] = $category->category_image_thumb;
			}
		}
		
		if ($category_id AND isset(self::$categories[$category_id]))
		{
			return array($category_id => self::$categories[$category_id]);
		}
		
		return self::$categories;
	}

	/**
	 * Checks if the specified category ID is of type INT and exists in the database
	 *
	 * @param	int	$category_id Database id of the category to be looked up
	 * @return	bool
	 */
	public static function is_valid_category($category_id)
	{
		// Hiding errors/warnings here because child categories are seeing category_id as an obj and this fails poorly
		return ( ! is_object($category_id) AND intval($category_id) > 0)
				? self::factory('category', intval($category_id))->loaded
				: FALSE;
	}
	
	/**
	 * Given a parent id, gets the immediate children for the category, else gets the list
	 * of all categories with parent id 0
	 *
	 * @param int $parent_id
	 * @return ORM_Iterator
	 */
	public static function get_categories($parent_id = 0, $exclude_trusted = TRUE, $exclude_hidden = TRUE)
	{
		// Check if the specified parent is valid
		$where = (intval($parent_id) > 0 AND self::is_valid_category($parent_id))
			? array('parent_id' => $parent_id)
			: array('parent_id' => 0);
			
		// Make sure the category is visible
		if ($exclude_hidden)
		{
			$where = array_merge($where, array('category_visible' =>'1'));
		}
		
		// Exclude trusted reports
		if ($exclude_trusted)
		{
			$where = array_merge($where, array('category_trusted !=' => '1'));
		}
		
		// Return
		return ORM::factory('category')
			->where($where)
			->where('category_title != "NONE"')
			->orderby('category_position', 'ASC')
			->orderby('category_title', 'ASC')
			->find_all();
	}
	
	/**
	 * Extend the default ORM save to also update matching Category_Lang record if it exits
	 */
	public function save()
	{
		parent::save();
		
		$table_prefix = Kohana::config('database.default.table_prefix');
		
		Database::instance()->query('UPDATE `'.$table_prefix.'category_lang` SET category_title = ?, category_description = ? WHERE category_id = ? AND locale = ?',
			$this->category_title, $this->category_description, $this->id, $this->locale
		);
	}

	
}
