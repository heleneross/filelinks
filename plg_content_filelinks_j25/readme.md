# Filelinks plugin

Please make sure you have the **Filelinks Compontent** installed first

## Basic Options

### Icons

Add an icon for the filetype of the item before the link  
the icons are installed in <span class="typewriterb">media/com_filelinks/images</span> when you install the component  
these are 16x16 icons released into the public domain by <a href="http://www.splitbrain.org/projects/file\_icons" target="\_blank">http://www.splitbrain.org/projects/file_icons</a> and you should have most of the icons you need  
they all have the extension as the filename eg. pdf.png so you could add any unusual ones you might need

### New Window

Should the link open in a new window or the current window

### Add description

Add the description of the item after the link

## CSS Styles

### Use CSS

**No** if you want to style the items in your template CSS  
**Yes** if you want to use the default css file installed by the plugin or your own css file

### CSS Path

The default path for the css is <span class="typewriterb">plugins/content/filelinks/filelinks.css</span> but you can change this to point to your customised version so it doesn't get overwritten on plugin update.

## Catlist option

### List style

choices are **ul** - unordered list with bullets or **ol** - ordered list with numbers

### Ordering

The order in which the links are output

### Viewing rules

**category**: the item category takes precedence, so no matter what Access you have on an item the list will only be output if the User has viewing rights for that category. Useful if you have set up categories for registered users.  
**item**: the article Access takes precedence, ignoring the category Access rules. Each item has individual viewing rights.

### Use template

If you choose this option then instead of using the inbuilt list style for output the markup is with a dl (definition list)  
The file used is in <span class="typewriterb">plugins/content/filelinks/tmpl/default.php</span>  
Copy this file to <span class="typewriterb">yourtemplate/html/plg_content_filelinks/default.php</span> and then you can edit the file to give the output you require  
You have *id, url, title, description* in the result set and will have to iterate over the $rows object to get the individual items  
at the end of the foreach loop you should echo the html you want to show. See <span class="typewriter">filelinks.php</span> from lines 51 for the variables you have available

# Filelinks Editors-xtd Button

This allows you to easily insert the markup required by the Filelinks content plugin into any article. The button has no plugin options - it simply calls the modal view of the Filelinks Items.   
Simply position your cursor where you want the link inserted in the editor, click the button and choose the item. You have the normal filters and search for the items.  
Alternatively, click on any Category in the list and category list markup will be added instead.

For a category list the button inserts the markup within a div with a class of filelistcat - this is necessary for the output to validate. Tested on a number of popular content editors but it is not foolproof.  
If you position your cursor within a heading for instance and then add a category list the editor can get confused, so best practice is to position your cursor on a blank line.

## Markup

### Single Filelink

<pre>{filelink|4|the article title}</pre>

The markup is surrounded by curly brackets and the options are separated by a pipe | character with no spaces around the options.  
The first option should be 
<pre>filelink</pre> and the second is a number, the item id.

Next comes the text to be shown for the link - the button inserts this from the item title but you can edit this to read whatever you want if you would like to override the item title.  
Strictly speaking the this option is not required so markup such as 
<pre>{filelink|4}</pre> would also work but when you are looking at an article in article manager it is much easier to work out what the link is for with the title added.

#### Single Filelink options

All extra options should have a pipe between them - please do not leave out the article title if you add extra options. Options can be in any order. The available options at present are:

*   **raw** - outputs just the url, nothing else. All other options are ignored. You can use this if you want to wrap the url in your own html eg. 
    <pre>&lt;a href="{filelink|2|my link}" class="button"&gt;link text&lt;/a&gt;</pre>

*   **icon** - adds the icon before the link for this one item
*   **noicon** - suppresses the icon for this one item
*   **desc** - adds the item description after the link
*   **nodesc** - suppresses the item description

**Valid examples:**

<ul style="list-style-type: none">
  <li>
    <pre>{filelink|4|the item title}</pre>
  </li>
  
  <li>
    <pre>{filelink|4|}</pre>
  </li>
  
  <li>
    <pre>{filelink|4}</pre>
  </li>
  
  <li>
    <pre>{filelink|4|the item title|raw}</pre>
  </li>
  
  <li>
    <pre>{filelink|4||raw}</pre>
  </li>
  
  <li>
    <pre>{filelink|4|the item title|noimg|desc}</pre>
  </li>
  
  <li>
    <pre>{filelink|4||noimg|desc}</pre>
  </li>
</ul>

**Bad examples:**

Invalid in red, the others don't really make sense as they have conflicting options

<ul style="list-style-type: none">
  <li>
    <pre style="color:red">{filelink|4|raw}</pre>
  </li>
  
  <li>
    <pre style="color:red">{file-link|4}</pre>
  </li>
  
  <li>
    <pre style="color:red">{filelink|4|title|icon desc}</pre>
  </li>
  
  <li>
    <pre>{filelink|4|title|icon|raw}</pre>
  </li>
  
  <li>
    <pre>{filelink|4|title|icon|desc|noicon}</pre>
  </li>
</ul>

### Category List

<pre>{filelinkcat|227|a category}</pre>

options are all set in the filelinks plugin - you can however edit the category name if you want to output a different heading. Taking the example above we could edit it to read:

<pre>{filelinkcat|227|File downloads for Registered Users}</pre>

## TODO

*   Descriptions set separately for filelinks and filelinkcat
*   Category list options
*   Choice of template name

