# wp-walker
Wordpress Walker for mega menu navigation


Code of the Navigation with megamenu:

```
<?php
    wp_nav_menu( array(
        'menu'      => ID_OF_THE_MENU, 
        'walker'    => new walkernav(),
    ) );    
?>
```

Sample output of the code above:

```
 <ul>
    <li class="has-children">
      <a>Title</a>
      <div class="megamenu"><!-- MEGAMENU DROPDOWN GOES HERE --></div>
    </li>
 </ul>
```
