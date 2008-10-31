<?php
require_once 'Zend/View/Helper/HeadLink.php';
require_once 'Hm/View/Helper/Exception.php';
require_once 'Hm/File.php';

/**
 * Special HeadLink view plugin implementation, that introduces CSS files merge
 * and compress features.
 *
 * @author Kubek Bartosz
 * @copyright Copyright (c) 2008 Kubek Bartosz, Heavymind (http://www.heavymind.net)
 * @license All rights reserved. New BSD License
 * @license http://www.heavymind.net/new-bsd-license
 * @package Hm_View_Helper
 * @subpackage Hm_View
 * @version 1.0
 */
class Hm_View_Helper_HeadLink extends Zend_View_Helper_HeadLink {

	/**
	 * Determines if merge functionality is enabled in general
	 *
	 * @var bool
	 * @see getIsMergeEnabled()
	 * @see setIsMergeEnabled()
	 */
	private $__isMergeEnabled = false;

	/**
	 * Determines if merge compressing functionality is enabled
	 *
	 * @var bool
	 * @see getIsCompressEnabled()
	 * @see setIsCompressEnabled()
	 */
	private $__isMergeCompressEnabled = false;

	/**
	 * Relational path to directory where merges are stored.
	 * The directory must be available for public.
	 * Ex: for "styles_cache/" it would mean, the merge file will be read from:
	 *   http://domain.com/styles_cache/[merge-file-name.css]
	 *
	 * @var string
	 * @see getMergePath()
	 * @see setMergePath()
	 */
	private $__mergePath = '';

	/**
	 * Array of link items, to be processed (merged, compressed)
	 * It contains multidimension structure of data. Pattern:
	 * array ( [type; ex.:] 'text/css'
	 * 		=> array ( [media; ex.:] 'screen'
	 * 			=> array( [isConditional?; ex.:] true
	 * 				=> array (	[string; itemUrl; ex.:] 0 => '/style/main.css'
	 * 							[string; itemUrl; ex.:] 1 => '/style/main2.css' ) ) ) )
	 * @var array()
	 */
	private $__cssItemsBeforeMerge = array();

	/**
	 * Array of link items, to after processing (merge, compress)
	 * It contains stdClass objects as one dimenssion array
	 */
	private $__cssItemsAfterMerge = array();

	/**
	 * Config object with view settings
	 */
	private $__obConfigView = null;

	/**
	 * Render link elements as string
	 *
	 * @param  string|int $indent
	 * @return string
	 */
	public function toString($indent = null)
	{
		$result = '';
		try {
			$indent = (null !== $indent)
			? $this->getWhitespace($indent)
			: $this->getIndent();
			$items = array();
			foreach ($this as $item) {
				if( null != $it = $this->itemToString($item) ) {
					$items[] = $it;
				}
			}
			$itemsCss = $this->__getMergedCssItems();
			foreach ($itemsCss as $item) {
				if( null != $it = parent::itemToString($item) ) {
					$items[] = $it;
				}
			}
		$result = $indent . implode($this->_escape($this->getSeparator()) . $indent, $items);
		} catch ( Exception $e ) {
			// toString() method cannot throw an exceptions so
			// here exception should be logged
			return false;
		}
		return $result;
	}

	/**
	 * Create HTML link element from data item
	 * or for CSS links: prepares CSS file content for later merge
	 *
	 * @param  stdClass $item
	 * @return string
	 */
	public function itemToString(stdClass $item)
	{
		//check if item is CSS type and check if CSS-merge is enabled
		if( $this->__isCss( $item ) && $this->getIsMergeEnabled()) {
				$this->__addCssItemToProcessingStack( $item );
		} else {
			// other than CSS type
			return parent::itemToString( $item );
		}
	}

	/**
	 * Add item to array witch is used to store items for later to be processed
	 *
	 * @param stdClass $item
	 * @return true
	 * @access private
	 */
	private function __addCssItemToProcessingStack( stdClass $item ) {
		if( !isset( $this->__cssItemsBeforeMerge[ $item->type ]  ) )
			$this->__cssItemsBeforeMerge[ $item->type ] = array();
		if( !isset( $this->__cssItemsBeforeMerge[ $item->type ][ $item->media ]  ) )
			$this->__cssItemsBeforeMerge[ $item->type ][ $item->media ] = array();
		if( !isset( $this->__cssItemsBeforeMerge[ $item->type ][ $item->media ][ $item->conditionalStylesheet ]  ) )
			$this->__cssItemsBeforeMerge[ $item->type ][ $item->media ][ $item->conditionalStylesheet ] = array();

		//for processiong, the first slash need to be taken out
		$item->href = substr( $item->href, 1, strlen( $item->href )-1 );

		//add to stack
		array_push(
			$this->__cssItemsBeforeMerge[ $item->type ][ $item->media ][ $item->conditionalStylesheet ],
			$item->href
		);
	}

