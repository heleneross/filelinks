<?php
defined('_JEXEC') or die( 'Restricted access' );
//html help document below
?> 
<h2>Getting Started</h2>
<p>There are three essential steps before you start using this component:</p>
<ol>
<li>Go to options and set the root of your document folder. This is the folder where you store pdfs etc</li>
<li>In options set the allowed filetypes - this is just the file extension list, separate the extensions with a comma</li>
<li>Go to Categories (Files) and set at least one Category</li>
</ol> 
<h2>Files</h2>
<p>Shows you a list of all the files you have added in this component, if the filepath is shown in red the resource can not be found</p>
<p>You can view the files, publish and unpublish them or edit the details</p>
<p>Click on the title of the file to be taken to the edit screen</p>
<h2>Edit File Details</h2>
<ol>
<li>Title - the name shown when searching for this resource or the friendly name for the link when using the filelink plugin</li>
<li>File Path - where this resource is located</li>
<li>Catid - the category for this item</li>
<li>Description - the text to be searched by the search plugin, a summary of the file contents</li>
<li>Published - whether this item is currently published</li>
</ol>
<p>Warning: If you change the options to a different root document folder and or filetypes you may not be able to edit current items as the url is validated against the current options</p>
<h2>Categories (Files)</h2>
<p>Group filelink items by category - useful used in conjunction with the filelink plugin to output a list of files in a specific category, also shows this category when you use the search plugin </p>
<h2>Find Files</h2>
<p>Choose a subdirectory from the dropdown, click submit and a list of files in and below that subdirectory will be shown</p>
<p>Uses a cookie to remember the last visited folder (until the browser is closed)</p>
<p>From this page you can View, Add/Edit items. If an item is already in the Files list then it is shown in green together with the published status and Title</p>
<p>Hint: you can copy the path of a file by clicking on the filename. Use this if you have uploaded a new document to replace an old version. Copy the filepath of the new version, click Edit next to the old version and paste the new path into the filepath edit box</p> 
<h2>Help</h2>
<p>this document</p>
<h2>TODO</h2>
<p>Add access rules for viewing with filelink plugin output</p>
<p>File uploads</p>
<p>Attach image to item</p>
<h2>Optional extras</h2>
<ul>
<li><strong>plg_content_filelink.zip</strong> - plugin to add filelinks files to content, using {filelink|4|my document title} syntax for a single file, {filelinkcat|227|my category} syntax for all the files in a category PS. wrap in a div to avoid html errors, only checks item authorisation not category</li>
<li><strong>plg_editors-xtd_filelink.zip</strong> - adds a button to the editor to allow you to insert markup for inserting a filelinks file or filelinks category list of files using a modal dialog to display the files and categories</li>
<li><strong>plg_search_filelinks.zip</strong> - lets you search the description text of your filelinks files</li>
<li><strong>plg_finder_filelinks.zip</strong> - as above for finder. NB. not fully tested</li>
</ul>