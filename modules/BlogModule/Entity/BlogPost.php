<?php

namespace BlogModule\Entity;

class BlogPost {
	
	protected $_id = null;
	protected $_title = null;
	protected $_content = null;
	protected $_category_id = null;
	protected $_date_created = null;
	protected $_tags = array();
	
	public function __construct($row) {
		foreach($row as $key => $val) {
			if(property_exists($this, '_' . $key)) {
				$this->{'_' . $key} = $val;
			}
		}

		if ( !defined('MB_ACTIVE') ) {
			define('MB_ACTIVE', defined('MB_CASE_UPPER'));
		}
	}
	
	public function getID() {
		return $this->_id;
	}
	
	public function getCategoryID() {
		return $this->_category_id;
	}
	
	public function getTitle() {
		return $this->_title;
	}
    
    public function getTitleForLink() {
        return strtolower(str_replace(' ', '-', $this->getTitle()));
    }
	
	public function getShortContent() {
		$content = explode('[split]', $this->getContent());
		return $content[0];
	}
    
    public function getContent() {
        return $this->_content;
    }

	/**
	 * Get the created date
	 * 
	 * @return \DateTime
	 */
	public function getCreatedDate() {
		$dt = new \DateTime();
		$dt->setTimestamp($this->_date_created);
		return $dt;
	}
	
	public function setTags($tags) {
		$this->_tags = $tags;
	}
	
	public function hasTags() {
		return !empty($this->_tags);
	}
	
	public function getTags() {
		return $this->_tags;
	}

	/**
	 * Get a snippet of the content of this blog post
	 * as a summary.
	 *
	 * @param Integer $numChars The number of characters that this snippet should contain.
	 *
	 * @return String The snippet.
	 */
	public function getSnippet($numChars = 150)
	{

		$content = strip_tags($this->getContent());


		if ( strlen($content) > $numChars ) {
			if ( MB_ACTIVE ) {
				$content = mb_substr($content, 0, $numChars);
			} else {
				$content = substr($content, 0, $numChars);
			}
		}

		return $content;

	}

	/**
	 * Fetch the url for this blog post.
	 * 
	 * @param  String $page The base page path for this blog post.
	 * 
	 * @return String       The url to this blog post.
	 */
	public function getUrl( $page = 'blog/' )
	{
		return $page . $this->getID() . '/' . str_replace(' ', '-', strtolower($this->getTitle()));
	}
    
}