	/**
	 * Checks if item object is CSS type
	 *
	 * @param stdClass $item
	 * @return bool true | false
	 * @access private
	 */
	private function __isCss( stdClass $item ) {
		if( $item->rel == 'stylesheet'
			) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Generated uniue Id from current Uri
	 *
	 * @param void
	 * @return string
	 * @access private
	 */
	private function __generateId( $items ) {
		asort( $items );
		return md5( serialize( $items ) );
	}


	/**
	 * Checks if CSS-merge is enabled
	 *
	 * @param void
	 * @return bool true|false
	 * @access public
	 */
	public function getIsMergeEnabled() {
		return $this->__isMergeEnabled;
	}

	/**
	 * Sets if CSS-merge is enabled
	 *
	 * @param bool true|false
	 * @return Hm_View_Helper_HeadLink
	 * @access public
	 */
	public function setIsMergeEnabled( $flag = false ) {
		$this->__isMergeEnabled = (bool) $flag;
		return $this;
	}

	/**
	 * Checks if CSS-compressor is enabled
	 *
	 * @param void
	 * @return bool true|false
	 * @access public
	 */
	public function getIsCompressEnabled() {
		return $this->__isMergeCompressEnabled;
	}

	/**
	 * Sets if CSS-compressor is enabled
	 *
	 * @param bool true|false
	 * @return Hm_View_Helper_HeadLink
	 * @access public
	 */
	public function setIsCompressEnabled( $flag = false ) {
		$this->__isMergeCompressEnabled = $flag;
		return $this;
	}

	/**
	 * Gets merge files path
	 *
	 * @param void
	 * @return string
	 * @access public
	 */
	public function getMergePath() {
		return $this->__mergePath;
	}

	/**
	 * Sets merge files path
	 *
	 * @param string $path
	 * @return Hm_View_Helper_HeadLink
	 * @access public
	 */
	public function setMergePath( $path = '' ) {
		if( is_string( $path ) )
			$this->__mergePath = $path;
		return $this;
	}

	/**
	 * Applys css compressor to css-container string, and returns it
	 *
	 * @param string $contents
	 * @return sting
	 * @access private
	 */
	private function __applyCompressor( $contents ) {
		// remove comments
		$contents = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $contents);
		// remove tabs, spaces, newlines, etc.
		$contents = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $contents );
		return $contents;
	}

	/**
	 * Takes all CSS files stored in this.__cssItemsBeforeMerge arrray and
	 * merges them - one file per one CSS type, media, and conditionall param
	 * The result is stored in this.__cssItemsAfterMerge, witch is returned
	 * as an array
	 *
	 * @param void
	 * @return array
	 * @access private
	 */
	private function __getMergedCssItems() {
		// first go through all types of Css to process them seperatelly
		foreach( $this->__cssItemsBeforeMerge as $type => $typeData ) {
			foreach( $typeData as $media => $mediaData ) {
				foreach( $mediaData as $conditional => $conditionalData) {
					$this->__processCssType( $conditionalData, $type, $media, $conditional );
				}
			}
		}
		// return merged items
		return $this->__cssItemsAfterMerge;
	}

	/**
	 * For a one CSS type, media and conditional set of params, it will generate
	 * unique ID for CSS file items, and will return properly merged CSS file path
	 * If the file not exists, it will be created by calling this.__createCssMergeFile()
	 * The merge-Css item, will be spush as an object into this.__cssItemsAfterMerge array
	 *
	 * @param array $items
	 * @param string $type		=> ex. "text/css"
	 * @param string $media		=> ex: "all", "screen"
	 * @param bool $conditional	=> true or false
	 * @return void
	 * @access private
	 * @uses Hm_File
	 */
	private function __processCssType( $items, $type, $media, $conditional ) {
		// check if we already have merge for this pack od items
		$id = $this->__generateId( $items );

		$obFile = new Hm_File();
		$mergedFileFullPath = $this->getMergePath() . $id . '.css';
		if( ! $obFile->exist( $mergedFileFullPath ) ) {
			// new file need to be created
			$id = $this->__createCssMergeFile( $items );
			$mergedFileFullPath = $this->getMergePath() . $id . '.css';
		}

		// create item object
		$obItem = new stdClass();
		$obItem->rel = 'stylesheet';
		$obItem->type = $type;
		$obItem->media = $media;
		$obItem->conditionalStylesheet = (bool)$conditional;
		$obItem->href = '/'.$mergedFileFullPath;

		//and push it into stack
		array_push( $this->__cssItemsAfterMerge, $obItem );
	}

	/**
	 * Creates CSS merge file from given list, and returns it name
	 *
	 * @param array $items
	 * @return string $filename
	 * @access private
	 */
	private function __createCssMergeFile( array $items = array() ) {
		if( count( $items ) <= 0 ) throw new Hm_View_Helper_Exception(
			'Items array is emty!' );

		// generate id
		$id = $this->__generateId( $items );

		// merge files
		$tmpContainer ='';
		$obFile = new Hm_File();
		foreach( $items as $item ) {
			$tmpContainer .= $obFile->clear()->setFileName( $item )->open()->getFileContent();
		}

		//check if CSS should be compressed
		if( $this->getIsCompressEnabled() ) {
			$tmpContainer = $this->__applyCompressor( $tmpContainer );
		}

		// save file
		$obFile->clear()
			->setFileContent( $tmpContainer )
			->setFileName( $this->getMergePath() . $id . '.css' )
			->save();

		return $id;
	}

	/**
	 * Clear all css merges form merge directory
	 *
	 * @param void
	 * @return bool true|false		- true when all files has been cuccesfully deleted
	 * @access public
	 * @throws Hm_View_Helper_Exception
	 */
	public function clearCssMerges() {
		if( !strlen( $this->getMergePath() ) ) throw new Hm_View_Helper_Exception(
			'Cannot clear merges. Merge directory path not specified' );
		$obFile = new Hm_File();
		return $obFile->deleteDirectoryContents( $this->getMergePath() . '*.css' );
	}
}
