# Filelinks Component

## Getting Started

There are three essential steps before you start using this component:

1.  Go to options and set the root of your document folder. This is the folder where you store pdfs etc
2.  In options set the allowed filetypes - this is just the file extension list, separate the extensions with a comma
3.  Go to Categories (Files) and set at least one Category

## Files

Shows you a list of all the files you have added in this component, if the filepath is shown in red the resource can not be found

You can view the files, publish and unpublish them or edit the details

Click on the title of the file to be taken to the edit screen

## Edit File Details

1.  Title - the name shown when searching for this resource or the friendly name for the link when using the filelink plugin
2.  File Path - where this resource is located
3.  Catid - the category for this item
4.  Description - the text to be searched by the search plugin, a summary of the file contents
5.  Published - whether this item is currently published

Warning: If you change the options to a different root document folder and or filetypes you may not be able to edit current items as the url is validated against the current options

## Categories (Files)

Group filelink items by category - useful used in conjunction with the filelink plugin to output a list of files in a specific category, also shows this category when you use the search plugin 

## Find Files

Choose a subdirectory from the dropdown, click submit and a list of files in and below that subdirectory will be shown

Uses a cookie to remember the last visited folder (until the browser is closed)

From this page you can View, Add/Edit items. If an item is already in the Files list then it is shown in green together with the published status and Title

Hint: you can copy the path of a file by clicking on the filename. Use this if you have uploaded a new document to replace an old version. Copy the filepath of the new version, click Edit next to the old version and paste the new path into the filepath edit box

## Help

this document

## TODO

* File uploads - not sure I will add this
* Attach image to item

## Optional extras

*   **plg\_content\_filelink.zip** - plugin to add filelinks files to content, using {filelink|4|my document title} syntax for a single file, {filelinkcat|227|my category} syntax for all the files in a category 
*   **plg\_editors-xtd\_filelink.zip** - adds a button to the editor to allow you to insert markup for inserting a filelinks file or filelinks category list of files using a modal dialog to display the files and categories
*   **plg\_search\_filelinks.zip** - lets you search the description text of your filelinks files
*   **plg\_finder\_filelinks.zip** - as above for finder. NB. not fully tested
