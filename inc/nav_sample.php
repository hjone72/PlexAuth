<div class="navbar-fixed">
 
<ul id="dropdown" class="dropdown-content">
  <li><a href="https://Plex.tv">Plex</a></li>
  <li><a href="https://requests">Requests</a></li>
  <li><a href="https://Comics.com">Comics</a></li>
  <li><a href="https://htpc">HTPC-Manager</a></li>
  <li><a href="https://sickrage">SickRage</a></li>
  <li><a href="https://couchpotato">CouchPotato</a></li>
  <li><a href="https://sonarr">Sonarr</a></li>
  <li><a href="https://nzbget">NZBGet</a></li>
</ul>

  <nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo">Your Tech Base</a>
      <ul class="right hide-on-med-and-down">
        <li><a class="dropdown-button" href="#!" data-activates="dropdown">Menu<i class="material-icons right">arrow_drop_down</i></a></li>
        <li id="client-username"><?php print $user->attributes()['username']?>&nbsp;</li>
        <li><img src="<?php print $user->attributes()['thumb']?>" alt="" class="circle" id="client-picture"></li>
      </ul>
 
      <ul id="nav-mobile" class="side-nav">
          <li><a href="https://Plex.tv" target="_blank">Plex</a></li>
          <li><a href="https://requests" target="_blank">Requests</a></li>
          <li><a href="https://Comics.com" target="_blank">Comics</a></li>
          <li><a href="https://htpc" target="_blank">HTPC-Manager</a></li>
          <li><a href="https://sickrage" target="_blank">SickRage</a></li>
          <li><a href="https://couchpotato" target="_blank">CouchPotato</a></li>
          <li><a href="https://sonarr" target="_blank">Sonarr</a></li>
          <li><a href="https://nzbget" target="_blank">NZBGet</a></li>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>
     
</div>