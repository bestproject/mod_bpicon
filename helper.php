<?php
/**
* @package		mod_bpicon
* @date			2016-02-11
* @author		Artur Stępień
* @email		artur.stepien@bestproject.pl
* @copyright	(C) 20016 Bestproject. All rights reserved.
* @license		GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
* @link			http://www.bestproject.pl
 */

defined('_JEXEC') or die;

/**
 * Helper for mod_bpicon
 */
class ModBPIconHelper
{
	
	private static $articles = array();
	private static $articles_k2 = array();

	public static function getURL($params) {
		
		$url_type = $params->get('url_type','none');
		
		if( $url_type==='article' ) {
			
			require_once JPATH_ROOT.'/components/com_content/helpers/route.php';
			
			$article = self::getArticle($params->get('url_article'));

			return ContentHelperRoute::getArticleRoute($article->id, $article->catid);
			
		} elseif ( $url_type==='article_k2' ) {
			
			require_once JPATH_ROOT.'/components/com_k2/helpers/route.php';
			
			$article = self::getArticleK2($params->get('url_article_k2'));

			return K2HelperRoute::getItemRoute($article->id, $article->catid);
			
		} elseif ( $url_type==='menu' ) {
			
			return 'index.php?Itemid='.$params->get('url_menu');
			
		} elseif ( $url_type=='external' ) {
			
			return $params->get('url_external','');
			
		}
		
		return '';
	}
	
	public static function getArticle($id) {
		
		
		// Article was cached before
		if( isset(self::$articles[(int)$id]) ) {
			
			// return cached article
			return self::$articles[(int)$id];
			
		// New article so find it
		} else {
			
			// Article table object
			$article = JTable::getInstance('Content');
		
			if( $article->load($id) ) {
				
				// Get article data
				$data = $article->getProperties();
				
				// cache it
				self::$articles[(int)$id] = \Joomla\Utilities\ArrayHelper::toObject($data);
				
				// Return data
				return self::$articles[(int)$id];
				
			} else {
				
				null;
				
			}
			
		}

	}
	
	public static function getArticleK2($id) {
		
		
		// Article was cached before
		if( isset(self::$articles_k2[(int)$id]) ) {
			
			// return cached article
			return self::$articles_k2[(int)$id];
			
		// New article so find it
		} else {
			
			require_once JPATH_ADMINISTRATOR.'/components/com_k2/tables/k2item.php';
			
			// Article table object
			$article = JTable::getInstance('Item','TableK2');

			if( $article->load($id) ) {
				
				// Get article data
				$data = $article->getProperties();
				
				// cache it
				self::$articles[(int)$id] = \Joomla\Utilities\ArrayHelper::toObject($data);
				
				// Return data
				return self::$articles[(int)$id];
				
			} else {
				
				null;
				
			}
			
		}

	}
	
}
