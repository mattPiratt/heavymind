<?php
require_once 'Hm/File/Exception.php';

/**
 * Class for basic file operations.
 *
 * @author Kubek Bartosz
 * @copyright Copyright (c) 2008 Kubek Bartosz, Heavymind (http://www.heavymind.net)
 * @license All rights reserved. New BSD License
 * @license http://www.heavymind.net/new-bsd-license
 * @package Hm_File
 * @version 1.0
 */
class Hm_File {

	/**
	 * Constructor can open (read) file, if optional parameter $filename is passed
	 * and valid.
	 *
	 * @param string $filename (optional)
	 * @return Hm_File
	 * @access public
	 * @throws Hm_File_Exception
	 */
	public function __construct( $filename = '' ) {
		if( is_string( $filename ) && strlen( $filename ) > 0 )
			$this->open( $filename );
	}

	/**
	 * File name that the object represents
	 *
	 * @var string
	 */
	private $__fileName = '';

	/**
	 * Content of the file
	 *
	 * @var string
	 */
	private $__fileContent = '';

	/**
	 * Returns file name
	 *
	 * @param void
	 * @return string
	 * @access public
	 */
	public function getFileName() {
		return $this->__fileName;
	}

	/**
	 * Sets file name
	 *
	 * @param string $name
	 * @return Hm_File
	 * @access public
	 * @throws Hm_File_Exception
	 */
	public function setFileName( $name ) {
		if( ! is_string( $name ) ) throw new Hm_File_Exception(
			'File name must be an string' );
		if( !strlen( $name ) > 0 ) throw new Hm_File_Exception(
			'File name length must be greater than zero' );
		$this->__fileName = $name;
		return $this;
	}

	/**
	 * Clears object properties: fileName and fileContent
	 *
	 * @param void
	 * @return Hm_File
	 * @access public
	 */
	public function clear() {
		$this->__fileContent = '';
		$this->__fileName = '';
		return $this;
	}

	/**
	 * Returns file contents
	 *
	 * @param void
	 * @return string
	 * @access public
	 */
	public function getFileContent() {
		return $this->__fileContent;
	}

	/**
	 * Sets file contents (overwrites if exists)
	 *
	 * @param string $content
	 * @return Hm_File
	 * @access public
	 * @throws Hm_File_Exception
	 */
	public function setFileContent( $content ) {
		if( ! is_string( $content ) ) throw new Hm_File_Exception(
			'Content must be an string' );
		if( !strlen( $content ) > 0 ) throw new Hm_File_Exception(
			'Content length must be greater than zero' );
		$this->__fileContent = $content;
		return $this;
	}

	/**
	 * Appends file content (existing one wil not be overwriten)
	 *
	 * @param string $content
	 * @return Hm_File
	 * @access public
	 * @throws Hm_File_Exception
	 */
	public function appendFileContent( $content ) {
		if( ! is_string( $content ) ) throw new Hm_File_Exception(
			'Content must be an string' );
		if( !strlen( $content ) > 0 ) throw new Hm_File_Exception(
			'Content length must be greater than zero' );
		$this->__fileContent .= $content;
		return $this;
	}

	/**
	 * Prepand file content at its beginning (existing one wil not be overwriten)
	 *
	 * @param string $content
	 * @return Hm_File
	 * @access public
	 * @throws Hm_File_Exception
	 */
	public function prependFileContent( $content ) {
		if( ! is_string( $content ) ) throw new Hm_File_Exception(
			'Content must be an string' );
		if( !strlen( $content ) > 0 ) throw new Hm_File_Exception(
			'Content length must be greater than zero' );
		$this->__fileContent = $content . $this->__fileContent;
		return $this;
	}

	/**
	 * Open specified file. If succesfull, the file name will be stored in
	 * object property __fileName (accesed by getFileName() ), and file
	 * contents will be set to object property __fileCOntent (accesed by
	 * getFileContent() )
	 * Full path to file should be provided. This can be URI eg:
	 *    http://somehost.org/some/path/to/file.ext
	 * or a real path (absolute or relational), eg:
	 *    /home/var/www/my-site/some/path/to/file.ext
	 * When file couldn't be read, an exception is thrown
	 *
	 * @param $string $filename (optional)
	 * @return Hm_File
	 * @access public
	 * @throws Hm_File_Exception
	 */
	public function open( $filename = '' ) {
		if( !strlen( $filename ) ) {
			$filename = $this->getFileName();
		}
		$this->setFileName( $filename );
		//read file
		$result = file_get_contents( $this->__fileName );
		if( ! $result ) {
			$this->clear();
			throw new Hm_File_Exception(
				'File '.$this->__fileName.' couldn\'t be opened. Not exist?' );
		}
		$this->setFileContent( $result );
		return $this;
	}

	/**
	 * Saves current file content into current file name
	 * ( previously set by setFileName() and setFileContent() )
	 * If any problem occure, an exception is thrown. Otherwise
	 * bollean 'true' is returned.
	 *
	 * @param void
	 * @return true
	 * @access public
	 * @throws Hm_File_Exception
	 */
	public function save() {
		//check if file name is set properly
		$this->setFileName( $this->__fileName );
		// also check contents
		$this->setFileContent( $this->__fileContent );

		$result = file_put_contents( $this->__fileName, $this->__fileContent );
		if( !$result ) throw new Hm_File_Exception(
			'File '.$this->__fileName.' couldn\'t be saved. Directory priviledges?' );
		return true;
	}

	/**
	 * Deletes phisicaly selected file
	 *
	 * @param string $filename (optional)
	 * @return true | false    - true on success
	 * @access public
	 * @throws Hm_File_Exception
	 */
	public function deleteFile( $filename = '' ) {
		if( !strlen( $filename ) )
			$filename = $this->__fileName;
		//check filename
		$this->setFileName( $filename );
		return unlink( $this->__fileName );
	}

	/**
	 * Deletes phisicaly selected directory
	 *
	 * @param string $dirname
	 * @return true | false    - true on success
	 * @access public
	 * @throws Hm_File_Exception
	 */
	public function deleteDirectory( $dirname = '' ) {
		//check dirname, use temporary fileName property for this
		$this->setFileName( $dirname );
		$status = rmdir( $this->__fileName );
		$this->clear();
		return $status;
	}

	/**
	 * Deletes phisicaly selected directory contents (but not directory)
	 * You can use wildcatd sign "*" to specify content. Eg:
	 * path/to/directory/*.jpg		(to delete all jpg files) or:
	 * path/to/directory/*			(to delete all files)
	 *
	 * @param string $dirname
	 * @return true | false    - true on success
	 * @access public
	 * @throws Hm_File_Exception
	 */
	public function deleteDirectoryContents( $dirname = '' ) {
		//check dirname, use temporary fileName property for this
		$this->setFileName( $dirname );
		// flag to search for problems
		$allOK = true;
		foreach( glob( $this->getFileName() ) as $item ) {
			$allOK = unlink( $item );
		}
		$this->clear();
		return $allOK;
	}


	/**
	 * Checks if passed file or directory exist on the server
	 * Must be local file or directory
	 *
	 * @param string $filename (optional)
	 * @return bool true | false
	 * @access public
	 * @throws Hm_File_Exception
	 */
	public function exist( $filename = '' ) {
		if( !strlen( $filename ) )
			$filename = $this->__fileName;
		// valiadate filename
		$this->setFileName( $filename );
		// check for existance
		return file_exists( $filename );
	}

}