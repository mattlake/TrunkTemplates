/** * This template has the following tags available:
* title Article title
* url Permalink of the article
* site Site on which the article was originally published
* posted_at Original posting date
*/
  
<h3>Entry Short List</h3> 
  
<ol id="entry-list"> 
  
// This is the main entry loop
{loop} <li><a href="{url}">{title}</a> (published on {site})</li>
{/loop} 
  
</ol><!-- end #entry-list -->