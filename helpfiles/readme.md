# Generate the filelinks helpfiles from markdown

Get the markdown library package from [michelf.ca/projects/php-markdown][1]

Create a folder on localhost and extract the package there - then copy this file to that directory and open this file with your browser. In my case this file is in [localhost/michelf/form.html][2]

Browse to the markdown files in the GitHub folder - you need to generate the following and save the source to  
GitHub\filelinks\com\_filelinks\_j25\views\help\tmpl. Add css should be **no**  
The help page of the component will pull all of these in for display.

1.  GitHub\filelinks\com\_filelinks\_j25\readme.md - save as component.php
2.  GitHub\filelinks\plg\_content\_filelinks\_j25\readme.md - save as content.php (this includes the help for plg\_editors-xtd\_filelink\_j25)
3.  GitHub\filelinks\plg\_search\_filelinks_j25\readme.md - save as search.php
4.  GitHub\filelinks\plg\_finder\_filelinks_j25\readme.md - save as finder.php

Also generate a help file for the content plugin:  
GitHub\filelinks\plg\_content\_filelinks\_j25\readme.md - save as GitHub\filelinks\plg\_content\_filelinks\_j25\help.html - this time Add css should be **yes**&lt;/html&gt;

 [1]: http://michelf.ca/projects/php-markdown/
 [2]: http://localhost/michelf/form.html</pre>
