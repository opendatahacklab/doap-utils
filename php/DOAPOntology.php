<?php 
/**
 * An OWL ontology for DOAP projects
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
include_once('RDFXMLOntology.php');

define('DOAP_NS','http://usefulinc.com/ns/doap#');
define('FOAF_NS','http://xmlns.com/foaf/0.1/');

class DOAPOntology extends RDFXMLOntology{

	private $namespace;
	
	/**
	 * Create an empty ontology but with the specified IRI.
	 * @param unknown $iri
	 * 
	 */
	public function __construct($namespace){
		parent::__construct($namespace);
		$this->addNamespaces(array('doap' => DOAP_NS, 'foaf' => FOAF_NS));
		$this->addImports(array('http://xmlns.com/foaf/spec/index.rdf', 'http://usefulinc.com/ns/doap#'));
		$this->addLicense ( 'https://creativecommons.org/licenses/by/4.0/' );		
		$this->namespace=$namespace;
	}
	
	/**
	 * Add a doap project to this ontology
	 * 
	 * @param DOAPProject $project
	 */
	public function add($project){
		
		$projectEl=$this->addElement('doap:Project');
		$projectEl->setAttribute('rdf:about',$project->url);
		
		$nameEl=$this->addProperty($projectEl,'doap:name');
		$nameTxtNode=$this->getXML()->createTextNode($project->name);
		$nameEl->appendChild($nameTxtNode);
		
		$this->addResourceProperty($projectEl, 'doap:homepage', $project->landing);	
		
		$gitRepoEl=$this->addResourceProperty(
				$this->addResourceProperty($projectEl, 'doap:Repository'), 'doap:GitRepository');
		$this->addResourceProperty($gitRepoEl, 'doap:location', $project->gitrepo);
		$this->addResourceProperty($gitRepoEl, 'doap:browse', $project->gitbrowse);
	}
	
	/**
	 * Create an element and add it to the (root element of the) ontology
	 * 
	 * @param string $elementType
	 * @return the novel element
	 */
	private function addElement($elementType){
		$ontology=$this->getXML();
		$el=$ontology->createElement($elementType);
		$ontology->documentElement->appendChild($el);
		return $el;
	}
	
	/**
	 * Add a property node to an existing element
	 * 
	 * @param unknown $propertyName the URL (may be shortened via namespace) of the property
	 * @param unknown $element
	 * 
	 * @return the DOMElement representing the property in the XML document
	 */
	private function addProperty($element, $propertyName){
		$propertyEl=$this->addElement($propertyName);
		$element->appendChild($propertyEl);
		return $propertyEl;
	}
	
	/**
	 * 
	 * @param DOMElement $element
	 * @param string $propertyName
	 * @param string $resourceUrl
	 * 
	 * @return the DOMElement representing the property in the XML document
	 */
	private function addResourceProperty($element, $propertyName, $resourceUrl){
		$propertyEl=$this->addProperty($element, $propertyName);
		$propertyEl->setAttribute('rdf:resource', $resourceUrl);
		return $propertyEl;
	}	
}
?>