<?
//    LendIT lets you easily manage the process loaning out of items to people. 
//    Copyright (C) 2012  Darren van den Bogaard

//    This program is free software: you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation, either version 3 of the License, or
//    (at your option) any later version.

//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.

//    You should have received a copy of the GNU General Public License
//    along with this program.  If not, see <http://www.gnu.org/licenses/>.


if ($_SESSION["EmailAddresses"])
	{
	//Display email addresses
	print $displayString;
	//Clear Session variable
	$_SESSION["EmailAddresses"] = '';
	}// END if ($_SESSION["EmailAddresses"])
else
	{
	print 'Sorry... No email addresses are avaliable to display...';
	} // END ELSE if ($_SESSION["EmailAddresses"])
	
?>
