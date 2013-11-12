This is the install file for the Maps extension.
	
Extension page on mediawiki.org: https://www.mediawiki.org/wiki/Extension:Maps
Latest version of the install file: https://gerrit.wikimedia.org/r/gitweb?p=mediawiki/extensions/Maps.git;a=blob;f=INSTALL


== Requirements ==

<table>
	<tr>
		<th></th>
		<th>PHP</th>
		<th>MediaWiki</th>
		<th>ParamProcessor (Validator)</th>
		<th>DataValues</th>
	</tr>
	<tr>
		<th>Maps 2.x</th>
		<td>5.3.2+</td>
		<td>1.18+</td>
		<td>0.5.x</td>
		<td>Not needed</td>
	</tr>
	<tr>
		<th>Maps 3.x</th>
		<td>5.3.2+</td>
		<td>1.18+</td>
		<td>1.0+</td>
		<td>0.1+</td>
	</tr>
	<tr>
		<th>Maps 1.0.5</th>
		<td>5.2+</td>
		<td>1.17+</td>
		<td>0.4.12+ &lt;1.0</td>
		<td>Not needed</td>
	</tr>
</table>

; Legend

<table>
	<tr>
		<th>Color</th>
		<th>Meaning</th>
		<th>Development</th>
	</tr>
	<tr>
		<td style="background:salmon;">Red</td>
		<td>Old release</td>
		<td>New features</td>
	</tr>
	<tr>
		<td>Yellow</td>
		<td>Stable release</td>
		<td>Security fixes</td>
	</tr>
	<tr>
		<td>Green</td>
		<td>Stable release</td>
		<td>Bug and security fixes</td>
	</tr>
	<tr>
		<td>Blue</td>
		<td>Future release</td>
		<td>New features</td>
	</tr>
</table>

== Download ==

You can find the current version of Maps on the Google Code download page [0],
as well as a list of legacy downloads [1].

[0] https://code.google.com/p/mwmaps/downloads/list
[1] https://code.google.com/p/mwmaps/downloads/list?can=1

You can also get the code directly from SVN. Tags can be obtained via

 svn checkout http://svn.wikimedia.org/svnroot/mediawiki/tags/extensions/Maps/REL_version

Where 'version' is the version number of the tag, such as 0_1
(see the available tags at http://svn.wikimedia.org/svnroot/mediawiki/tags/extensions/Maps/).

The latest code can be obtained from trunk:

 svn checkout http://svn.wikimedia.org/svnroot/mediawiki/trunk/extensions/Maps/

== Installation ==

Once you have downloaded the code, place the ''Maps'' directory within your MediaWiki
'extensions' directory. Then add the following code to your [[Manual:LocalSettings.php|LocalSettings.php]] file:

# Maps
require_once( "$IP/extensions/Maps/Maps.php" );