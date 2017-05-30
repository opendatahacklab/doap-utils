<?php 
/**
 * Represents a DOAP Project. 
 * 
 * NOTE: it is minimal and need to be extended.
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
class DOAPProject{
	
	public $url; //URL which identifies the project in the Universe
	public $name; //project name
	public $shortdesc; //project name
	public $landing; //landing page of the project
	public $gitbrowse; //web page of the git repository
	public $gitrepo; //clone url of the git repository	
}
?>