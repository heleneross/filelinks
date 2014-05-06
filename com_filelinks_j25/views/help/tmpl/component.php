
<h1 style="margin-left:0">Filelinks Component</h1>

<h2>Getting Started</h2>

<p>There are three essential steps before you start using this component:</p>

<ol>
	<li>Go to options and set the root of your document folder. This is the folder where you store pdfs etc</li>
	<li>In options set the allowed filetypes - this is just the file extension list, separate the extensions with a comma</li>
	<li>Go to Categories (Files) and set at least one Category</li>
</ol>

<h2>Files</h2>

<p>Shows you a list of all the files you have added in this component, if the filepath is shown in red the resource can not be found, if it shown in orange then it has a file extension not set in options.
</p><img src="<?php echo JURI::root();?>media/com_filelinks/help/files.jpg" alt="Files Screen" title="Files screen" />

<p>You can view the files, publish and unpublish them or edit the details</p>

<p>Click on the title of the file to be taken to the edit screen</p>

<h2>Edit File Details</h2>

<ol>
	<li>Title - the name shown when searching for this resource or the friendly name for the link when using the filelink plugin</li>
	<li>File Path - where this resource is located</li>
	<li>Catid - the category for this item</li>
	<li>Description - the text to be searched by the search plugin, a summary of the file contents</li>
	<li>Published - whether this item is currently published</li>
	<li>Access - who has access to the link</li>
</ol>

<p>Warning: If you change the options to a different root document folder and or filetypes you may not be able to edit/save current items as the url is validated against the current options</p>

<h2>Categories (Files)</h2>

<p>Group filelink items by category - useful used in conjunction with the filelink plugin to output a list of files in a specific category, also shows this category when you use the search plugin.</p>

<h2>Find Files</h2>

<p>Choose a subdirectory from the dropdown, click submit and a list of files in and below that subdirectory will be shown, filtered by file extension</p>

<p>Uses a cookie to remember the last visited folder (until the browser is closed)</p>

<p>From this page you can View, Add/Edit items. If an item is already in the Files list then it is shown in green together with the published status and Title
</p><img src="<?php echo JURI::root();?>media/com_filelinks/help/find_files.jpg" alt="Find Files Screen" title="Find Files screen" />

<p>Hint: you can copy the path of a file by clicking on the filename. Use this if you have uploaded a new document to replace an old version. Copy the filepath of the new version, click Edit next to the old version and paste the new path into the filepath edit box
</p><img src="<?php echo JURI::root();?>media/com_filelinks/help/find_files_copy.jpg" alt="Find Files copy" title="Find Files copy" />
<p>You can now upload files (restricted to those types set in options) to the current folder. The filename will be cleaned - strange charcters removed and spaces replaced by hyphens. If the file exists you will be given a warning unless you have checked the overwrite box</p>

<h2>Help</h2>

<p>this document</p>

<h2>TODO</h2>

<ul>
	<li>Attach image to item</li>
	<li>Show files with wrong path in orange</li>
</ul>

<h2>Optional extras</h2>

<ul>
	<li><strong>plg&#95;content&#95;filelink.zip</strong> - plugin to add filelinks files to content, using {filelink|4|my document title} syntax for a single file, {filelinkcat|227|my category} syntax for all the files in a category </li>
	<li><strong>plg&#95;editors-xtd&#95;filelink.zip</strong> - adds a button to the editor to allow you to insert markup for inserting a filelinks file or filelinks category list of files using a modal dialog to display the files and categories</li>
	<li><strong>plg&#95;search&#95;filelinks.zip</strong> - lets you search the description text of your filelinks files</li>
	<li><strong>plg&#95;finder&#95;filelinks.zip</strong> - as above for finder. NB. not fully tested</li>
</ul>
