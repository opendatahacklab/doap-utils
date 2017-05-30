<?php 
/**
 * Convert a list of projects in a gitlab repository (see https://docs.gitlab.com/ee/api/projects.html)
 * to doap files
 *
 * @author Cristiano Longo
 *
 * This file is part of doap-utils.
 *
 * Copyright 2017 Cristiano Longo
 *
 * doap-utils is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * doap-utils is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

include_once('DOAPProject.php');

class GitlabProjectsParser implements Iterator{
	
	private $namespace;
	private $srcIterator;
	
	/**
	 * Create a parser from a json reply
	 * @param jsonStr the string (in json format) returned by the REST call /projects
	 */
	public function __construct($jsonReply, $namespace){
		$srcEntries=json_decode($jsonReply);
		if ($srcEntries==null)
			throw new Exception("Unable to parse json reply");
		$this->srcIterator=new ArrayIterator($srcEntries);
		$this->namespace=$namespace;
	}

	/**
	 * @param $url URL to access the rest endpoint for example https://git.mittelab.org/api/v4/projects/
	 * @param $namespace the namespace assigned to the generated doap projects
	 */
	public static function getFromRESTEndpoint($url, $namespace){
		$s = curl_init();		
		curl_setopt($s,CURLOPT_URL,$url);
		curl_setopt($s,CURLOPT_RETURNTRANSFER,true);
		$jsonReply=curl_exec($s);
		if (curl_error($s))
			throw new Exception(curl_error($s));
		curl_close($s);
		if ($jsonReply==null)
			throw new Exception("Unable to download $url");
		return new GitlabProjectsParser($jsonReply, $namespace);
	}
	
	public function current(){		
		$gitlab=$this->srcIterator->current();
		$doap = new DOAPProject();
		$doap->url=$this->namespace.$gitlab->id;
		$doap->name=$gitlab->name;
		$doap->shortdesc=$gitlab->name_with_namespace;
		$doap->landing=$gitlab->web_url;
		$doap->gitbrowse=$gitlab->web_url;
		$doap->gitrepo=$gitlab->http_url_to_repo;
		
		return $doap;
	}
	
	public function key (){
		return $this->srcIterator->key();
	}
	
	public function next(){
		return $this->srcIterator->next();
	}
	
	public function rewind(){
		return $this->srcIterator->rewind();
	}
	
	public function valid(){
		return $this->srcIterator->valid();
	}	
}
?>